<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\TestResult;

interface Reporter
{
    public function report(TestResult $result);
}
