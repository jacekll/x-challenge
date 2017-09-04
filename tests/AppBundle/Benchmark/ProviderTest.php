<?php

namespace Tests\AppBundle\Benchmark;

use AppBundle\Benchmark\Provider;
use AppBundle\Benchmark\WebsiteResultProvider;
use AppBundle\Dto\TestResult;
use AppBundle\Dto\Url;
use AppBundle\Dto\UrlCollection;
use AppBundle\Dto\WebsiteResult;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTestResult()
    {
        /** @var WebsiteResultProvider|\PHPUnit_Framework_MockObject_MockObject $websiteResultProviderStub */
        $websiteResultProviderStub = self::getMockBuilder(
            WebsiteResultProvider::class
        )->getMockForAbstractClass();

        $websiteResultProviderStub->expects($this->exactly(2))
            ->method('getWebsiteResult')
            ->willReturn(new WebsiteResult(new Url(''), 123));

        $provider = new Provider(
            $websiteResultProviderStub
        );
        $mainUrl = new Url('http://a.pl');
        $otherUrls = new UrlCollection([new Url('http://b.pl')]);
        $result = $provider->getTestResult($mainUrl, $otherUrls);

        self::assertInstanceOf(TestResult::class, $result);
    }
}