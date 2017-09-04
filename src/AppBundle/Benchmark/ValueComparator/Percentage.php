<?php


namespace AppBundle\Benchmark\ValueComparator;

use AppBundle\Benchmark\ValueComparator;

class Percentage implements ValueComparator
{
    public function getComparison(float $originalValue, float $compareValue, string $unit)
    {
        if ($originalValue < 0 || $compareValue < 0) {
            throw new \InvalidArgumentException('Expected values greater or equal to 0');
        }

        return $originalValue == 0.0 ? sprintf(is_int($compareValue) ? '%+d %s' : '%+.2f %s', $compareValue, $unit)
            : sprintf('%+d%%', 100 * ($compareValue - $originalValue) / $originalValue);
    }

}