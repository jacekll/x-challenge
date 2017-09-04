<?php


namespace AppBundle\Benchmark;


interface ValueComparator
{
    public function getComparison(float $originalValue, float $compareValue, string $unit);
}