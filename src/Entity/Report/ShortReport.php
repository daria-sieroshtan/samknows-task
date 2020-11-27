<?php

namespace App\Entity\Report;

use App\Entity\Statistic\StatisticCollection;
use App\Service\Insights\UnderperformingPeriodsCalculator;
use App\Service\Statistics\StatisticCalculator;
use App\Service\Statistics\StatisticFormatter;
use App\Service\Statistics\UnitConverter;

class ShortReport
{
    const HEADING = 'SamKnows Metric Analyser v1.0.0' . PHP_EOL . '===============================' . PHP_EOL . PHP_EOL;
    const SIMPLE_STATISTICS = ["getAverage", "getMin", "getMax", "getMedian"];
    const TIME_AXIS_NAME = 'dtime';
    const METRIC_VALUE_NAME = 'metricValue';

    protected $dataset;
    protected $statisticSummary;
    protected $renderedReport;

    public function __construct($dataset)
    {
        $this->dataset = $dataset;
        $this->statisticSummary = $this->calculateStatisticSummary();
    }

    protected function getStatisticSummary()
    {
        return $this->statisticSummary;
    }

    protected function calculateStatisticSummary()
    {
        $summary = new StatisticCollection();

        foreach (self::SIMPLE_STATISTICS as $statisticMethod) {
            $summary->addStatistic(StatisticCalculator::$statisticMethod($this->dataset[self::METRIC_VALUE_NAME]));
        }

        return $summary;
    }

    /**
     * @return array
     */
    protected function getUnderperformingPeriods()
    {
        return UnderperformingPeriodsCalculator::calculateUnderperformingPeriods(
            $this->dataset[self::TIME_AXIS_NAME],
            $this->dataset[self::METRIC_VALUE_NAME],
            $this->statisticSummary
        );
    }

    public function getRenderedReport()
    {
        if ($this->renderedReport === null) {
            $this->createRenderedReport();
        }
        return $this->renderedReport;
    }

    public function createRenderedReport()
    {
        $this->renderedReport = self::HEADING;
        $this->renderedReport .= $this->renderPeriodSection();
        $this->renderedReport .= $this->renderStatisticsSection();
        $this->renderedReport .= $this->renderUnderperformingPeriodsSection();
    }

    protected function renderPeriodSection()
    {
        return sprintf(
            "Period checked:" . PHP_EOL . PHP_EOL .
                "\tFrom: %s" . PHP_EOL . "\tTo:   %s" . PHP_EOL . PHP_EOL,
            min($this->dataset[self::TIME_AXIS_NAME]),
            max($this->dataset[self::TIME_AXIS_NAME])
        );
    }

    protected function renderStatisticsSection()
    {
        $formatter = new StatisticFormatter();
        $unitConverter = function ($value) {
            return UnitConverter::convertBytesToMegabites($value);
        };
        $result = 'Statistics:' . PHP_EOL .  PHP_EOL;

        $result .= "\tUnit: Megabits per second" . PHP_EOL .  PHP_EOL;

        foreach ($this->getStatisticSummary()->getStatistics() as $statistic) {
            $result .= $formatter->format($statistic, $unitConverter);
        }

        $result .= PHP_EOL;
        return $result;
    }

    protected function renderUnderperformingPeriodsSection()
    {
        $result = "";
        $periods = $this->getUnderperformingPeriods();
        if (count($periods) > 0) {
            $result = 'Under-performing periods:' . PHP_EOL .  PHP_EOL;

            foreach ($periods as $period) {
                $result .= $period->getFormatted();
            }
        }

        return $result;
    }
}
