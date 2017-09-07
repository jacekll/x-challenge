<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\TestResult;

interface ConditionVerifier
{
    public function verifyCondition(TestResult $testResult, ReportingCondition $condition) : bool;
}
