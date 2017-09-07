<?php


namespace AppBundle\Benchmark;

/**
 * Returns a human-readable comparison between values
 */
interface ValueComparator
{
    public function getComparison(float $originalValue, float $compareValue, string $unit): string;
}