<?php

namespace Tests\AppBundle\Dto;

use AppBundle\Dto\Url;
use AppBundle\Dto\UrlCollection;

class UrlCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
        self::assertSame(0, (new UrlCollection())->count());
    }

    public function testAcceptsArrayOfStrings()
    {
        self::assertSame(1, (new UrlCollection(['http://www.a.pl/']))->count());
    }

    public function testContainsUrls()
    {
        $collection = new UrlCollection(['http://www.a.pl/']);

        foreach($collection as $item) {
            self::assertInstanceOf(Url::class, $item);

        }

    }

    public function testCanBeIteratedOver()
    {
        $collection = new UrlCollection(['http://www.a.pl/']);
        $itemsTraversed = 0;
        foreach($collection as $item) {
            self::assertInstanceOf(Url::class, $item);
            $itemsTraversed += 1;
        }
        self::assertSame(1, $itemsTraversed);
    }
}
