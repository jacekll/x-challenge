<?php

namespace AppBundle\Tests\Benchmark\WebsiteResultProvider\Timer;

use AppBundle\Benchmark\WebsiteResultProvider\Timer;
use AppBundle\Dto\Url;

class TimerTest extends \PHPUnit_Framework_TestCase
{
    public function testMeasuresTime()
    {
        // TODO: inject client?
        $timer = new Timer();
        $result = $timer->getWebsiteResult(new Url('http://www.gazeta.pl/'));
        self::assertInternalType('int', $result->getValue());
    }
}
