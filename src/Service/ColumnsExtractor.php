<?php

namespace App\Service;

use App\Service\Exception\InputFileInvalidFormatException;

class ColumnsExtractor
{
    public function extractColumns(array $input)
    {
        $numberOfDataPoints = count($input);

        $result =  [
            'dtime' => array_column($input, 'dtime'),
            'metricValue' => array_column($input, 'metricValue'),
        ];

        if (count($result['dtime']) < $numberOfDataPoints || count($result['metricValue']) < $numberOfDataPoints) {
            throw new InputFileInvalidFormatException();
        }

        return $result;
    }
}
