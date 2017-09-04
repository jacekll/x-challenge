<?php

namespace AppBundle\Benchmark\Reporter;


use AppBundle\Benchmark\Reporter;
use AppBundle\Dto\TestResult;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;


class Console implements Reporter, EventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var TestResult[] */
    private $testResults = [];

    private $currentLine = '';

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function report(TestResult $result)
    {
        $this->testResults[] = $result;
        $this->printStr('Benchmark started at: ' .
            date('Y-m-d H:i:sP', $result->getStartTimestamp()));
        $this->finishRow();



        /*
        $this->logger->info($result->getName());
        $this->printSingleResult($result->getUnit(), $result->getMainWebsiteResult());

        $this->printStr('Competition:');
        foreach($result->getWebsiteResults() as $otherResult) {
            $this->printSingleResult($result->getUnit(), $otherResult);
        }
        */
    }

    private function printSingleResult(string $testName, string $unit, WebsiteResult $websiteResult)
    {
        $this->printStr(
            sprintf("%s: %d %s",
                $testName,
                $websiteResult->getValue(),
                $unit
            )
        );
    }

    public function onException()
    {
        $this->wasExceptionThrown = true;
    }

    public function onTerminate()
    {
        if (!$this->testResults) {

            return;
        }

        $this->printHeader();

        $this->printUrl($this->testResults[0]->getMainWebsiteResult()->getUrl());
        foreach($this->testResults as $testResult) {
            $this->printSeparator();
            $this->printSingleResult($testResult->getName(), $testResult->getUnit(), $testResult->getMainWebsiteResult());

        }
        $this->finishRow();

        foreach($this->testResults[0]->getWebsiteResults() as $websiteResult) {
            $this->printUrl($websiteResult->getUrl());
            foreach($this->testResults as $testResult) {
                $this->printSeparator();
                $this->printSingleResult(
                    $testResult->getName(),
                    $testResult->getUnit(),
                    // TODO: move getByUrl to testresult?
                    $testResult->getWebsiteResults()->getByUrl($websiteResult->getUrl())
                );
            }
            $this->finishRow();
        }
    }

    public static function getSubscribedEvents()
    {
        $listeners = array(
            KernelEvents::EXCEPTION => 'onException',
            KernelEvents::TERMINATE => 'onTerminate'
        );

        if (class_exists('Symfony\Component\Console\ConsoleEvents')) {
            $listeners[class_exists('Symfony\Component\Console\Event\ConsoleErrorEvent') ? ConsoleEvents::ERROR :  ConsoleEvents::EXCEPTION] = 'onException';
            $listeners[ConsoleEvents::TERMINATE] = 'onTerminate';
        }

        return $listeners;
    }

    private function printHeader()
    {
        foreach($this->testResults as $testResult) {
            $this->printSeparator();
            $this->printStr($testResult->getName());
        }
        $this->finishRow();
    }

    private function printUrl(Url $getUrl)
    {
        $this->printStr($getUrl->getUrl());
    }

    private function printSeparator()
    {
        $this->printStr("\t");
    }

    private function printStr($string)
    {
        $this->currentLine .= $string;
    }

    private function finishRow()
    {
        $this->logger->info($this->currentLine);
        $this->currentLine = '';
    }
}