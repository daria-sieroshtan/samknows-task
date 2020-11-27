<?php

namespace App\Service\Statistics;

use App\Entity\Statistic\Statistic;

class StatisticCalculator
{
    /**
     * @param $values array
     * @return Statistic
     */
    public static function getMin($values)
    {
        $statistic = new Statistic();
        $statistic->setName('Min');
        $statistic->setValue(min($values));

        return $statistic;
    }

    /**
     * @param $values array
     * @return Statistic
     */
    public static function getMax($values)
    {
        $statistic = new Statistic();
        $statistic->setName('Max');
        $statistic->setValue(max($values));

        return $statistic;
    }

    /**
     * @param $values array
     * @return Statistic
     */
    public static function getAverage($values)
    {
        $statistic = new Statistic();
        $statistic->setName('Average');
        $a = array_filter($values, function ($x) {
            return $x !== '';
        });
        $statistic->setValue(array_sum($a) / count($a));

        return $statistic;
    }

    /**
     * @param $values array
     * @return Statistic
     */
    public static function getMedian($values)
    {
        $statistic = new Statistic();
        $statistic->setName('Median');

        sort($values);
        $index = intval(floor(count($values) / 2));
        if (count($values) == 0) {
            $median = false;
        } elseif (count($values) & 1) {
            $median =  $values[$index];
        } else {
            $median =  ($values[$index - 1] + $values[$index]) / 2;
        }

        $statistic->setValue($median);

        return $statistic;
    }
}
