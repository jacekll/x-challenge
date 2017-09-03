<?php

namespace Tests\AppBundle\Benchmark;

use AppBundle\Benchmark\AtLeastOneCompetitorSatisfies;
use AppBundle\Benchmark\ReportingCondition;
use AppBundle\Dto\TestResult;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;
use AppBundle\Dto\WebsiteResultCollection;

class AtLeastOneCompetitorSatisfiesTest extends \PHPUnit_Framework_TestCase
{
    /** @var AtLeastOneCompetitorSatisfies */
    private $conditionVerifier;

    /** @var TestResult */
    private $testResult;

    public function setUp()
    {
        $this->conditionVerifier = new AtLeastOneCompetitorSatisfies();
        $this->testResult = new TestResult(
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

    public function testZeroDoesNotSatisfy()
    {
        $conditionStub = self::getMockBuilder(ReportingCondition::class)
            ->getMockForAbstractClass();
        $conditionStub->expects($this->any())->method('isSatisfied')
            ->willReturn(false);

        self::assertFalse(
            $this->conditionVerifier->verifyCondition(
                $this->testResult,
                $conditionStub
            )
        );

    }

    public function testOneSatisfies()
    {
        $conditionStub = self::getMockBuilder(ReportingCondition::class)
            ->getMockForAbstractClass();
        $conditionStub->expects($this->at(0))->method('isSatisfied')
            ->willReturn(false);
        $conditionStub->expects($this->at(1))->method('isSatisfied')
            ->willReturn(true);

        self::assertTrue(
            $this->conditionVerifier->verifyCondition(
                $this->testResult,
                $conditionStub
            )
        );
    }

    public function testTwoSatisfy()
    {
        $conditionStub = self::getMockBuilder(ReportingCondition::class)
            ->getMockForAbstractClass();
        $conditionStub->expects($this->any())->method('isSatisfied')
            ->willReturn(true);

        self::assertTrue(
            $this->conditionVerifier->verifyCondition(
                $this->testResult,
                $conditionStub
            )
        );
    }
}
