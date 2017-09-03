<?php


namespace AppBundle\Benchmark\Reporter;


use AppBundle\Benchmark\Reporter;

use AppBundle\Dto\Benchmark;
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

    public function report(Benchmark $result)
    {
        $this->logger->info('Benchmark started at: ' .
            date('Y-m-d H:i:sP', $result->getStartedTimestamp()));
        $this->logger->info($result->getName());
        $this->printSingleResult($result->getUnit(), $result->getResult());

        $this->logger->info('Competition:');
        foreach($result->getOtherResults() as $otherResult) {
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