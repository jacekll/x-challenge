<?php

namespace AppBundle\Benchmark\Reporter;


use AppBundle\Benchmark\Reporter;
use AppBundle\Dto\TestResult;
use AppBundle\Dto\WebsiteResult;
use Psr\Log\LoggerInterface;


class Console implements Reporter
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function report(TestResult $result)
    {
        $this->logger->info('Benchmark started at: ' .
            date('Y-m-d H:i:sP', $result->getStartTimestamp()));
        $this->logger->info($result->getName());
        $this->printSingleResult($result->getUnit(), $result->getMainWebsiteResult());

        $this->logger->info('Competition:');
        foreach($result->getWebsiteResults() as $otherResult) {
            $this->printSingleResult($result->getUnit(), $otherResult);
        }
    }

    private function printSingleResult(string $unit, WebsiteResult $websiteResult)
    {
        $this->logger->info(
            sprintf("%d %s\t%s",
                $websiteResult->getValue(),
                $unit,
                $websiteResult->getUrl()->getUrl()
            )
        );
    }

}