<?php

namespace AppBundle\Benchmark\Reporter;

use AppBundle\Benchmark\Reporter;
use AppBundle\Benchmark\ValueComparator;
use AppBundle\Dto\TestResult;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;
use AppBundle\Table\Formatter;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;


class Console implements Reporter, EventSubscriberInterface
{
    /** @var Formatter */
    private $formatter;

    /** @var TestResult[] */
    private $testResults = [];

    /** @var ValueComparator */
    private $valueComparator;

    public function __construct(Formatter $formatter, ValueComparator $valueComparator)
    {
        $this->formatter = $formatter;
        $this->valueComparator = $valueComparator;
    }

    public function report(TestResult $result)
    {
        $this->testResults[] = $result;
    }

    private function printSingleResult(string $testName, string $unit, WebsiteResult $websiteResult)
    {
        $this->printCell(
            sprintf("%s: %d %s",
                $testName,
                $websiteResult->getValue(),
                $unit
            )
        );
    }

    private function printSingleComparisonResult(string $testName, string $unit, WebsiteResult $originalResult, WebsiteResult $websiteResult)
    {
        $this->printCell(
            sprintf("%s: %d %s (%s)",
                $testName,
                $websiteResult->getValue(),
                $unit,
                $this->valueComparator->getComparison($originalResult->getValue(), $websiteResult->getValue(), $unit)
            )
        );
    }

    /**
     * prints tests results in columns
     */
    public function onTerminate()
    {
        if (!$this->testResults) {

            return;
        }

        $this->printStartDateHeader($this->testResults[0]);

        $this->printUrl($this->testResults[0]->getMainWebsiteResult()->getUrl());
        foreach($this->testResults as $testResult) {
            $this->printSingleResult($testResult->getName(), $testResult->getUnit(), $testResult->getMainWebsiteResult());

        }
        $this->finishRow();

        foreach($this->testResults[0]->getWebsiteResults() as $websiteResult) {
            $this->printUrl($websiteResult->getUrl());
            foreach($this->testResults as $testResult) {
                $this->printSingleComparisonResult(
                    $testResult->getName(),
                    $testResult->getUnit(),
                    $testResult->getMainWebsiteResult(),
                    $testResult->getWebsiteResults()->getByUrl($websiteResult->getUrl())
                );
            }
            $this->finishRow();
        }
    }

    public static function getSubscribedEvents()
    {
        $listeners = array(
            KernelEvents::TERMINATE => 'onTerminate'
        );

        if (class_exists('Symfony\Component\Console\ConsoleEvents')) {
            $listeners[ConsoleEvents::TERMINATE] = 'onTerminate';
        }

        return $listeners;
    }

    private function printStartDateHeader(TestResult $result)
    {
        $this->printCell('Benchmark started at: ');
        $this->printCell(date('Y-m-d H:i:sP', $result->getStartTimestamp()));
        $this->finishRow();
    }

    private function printUrl(Url $getUrl)
    {
        $this->printCell($getUrl->getUrl());
    }

    private function finishRow()
    {
        $this->formatter->finishRow();
    }

    private function printCell(string $content)
    {
        $this->formatter->addCell($content);
    }
}