<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\Benchmark;

class Processor
{
    /** @var Reporter[] */
    private $reporters = [];

    /** @var Provider */
    private $provider;

    /**
     * Processor constructor.
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }


    public function addReporter(Reporter $reporter)
    {
        $this->reporters[] = $reporter;
    }

    public function process(Benchmark $benchmarkResult)
    {
        $testResult = $this->provider->getTestResult($benchmarkResult->getMainUrl(), $benchmarkResult->getOtherUrls());
        $benchmarkResult->addTestResult($testResult);

        foreach ($this->reporters as $reporter) {
            $reporter->report($testResult);
        }
    }
}