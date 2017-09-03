<?php
/**
 * Created by PhpStorm.
 * User: jacek
 * Date: 02.09.17
 * Time: 16:29
 */

namespace Tests\AppBundle\Benchmark;

use AppBundle\Dto\Url;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UrlTest extends KernelTestCase
{
    public function testInvalidUrl()
    {
        $url = new Url('fadsf://bla..');
        $kernel = $this->bootKernel();
        $validator = $kernel->getContainer()->get('validator');
        $result = $validator->validate($url);
        $this->assertNotEmpty($result);
    }

    public function testValidUrl()
    {
        $url = new Url('http://www.google.com/');
        $kernel = $this->bootKernel();
        $validator = $kernel->getContainer()->get('validator');
        $result = $validator->validate($url);
        $this->assertEmpty($result);
    }
}
