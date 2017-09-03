<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\Benchmark;

interface Reporter
{
    public function report(Benchmark $result);
}
