<?php

namespace AppBundle\Benchmark\WebsiteResultProvider;

use AppBundle\Benchmark\PageLoadTimer;
use AppBundle\Benchmark\WebsiteResultProvider;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;

class Timer implements WebsiteResultProvider
{
    /**
     * {@inheritdoc}
     */
    public function getTestName(): string
    {
        return 'Page load time'; // TODO: inject?
    }

    public function getWebsiteResult(Url $url): WebsiteResult
    {
        $pageLoadTimer = new PageLoadTimer();

        return new WebsiteResult($url, $pageLoadTimer->getPageLoadTime($url->getUrl()));
    }

    /**
     * {@inheritdoc}
     */
    public function getUnit(): string
    {
        return 'ms';
    }
}