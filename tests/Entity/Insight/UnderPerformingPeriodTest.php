<?php

namespace App\Tests\Entity\Insight;

use App\Entity\Insight\UnderPerformingPeriod;
use PHPUnit\Framework\TestCase;

class UnderPerformingPeriodTest extends TestCase
{
    protected function getSut()
    {
        return new UnderPerformingPeriod();
    }

    public function testShouldFormatPeriod()
    {
        $period = $this->getSut();
        $period->setStartDate('2018-01-12');
        $period->setEndDate('2018-01-13');

        $this->assertEquals(
            "\t* The period between 2018-01-12 and 2018-01-13" . PHP_EOL . "\t was under-performing." . PHP_EOL . PHP_EOL,
            $period->getFormatted()
        );
    }

    public function testShouldFormatSingleMomentPeriod()
    {
        $period = $this->getSut();
        $period->setStartDate('2018-01-12');
        $period->setEndDate('2018-01-12');

        $this->assertEquals(
            "\t* 2018-01-12 was under-performing period." . PHP_EOL . PHP_EOL,
            $period->getFormatted()
        );
    }
}
