<?php

namespace Tests\AppBundle\Benchmark\Reporter;

use AppBundle\Benchmark\Reporter\Console;
use AppBundle\Benchmark\ValueComparator\Percentage;
use AppBundle\Dto\TestResult;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;
use AppBundle\Dto\WebsiteResultCollection;
use AppBundle\Table\Formatter;
use Tests\AppBundle\lib\FormatterSpy;

class ConsoleTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $reportStartDateTime = '2017-01-02 03:04:00';

    private $mainUrl = 'http://a.pl';

    private $otherUrl1 = 'https://b.pl';

    private $otherUrl2 = 'http://c.pl';

    public function testContainsBenchmarkTime()
    {
        /** @var Formatter|\PHPUnit_Framework_MockObject_MockObject $formatter */
        $formatter = self::getMockBuilder(Formatter::class)
            ->getMockForAbstractClass();

        $reporter = new Console(
            $formatter,
            new Percentage()
        );

        $reporter->report($this->buildTestResult());

        $formatter->expects($this->at(1))
            ->method('addCell')
            ->with($this->stringContains($this->reportStartDateTime));

        $reporter->onTerminate();
    }

    public function testContainsResultsForMainWebSite()
    {
        $formatter = new FormatterSpy();

        $reporter = new Console(
            $formatter,
            new Percentage()
        );

        $reporter->report($this->buildTestResult());

        $reporter->onTerminate();

        self::assertInternalType('int', strpos($formatter->getCells(), $this->otherUrl2),
            'Report should contain the URL of main website');
    }

    public function testContainsResultsForOtherWebsites()
    {
        $formatter = new FormatterSpy();

        $reporter = new Console(
            $formatter,
            new Percentage()
        );

        $reporter->report($this->buildTestResult());

        $reporter->onTerminate();

        self::assertInternalType('int', strpos($formatter->getCells(), $this->otherUrl1),
            'Report should contain all of other websites\' urls');
        self::assertInternalType('int', strpos($formatter->getCells(), $this->otherUrl2),
            'Report should contain all of other websites\' urls');
    }

    private function buildTestResult(): TestResult
    {
        return new TestResult(
            strtotime($this->reportStartDateTime),
            'some test',
            'some measure unit name',
            new WebsiteResult(new Url($this->mainUrl), 12),
            new WebsiteResultCollection(
                [
                    new WebsiteResult(new Url($this->otherUrl1), 13),
                    new WebsiteResult(new Url($this->otherUrl2), 15)
                ]
            )
        );
    }
}
