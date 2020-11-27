<?php

namespace App\Service;

use App\Entity\Report\ShortReport;

class ReportFactory
{
    public static function createReport($dataset, $reportType)
    {
        switch ($reportType) {
            case "short":
                return new ShortReport($dataset);
            default:
                throw new \InvalidArgumentException(sprintf('Can not generate report "%s"', $reportType));
        }
    }
}
