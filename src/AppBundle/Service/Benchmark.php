<?php

namespace AppBundle\Service;

use AppBundle\Benchmark\IncorrectUrlsException;
use AppBundle\Benchmark\Processor;
use AppBundle\Dto;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Benchmark
{
    /** @var string */
    private $url;

    /** @var string[] */
    private $otherUrls;

    /** @var Processor[] */
    private $processors = [];

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        ValidatorInterface $validator
    )
    {
        $this->validator = $validator;
    }

    public function addProcessor(Processor $processor)
    {
        $this->processors[] = $processor;
    }

    public function benchmark(string $url, array $otherUrls)
    {
        $this->url = new Dto\Url($url);
        $this->otherUrls = new Dto\UrlCollection($otherUrls);

        $this->validateInput();

        $benchmarkResult = new Dto\Benchmark(time(), $this->url, $this->otherUrls);
        foreach($this->processors as $processor) {
            $processor->process($benchmarkResult);
        }
    }

    /**
     * @throws IncorrectUrlsException
     */
    protected function validateInput()
    {

        $violations = $this->validator->validate($this->url);
        $otherViolations = $this->validator->validate($this->otherUrls);
        $violations->addAll($otherViolations);
        if ($violations->count() > 0) {
            throw new IncorrectUrlsException($violations);
        }
    }
}