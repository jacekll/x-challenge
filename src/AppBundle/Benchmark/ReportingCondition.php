<?php


namespace AppBundle\Benchmark;

/**
 *
 */
interface ReportingCondition
{
    public function isSatisfied(float $mainValue, float $competitorValue): bool;
}