<?php

namespace AppBundle\Benchmark\ConditionVerifier;

use AppBundle\Benchmark\ConditionVerifier;
use AppBundle\Benchmark\ReportingCondition;
use AppBundle\Dto\TestResult;

/**
 * If at least one competitor satisfies the condition, reports the condition as verified
 */
class AtLeastOneCompetitorSatisfies implements ConditionVerifier
{
    public function verifyCondition(TestResult $testResult, ReportingCondition $condition): bool
    {
        foreach($testResult->getWebsiteResults() as $otherResult) {
            if ($condition->isSatisfied(
                $testResult->getMainWebsiteResult()->getValue(),
                $otherResult->getValue()
            )) {

                return true;
            }

        }

        return false;
    }
}
