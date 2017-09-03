<?php

namespace AppBundle\Dto;

class Benchmark
{
    /** @var int */
    private $startedTimestamp;

    /** @var Url */
    private $mainUrl;

    /** @var UrlCollection */
    private $otherUrls;

    /** @var TestResult[] */
    private $testResults = [];

    public function __construct(
        int $startTime,
        Url $mainUrl,
        UrlCollection $otherUrls
    )
    {
        $this->startedTimestamp = $startTime;
        $this->mainUrl = $mainUrl;
        $this->otherUrls = $otherUrls;
    }

    public function addTestResult(TestResult $testResult)
    {
        $this->testResults[] = $testResult;
    }

    /**
     * @return TestResult[]
     */
    public function getTestResults(): array
    {
        return $this->testResults;
    }

    /**
     * @return int
     */
    public function getStartedTimestamp(): int
    {
        return $this->startedTimestamp;
    }

    /**
     * @return Url
     */
    public function getMainUrl(): Url
    {
        return $this->mainUrl;
    }

    /**
     * @return UrlCollection
     */
    public function getOtherUrls(): UrlCollection
    {
        return $this->otherUrls;
    }

}