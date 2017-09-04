<?php

namespace AppBundle\Tests\Benchmark\WebsiteResultProvider\Timer;

use AppBundle\Benchmark\PageLoadTimer;
use AppBundle\Benchmark\WebsiteResultProvider\Timer;
use AppBundle\Dto\Url;

class TimerTest extends \PHPUnit_Framework_TestCase
{
    public function testMeasuresTime()
    {
        $address = 'http://www.any.pl/';
        /** @var PageLoadTimer|\PHPUnit_Framework_MockObject_MockObject $pageLoadTimerMock */
        $pageLoadTimerMock = self::getMockBuilder(PageLoadTimer::class)
            ->getMock();
        $pageLoadTimerMock->expects($this->once())
            ->method('getPageLoadTime')
            ->with($address)
            ->willReturn(123);

        $timer = new Timer($pageLoadTimerMock);

        $result = $timer->getWebsiteResult(new Url($address));
        self::assertEquals(123, $result->getValue());
    }
}
