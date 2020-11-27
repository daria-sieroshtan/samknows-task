<?php

namespace App\Service\Insights;

use App\Entity\Insight\UnderPerformingPeriod;
use App\Entity\Statistic\StatisticCollection;

class UnderperformingPeriodsCalculator
{
    const UNDERPERFORMANCE_THRESHOLD_STATISTIC = 'Average';
    const UNDERPERFORMANCE_THRESHOLD_COEFF = 0.8;

    public static function calculateUnderperformingPeriods(array $dateAxis, array $performanceMetricData, StatisticCollection $statisticSummary)
    {
        $result = [];
        $underperformingMoments = self::calculateUnderperformingMoments($performanceMetricData, $statisticSummary);
        if (count($underperformingMoments) > 0) {
            $result = self::combineMomentsIntoPeriods($dateAxis, $underperformingMoments);
        }

        return $result;
    }

    protected static function calculateUnderperformingMoments(array $performanceMetricData, StatisticCollection $statisticSummary)
    {
        $result = [];
//       for now the logic of under-performance detecting is just basic assumption, it should be based on the actual business requirements
        $threshold = self::calculateUnderperformanceThreshhold($statisticSummary);
        foreach ($performanceMetricData as $value) {
            if ($value < $threshold) {
                $result = array_merge($result, array_keys($performanceMetricData, $value));
            }
        }

        $result = array_unique($result);
        sort($result);
        return $result;
    }

    protected static function calculateUnderperformanceThreshhold(StatisticCollection $statisticSummary)
    {
        return $statisticSummary->getStatisticValueByName(self::UNDERPERFORMANCE_THRESHOLD_STATISTIC) * self::UNDERPERFORMANCE_THRESHOLD_COEFF;
    }

    protected static function combineMomentsIntoPeriods(array $dateAxis, array $momentsIndexes)
    {
        $result = [];
        $currentPeriod = new UnderPerformingPeriod();
        $tempEndIndex = 0;
        foreach ($momentsIndexes as $momentIndex) {
            //  exists open period
            if ($currentPeriod->getStartDate()) {
                // already in this period
                if ($momentIndex < $tempEndIndex) {
                    continue;
                    // adjacent point, add to period
                } elseif (($momentIndex - $tempEndIndex) == 1) {
                    $tempEndIndex = $momentIndex;
                    // close current period and initiate new
                } else {
                    $currentPeriod->setEndDate($dateAxis[$tempEndIndex]);
                    $result[] = $currentPeriod;
                    $currentPeriod = new UnderPerformingPeriod();
                    $currentPeriod->setStartDate($dateAxis[$momentIndex]);
                    $tempEndIndex = $momentIndex;
                }
                // initiate period
            } else {
                $currentPeriod->setStartDate($dateAxis[$momentIndex]);
                $tempEndIndex = $momentIndex;
            }
        }
        $currentPeriod->setEndDate($dateAxis[$tempEndIndex]);
        $result[] = $currentPeriod;

        return $result;
    }
}
