<?php


namespace AppBundle\Dto;


class TestResult
{
    /** @var int */
    private $startTimestamp;

    /** @var string */
    private $name;

    /** @var string */
    private $unit;

    /** @var WebsiteResult */
    private $mainWebsiteResult;

    /** @var WebsiteResultCollection */
    private $websiteResults;

    /**
     * TestResult constructor.
     * @param int $startTimestamp
     * @param string $name
     * @param string $unit
     * @param WebsiteResult $mainWebsiteResult
     * @param WebsiteResultCollection $websiteResults
     */
    public function __construct($startTimestamp, $name, $unit, WebsiteResult $mainWebsiteResult, WebsiteResultCollection $websiteResults)
    {
        $this->startTimestamp = $startTimestamp;
        $this->name = $name;
        $this->unit = $unit;
        $this->mainWebsiteResult = $mainWebsiteResult;
        $this->websiteResults = $websiteResults;
    }

    /**
     * @return int
     */
    public function getStartTimestamp(): int
    {
        return $this->startTimestamp;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @return WebsiteResult
     */
    public function getMainWebsiteResult(): WebsiteResult
    {
        return $this->mainWebsiteResult;
    }

    /**
     * @return WebsiteResultCollection
     */
    public function getWebsiteResults(): WebsiteResultCollection
    {
        return $this->websiteResults;
    }

}