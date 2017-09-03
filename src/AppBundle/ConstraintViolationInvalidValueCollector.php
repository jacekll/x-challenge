<?php

namespace AppBundle;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationInvalidValueCollector
{
    /**
     * @param ConstraintViolationListInterface $violations
     * @return array
     */
    public function getInvalidValues(ConstraintViolationListInterface $violations)
    {
        $invalidValues = [];
        /** @var ConstraintViolationInterface $violation */
        foreach($violations as $violation) {
            $invalidValues[] = $violation->getInvalidValue();
        }

        return $invalidValues;
    }
}