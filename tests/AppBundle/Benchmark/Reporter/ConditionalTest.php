<?php

namespace Tests\AppBundle\Benchmark\Reporter;

use AppBundle\Benchmark\ConditionVerifier;
use AppBundle\Benchmark\Reporter;
use AppBundle\Benchmark\Reporter\ConditionalDecorator;
use AppBundle\Benchmark\ReportingCondition;
use Tests\AppBundle\lib\TestResultFactory;

class ConditionalTest extends \PHPUnit_Framework_TestCase
{
    public function testRunsInnerReporterConditionally()
    {
        /** @var ConditionVerifier|\PHPUnit_Framework_MockObject_MockObject $innerReporterMock */
        $conditionVerifierStub = self::getMockBuilder(ConditionVerifier::class)
            ->getMockForAbstractClass();

        $conditionVerifierStub
            ->expects($this->any())
            ->method('verifyCondition')
            ->willReturn(true);

        /** @var Reporter|\PHPUnit_Framework_MockObject_MockObject $innerReporterMock */
        $innerReporterMock = self::getMockBuilder(Reporter::class)
            ->getMockForAbstractClass();
        $innerReporterMock
            ->expects($this->once())
            ->method('report');

        /** @var ReportingCondition|\PHPUnit_Framework_MockObject_MockObject $conditionStub */
        $conditionStub = self::getMockBuilder(ReportingCondition::class)
            ->getMockForAbstractClass();

        $reporter = new ConditionalDecorator($conditionStub, $innerReporterMock, $conditionVerifierStub);
        $reporter->report((new TestResultFactory())->getSampleTestResult());
    }
}
