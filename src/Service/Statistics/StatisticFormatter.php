<?php

namespace App\Service\Statistics;

use App\Entity\Statistic\Statistic;

class StatisticFormatter
{
    public static function format(Statistic $statistic, \Closure $converterCallback = null)
    {
        if ($converterCallback) {
            $value = $converterCallback($statistic->getValue());
        } else {
            $value = $statistic->getValue();
        }
        return sprintf("\t%s: %s", $statistic->getName(), round($value, 2)) . PHP_EOL;
    }
}
