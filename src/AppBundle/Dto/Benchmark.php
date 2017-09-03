<?php

namespace AppBundle\Dto;

class Benchmark
{
    /** @var string */
    private $name;

    /** @var int */
    private $startedTimestamp;

    /** @var string */
    private $unit;

    /** @var WebsiteResult */
    private $result;

    /** @var WebsiteResultCollection */
    private $otherResults;

    public function __construct(
        int $startTime,
        string $name,
        string $unit,
        WebsiteResult $result,
        WebsiteResultCollection $otherResults
    )
    {
        $this->startedTimestamp = $startTime;
        $this->name = $name;
        $this->unit = $unit;
        $this->result = $result;
        $this->otherResults = $otherResults;
    }

    /**
     * @return int
     */
    public function getStartedTimestamp(): int
    {
        return $this->startedTimestamp;
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
    public function getResult(): WebsiteResult
    {
        return $this->result;
    }

    /**
     * @return WebsiteResultCollection
     */
    public function getOtherResults(): WebsiteResultCollection
    {
        return $this->otherResults;
    }
}