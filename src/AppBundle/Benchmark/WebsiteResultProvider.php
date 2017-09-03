<?php

namespace AppBundle\Benchmark;


use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;

interface WebsiteResultProvider
{
    public function getWebsiteResult(Url $url): WebsiteResult;

    public function getUnit(): string;
}