<?php


namespace AppBundle\Benchmark;


use AppBundle\Dto\Benchmark;

interface ConditionVerifier
{
    public function verifyCondition(Benchmark $benchmark, ReportingCondition $condition);
}