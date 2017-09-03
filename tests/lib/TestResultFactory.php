<?php

namespace Tests\lib;

use AppBundle\Dto\TestResult;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;
use AppBundle\Dto\WebsiteResultCollection;

class TestResultFactory
{
    public function getSampleTestResult(): \AppBundle\Dto\TestResult
    {
        return new TestResult(
            0,
            '',
            's',
            new WebSiteResult(new Url('http://blah.com'), 1),
            new WebsiteResultCollection(
                [
                    new WebsiteResult(new Url('http://blah2.com'), 12345),
                    new WebsiteResult(new Url('http://blah3.com'), 12345),
                ]
            )
        );
    }
}