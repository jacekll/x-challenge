<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\TestResult;

interface Reporter
{
    /**
     * Sends/outputs tests results
     */
    public function report(TestResult $result) : void;
}
