<?php

namespace AppBundle\Service;

use AppBundle\Benchmark\IncorrectUrlsException;
use AppBundle\Benchmark\Reporter;
use AppBundle\Dto;
use AppBundle\Benchmark\Provider;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Benchmark
{
    /** @var string */
    private $url;

    /** @var string[] */
    private $otherUrls;

    /** @var Reporter[] */
    private $reporters = [];

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /** @var Provider */
    private $benchmarkProvider;

    public function __construct(
        ValidatorInterface $validator,
        Provider $benchmarkProvider
    )
    {
        $this->validator = $validator;
        $this->benchmarkProvider = $benchmarkProvider;
    }

    public function addReporter(Reporter $reporter)
    {
        $this->reporters[] = $reporter;
    }

    public function benchmark(string $url, array $otherUrls)
    {
        $this->url = new Dto\Url($url);
        $this->otherUrls = new Dto\UrlCollection($otherUrls);

        $this->validateInput();

        $benchmarkResult = $this->benchmarkProvider->getBenchmark($this->url, $this->otherUrls);

        foreach ($this->reporters as $reporter) {
            $reporter->report($benchmarkResult);
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