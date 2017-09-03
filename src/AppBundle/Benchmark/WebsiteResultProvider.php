<?php

namespace AppBundle\Benchmark;


use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;

interface WebsiteResultProvider
{
    public function getTestName(): string;

    public function getUnit(): string;

    public function getWebsiteResult(Url $url): WebsiteResult;
}