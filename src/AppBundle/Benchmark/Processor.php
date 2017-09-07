<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\Benchmark;
use Psr\Log\LoggerInterface;

/**
 * Runs and reports a single sub-benchmark (single test for many websites)
 */
class Processor
{
    /** @var Reporter[] */
    private $reporters = [];

    /** @var Provider */
    private $provider;

    /** @var LoggerInterface $logger */
    private $logger;

    public function __construct(Provider $provider, LoggerInterface $logger)
    {
        $this->provider = $provider;
        $this->logger = $logger;
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
            try {
                $reporter->report($testResult);
            } catch (\Throwable $e) {
                $this->logger->error(sprintf('Benchmark reporter failed: %s', $e->getMessage()), ['exception' => $e]);
            }
        }
    }
}