<?php

namespace AppBundle\Benchmark;

use AppBundle\Dto\TestResult;
use AppBundle\Dto\Url;
use AppBundle\Dto\UrlCollection;
use AppBundle\Dto\WebsiteResultCollection;

class Provider
{
    /** @var string */
    private $benchmarkName;

    /** @var WebsiteResultProvider */
    private $websiteResultProvider;

    /**
     * Provider constructor.
     * @param string $benchmarkName
     * @param WebsiteResultProvider $websiteResultProvider
     */
    public function __construct(string $benchmarkName, WebsiteResultProvider $websiteResultProvider)
    {
        $this->benchmarkName = $benchmarkName;
        $this->websiteResultProvider = $websiteResultProvider;
    }

    public function getTestResult(Url $url, UrlCollection $otherUrls): TestResult
    {
        $startTimestamp = time();
        $websiteResults = new WebsiteResultCollection();
        foreach ($otherUrls as $otherUrl) {
            $websiteResults->add($this->websiteResultProvider->getWebsiteResult($otherUrl));
        }

        return new TestResult(
            $startTimestamp,
            $this->websiteResultProvider->getTestName(),
            $this->websiteResultProvider->getUnit(),
            $this->websiteResultProvider->getWebsiteResult($url),
            $websiteResults
        );

    }

}