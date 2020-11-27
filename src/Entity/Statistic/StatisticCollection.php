<?php

namespace App\Entity\Statistic;

class StatisticCollection
{
    private $statistics = [];

    public function addStatistic(Statistic $statistic)
    {
        $this->statistics[] = $statistic;
    }

    public function getStatistics()
    {
        return $this->statistics;
    }

    public function getStatisticValueByName($name)
    {
        foreach ($this->statistics as $statistic) {
            if ($name === $statistic->getName()) {
                return $statistic->getValue();
            }
        }

        throw new \RuntimeException(sprintf('Statistics %s can not be found in the statistic summaty.', $name));
    }
}
