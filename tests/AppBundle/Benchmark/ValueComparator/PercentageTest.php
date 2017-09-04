<?php

namespace Tests\AppBundle\Benchmark\ValueComparator;

use AppBundle\Benchmark\ValueComparator;

class PercentageTest extends \PHPUnit_Framework_TestCase
{

    /** @var ValueComparator\Percentage */
    private $comparator;

    public function setUp()
    {
        $this->comparator = new ValueComparator\Percentage();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDoesNotAcceptNegativeNumbers()
    {
        $this->comparator->getComparison(-10,0, 'kB');
    }

    public function testCompareZeroes()
    {
        self::assertEquals('+0.00 kB', $this->comparator->getComparison(0,0, 'kB'));
    }

    public function testCompareZeroWithPositive()
    {
        self::assertEquals('+2.00 kB', $this->comparator->getComparison(0,2, 'kB'));
    }

    public function testCompareInts()
    {
        self::assertEquals('-50%', $this->comparator->getComparison(40,20, 'kB'));
    }

    public function testCompareFloats()
    {
        self::assertEquals('-50%', $this->comparator->getComparison(40.0,20.0, 'kB'));
    }

    public function testCompareBiggerNumbersWithPlusSign()
    {
        self::assertEquals('+150%', $this->comparator->getComparison(20,50, 'kB'));
    }
}
