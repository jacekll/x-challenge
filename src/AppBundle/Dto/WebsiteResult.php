<?php

namespace AppBundle\Dto;


class WebsiteResult
{
    /** @var Url */
    private $url;

    /** @var int|float|null */
    private $value;

    /**
     * WebsiteResult constructor.
     * @param Url $url
     * @param float|int|null $value
     */
    public function __construct(Url $url, $value)
    {
        $this->url = $url;
        $this->value = $value;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return float|int|null
     */
    public function getValue()
    {
        return $this->value;
    }

}
