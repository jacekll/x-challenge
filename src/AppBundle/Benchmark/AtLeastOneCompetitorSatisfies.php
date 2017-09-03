<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\Benchmark;

class AtLeastOneCompetitorSatisfies implements ConditionVerifier
{
    public function verifyCondition(Benchmark $benchmark, ReportingCondition $condition)
    {
        foreach($benchmark->getOtherResults() as $otherResult) {
            if ($condition->isSatisfied(
                $benchmark->getResult()->getValue(),
                $otherResult->getValue()
            )) {

                return true;
            }

        }

        return false;
    }
}
