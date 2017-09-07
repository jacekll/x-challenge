<?php

namespace AppBundle\Benchmark\Reporter;

use AppBundle\Benchmark\ConditionVerifier\AtLeastOneCompetitorSatisfies;
use AppBundle\Benchmark\ConditionVerifier;
use AppBundle\Benchmark\Reporter;
use AppBundle\Benchmark\ReportingCondition;
use AppBundle\Dto\TestResult;

/**
 * Conditional reporter. Only runs the inner reporter when the given condition is met.
 *
 * Decorator pattern for Reporter interface.
 */
class ConditionalDecorator implements Reporter
{
    /** @var ConditionVerifier */
    private $conditionVerifier;

    /** @var ReportingCondition */
    private $condition;

    /** @var Reporter */
    private $reporter;

    /**
     * Conditional constructor.
     * @param ReportingCondition $condition
     * @param Reporter $reporter
     * @param ConditionVerifier|null $conditionVerifier defaults to AtLeastOneCompetitorSatisfies
     */
    public function __construct(ReportingCondition $condition, Reporter $reporter, ConditionVerifier $conditionVerifier = null)
    {
        $this->condition = $condition;
        $this->reporter = $reporter;
        $this->conditionVerifier = $conditionVerifier ?? new AtLeastOneCompetitorSatisfies();
    }

    public function report(TestResult $result): void
    {
        if ($this->conditionVerifier->verifyCondition($result, $this->condition)) {
            $this->reporter->report($result);
        }
    }

}