<?php

namespace AppBundle\Benchmark;


use Symfony\Component\Validator\ConstraintViolationListInterface;

class IncorrectUrlsException extends \RuntimeException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }

}