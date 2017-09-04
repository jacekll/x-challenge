<?php

namespace AppBundle\Benchmark\WebsiteResultProvider;

use AppBundle\Benchmark\PageLoadTimer;
use AppBundle\Benchmark\WebsiteResultProvider;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;

class Timer implements WebsiteResultProvider
{
    /** @var PageLoadTimer */
    private $pageLoadTimer;

    public function __construct(PageLoadTimer $pageLoadTimer)
    {
        $this->pageLoadTimer = $pageLoadTimer;
    }

    /**
     * {@inheritdoc}
     */
    public function getTestName(): string
    {
        return 'Page load time';
    }

    public function getWebsiteResult(Url $url): WebsiteResult
    {
        return new WebsiteResult($url, $this->pageLoadTimer->getPageLoadTime($url->getUrl()));
    }

    /**
     * {@inheritdoc}
     */
    public function getUnit(): string
    {
        return 'ms';
    }
}