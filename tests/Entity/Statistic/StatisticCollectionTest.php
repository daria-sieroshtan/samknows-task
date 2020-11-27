<?php


namespace App\Tests\Entity\Statistic;

use App\Entity\Statistic\Statistic;
use App\Entity\Statistic\StatisticCollection;
use PHPUnit\Framework\TestCase;

class StatisticCollectionTest extends TestCase
{
    protected function getSut()
    {
        return new StatisticCollection();
    }

    protected function getStatistic()
    {
        $statistic =new Statistic();
        $statistic->setName('Min');
        $statistic->setValue(10);

        return $statistic;
    }

    public function testShouldBeAbleToAddStatistic()
    {
        $statistic = $this->getStatistic();
        $sut = $this->getSut();
        $sut->addStatistic($statistic);
        $this->assertEquals($sut->getStatistics(), [$statistic]);
    }

    public function testShouldBeAbleToGetStatisticValueByName()
    {
        $statistic = $this->getStatistic();
        $sut = $this->getSut();
        $sut->addStatistic($statistic);
        $this->assertEquals(10, $sut->getStatisticValueByName('Min'));
    }

    public function testShouldThrowExceptionIfUnexisitngStatistic()
    {
        $sut = $this->getSut();
        $sut->addStatistic($this->getStatistic());

        $this->expectException(\RuntimeException::class);
        $this->getSut()->getStatisticValueByName('Max');
    }
}
