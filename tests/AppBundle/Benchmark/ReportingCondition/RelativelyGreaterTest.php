<?php

namespace AppBundle\Tests\Benchmark\ReportingCondition;

use AppBundle\Benchmark\ReportingCondition\RelativelyGreater;

class RelativelyGreaterTest extends \PHPUnit_Framework_TestCase
{
    public function testLeftNullValueDoesNotMatch()
    {
        $condition = new RelativelyGreater(0);

        self::assertFalse($condition->isSatisfied(null, 0));
    }

    public function testRightNullValueDoesNotMatch()
    {
        $condition = new RelativelyGreater(0);

        self::assertFalse($condition->isSatisfied(1, null));
    }

    public function testBothAreNullDoesNotMatch()
    {
        $condition = new RelativelyGreater(0);

        self::assertFalse($condition->isSatisfied(null, null));
    }

    public function testZeroMatches()
    {
        $condition = new RelativelyGreater(0);

        self::assertTrue($condition->isSatisfied(1, 0));
    }

    public function testBothZerosDontMatch()
    {
        $condition = new RelativelyGreater(0);

        self::assertFalse($condition->isSatisfied(0, 0));
    }

    public function testMatchesTwiceAsBig()
    {
        $condition = new RelativelyGreater(100);

        self::assertTrue($condition->isSatisfied(50, 25));
    }

    public function testDoesNotMatchAlmostTwiceAsBig()
    {
        $condition = new RelativelyGreater(100);

        self::assertFalse($condition->isSatisfied(49, 25));
    }
}
