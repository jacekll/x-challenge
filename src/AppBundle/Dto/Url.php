<?php
namespace AppBundle\Dto;

use /** @noinspection PhpUnusedAliasInspection */
    Symfony\Component\Validator\Constraints as Assert;

class Url
{
    /**
     * @Assert\NotBlank(),
     * @Assert\Url(
     *     protocols = { "http", "https" }
     * )
     *
     * @var string
     */
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

}
