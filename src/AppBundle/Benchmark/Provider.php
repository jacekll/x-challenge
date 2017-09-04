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
     * @param string $benchmarkName human-readable benchmark name to override the default name given from provider, optional
     * @param WebsiteResultProvider $websiteResultProvider
     */
    public function __construct(WebsiteResultProvider $websiteResultProvider, string $benchmarkName = null)
    {
        $this->benchmarkName = $benchmarkName;
        $this->websiteResultProvider = $websiteResultProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getTestResult(Url $url, UrlCollection $otherUrls): TestResult
    {
        $startTimestamp = time();
        $websiteResults = new WebsiteResultCollection();
        foreach ($otherUrls as $otherUrl) {
            $websiteResults->add($this->websiteResultProvider->getWebsiteResult($otherUrl));
        }

        return new TestResult(
            $startTimestamp,
            $this->benchmarkName ?? $this->websiteResultProvider->getTestName(),
            $this->websiteResultProvider->getUnit(),
            $this->websiteResultProvider->getWebsiteResult($url),
            $websiteResults
        );

    }

}