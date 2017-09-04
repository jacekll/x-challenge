<?php

namespace Tests\AppBundle\Benchmark;

use AppBundle\Benchmark\ConditionVerifier\AtLeastOneCompetitorSatisfies;
use AppBundle\Benchmark\ReportingCondition;
use AppBundle\Dto\TestResult;
use Tests\AppBundle\lib\TestResultFactory;

class AtLeastOneCompetitorSatisfiesTest extends \PHPUnit_Framework_TestCase
{
    /** @var AtLeastOneCompetitorSatisfies */
    private $conditionVerifier;

    /** @var TestResult */
    private $testResult;

    public function setUp()
    {
        $this->conditionVerifier = new AtLeastOneCompetitorSatisfies();
        $this->testResult = (new TestResultFactory())->getSampleTestResult();
    }

    public function testZeroDoesNotSatisfy()
    {
        /** @var ReportingCondition|\PHPUnit_Framework_MockObject_MockObject $conditionStub */
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
        /** @var ReportingCondition|\PHPUnit_Framework_MockObject_MockObject $conditionStub */
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
        /** @var ReportingCondition|\PHPUnit_Framework_MockObject_MockObject $conditionStub */
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
