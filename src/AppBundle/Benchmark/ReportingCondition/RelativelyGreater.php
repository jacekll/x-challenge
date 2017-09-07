<?php

namespace AppBundle\Benchmark\ReportingCondition;


use AppBundle\Benchmark\ReportingCondition;

/**
 * Returns true when at least one competitor website value is greater than or equal
 * than given percent value; For example: 100 % - competitor value twice as big as original website
 */
class RelativelyGreater implements ReportingCondition
{
    /** @var int|float */
    private $byPercent = 0;

    /**
     * RelativelyGreater constructor.
     * @param float|int $byPercent
     */
    public function __construct($byPercent = 0)
    {
        $this->byPercent = $byPercent;
    }

    public function isSatisfied(?float $mainValue, ?float $competitorValue): bool
    {
        if ($mainValue === null || $competitorValue === null) {

            return false;
        }
        if ($competitorValue == 0.0 && $mainValue > 0.0) {

            return true;
        } elseif ($competitorValue == 0.0) {

            return false;
        }
        return (100 * ($mainValue - $competitorValue) / $competitorValue >= $this->byPercent);
    }
}
