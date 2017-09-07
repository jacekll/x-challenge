<?php

namespace AppBundle\Benchmark;


use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;

/**
 * Implement for actual test against a single website
 */
interface WebsiteResultProvider
{
    /**
     * Human-readable test name to use as a default
     * @return string
     */
    public function getTestName(): string;

    /**
     * Returns the units of measure for the result from getWebsiteResult()
     * @return string
     */
    public function getUnit(): string;

    /**
     * Gets the benchmark result for the URL
     * @param Url $url
     * @return WebsiteResult
     */
    public function getWebsiteResult(Url $url): WebsiteResult;
}