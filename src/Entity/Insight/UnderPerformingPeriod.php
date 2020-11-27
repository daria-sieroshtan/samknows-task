<?php

namespace App\Entity\Insight;

class UnderPerformingPeriod
{
    private $startDate;
    private $endDate;

    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param $startDate string
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param $endDate string
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getFormatted()
    {
        if ($this->getStartDate() == $this->getEndDate()) {
            return (sprintf(
                "\t* %s was under-performing period." . PHP_EOL . PHP_EOL,
                $this->getStartDate()
            ));
        }

        return sprintf(
            "\t* The period between %s and %s" . PHP_EOL . "\t was under-performing." . PHP_EOL . PHP_EOL,
            $this->getStartDate(),
            $this->getEndDate()
        );
    }
}
