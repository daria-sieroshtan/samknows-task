<?php


namespace App\Tests\Entity\Report;

use App\Entity\Report\ShortReport;
use App\Service\Statistics\StatisticCalculator;
use PHPUnit\Framework\TestCase;

class ShortReportTest extends TestCase
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

    const PERFORMANCE_METRIC = [1,2,3,20,4,5,40,5];

    const EXPECTED_RENDERED_REPORT =
        "SamKnows Metric Analyser v1.0.0" . PHP_EOL .
        "===============================" . PHP_EOL . PHP_EOL.
        "Period checked:" . PHP_EOL . PHP_EOL .
        "\tFrom: 2018-01-12" . PHP_EOL . "\tTo:   2018-01-19" . PHP_EOL . PHP_EOL .
        'Statistics:' . PHP_EOL .  PHP_EOL .
        "\tUnit: Megabits per second" . PHP_EOL .  PHP_EOL .
        "\tAverage: 10" . PHP_EOL .
        "\tMin: 1" . PHP_EOL .
        "\tMax: 40" . PHP_EOL .
        "\tMedian: 4.5" . PHP_EOL . PHP_EOL .
        "Under-performing periods:" . PHP_EOL . PHP_EOL .

        "\t* The period between 2018-01-12 and 2018-01-14" . PHP_EOL . "\t was under-performing." . PHP_EOL . PHP_EOL .
        "\t* The period between 2018-01-16 and 2018-01-17" . PHP_EOL . "\t was under-performing." . PHP_EOL . PHP_EOL .
        "\t* 2018-01-19 was under-performing period." . PHP_EOL . PHP_EOL;

    // this is just a backward megabits->bytes conversion for the sake of small test numbers
    protected function getPerformanceMetric()
    {
        return array_map(function ($a) {
            return $a * 131072;
        }, self::PERFORMANCE_METRIC);
    }

    public function testShouldReturnRenderedReport()
    {
        $report = new ShortReport([
            'dtime' => self::DATE_AXIS,
            'metricValue' => $this->getPerformanceMetric(),
        ]);

        $this->assertEquals(
            self::EXPECTED_RENDERED_REPORT,
            $report->getRenderedReport()
        );
    }
}
