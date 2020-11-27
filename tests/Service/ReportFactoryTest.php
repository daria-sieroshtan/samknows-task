<?php


namespace App\Tests\Service;

use App\Entity\Report\ShortReport;
use App\Service\ReportFactory;
use PHPUnit\Framework\TestCase;

class ReportFactoryTest extends TestCase
{
    const DATASET = [
        'dtime' => [],
        'metricValue' => [1,2,3],
    ];

    protected function getSut()
    {
        return new ReportFactory();
    }

    public function testShouldThrowExceptionIfUnknownReport()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->getSut()->createReport([], 'ImpossibleReport');
    }

    public function testShouldCreateShortReport()
    {
        $this->assertTrue($this->getSut()->createReport(self::DATASET, 'short') instanceof ShortReport);
    }
}
