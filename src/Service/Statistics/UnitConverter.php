<?php

namespace App\Service\Statistics;

class UnitConverter
{
    public static function convertBytesToMegabites($value)
    {
        return $value / 131072;
    }
}
