<?php


namespace App\Tests\Service\Insights;

use App\Entity\Insight\UnderPerformingPeriod;
use App\Entity\Statistic\Statistic;
use App\Entity\Statistic\StatisticCollection;
use App\Service\Insights\UnderperformingPeriodsCalculator;
use PHPUnit\Framework\TestCase;

class UnderperformingPeriodsCalculatorTest extends TestCase
{
    const DATE_AXIS = [
        '2018-01-12',
        '2018-01-13',
        '2018-01-14',
        '2018-01-15',
        '2018-01-16',
        '2018-01-17',
        '2018-01-18',
        '2018-01-19'
    ];

    const PERFORMANCE_METRIC = [1,2,3,20,4,5,30,6];

    protected function getSut()
    {
        return new UnderperformingPeriodsCalculator();
    }

    protected function getStatisticSummary()
    {
        $summary = new StatisticCollection();
        $statistic = new Statistic();
        $statistic->setName('Average');
        $statistic->setValue(10);
        $summary->addStatistic($statistic);

        return $summary;
    }

    protected function getExpectedUnderferformingPeriods()
    {
        $longPeriod = new UnderPerformingPeriod();
        $longPeriod->setStartDate('2018-01-12');
        $longPeriod->setEndDate('2018-01-14');

        $middlePeriod = new UnderPerformingPeriod();
        $middlePeriod->setStartDate('2018-01-16');
        $middlePeriod->setEndDate('2018-01-17');

        $shortPeriod = new UnderPerformingPeriod();
        $shortPeriod->setStartDate('2018-01-19');
        $shortPeriod->setEndDate('2018-01-19');

        return [$longPeriod, $middlePeriod, $shortPeriod];
    }

    public function testShouldCalculateUnderperformingPeriods()
    {
        $this->assertEquals(
            $this->getExpectedUnderferformingPeriods(),
            $this->getSut()->calculateUnderperformingPeriods(self::DATE_AXIS, self::PERFORMANCE_METRIC, $this->getStatisticSummary())
        );
    }
}
