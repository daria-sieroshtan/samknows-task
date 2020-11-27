<?php

namespace App\Entity\Statistic;

class Statistic
{
    protected $name;
    protected $value;

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }
}
