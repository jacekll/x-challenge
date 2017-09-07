<?php

namespace AppBundle\Service;

use AppBundle\Benchmark\IncorrectUrlsException;
use AppBundle\Benchmark\Processor;
use AppBundle\Dto;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Benchmark
 * @package AppBundle\Service
 */
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

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        ValidatorInterface $validator,
        LoggerInterface $logger
    )
    {
        $this->validator = $validator;
        $this->logger = $logger;
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
            try {
                $processor->process($benchmarkResult);
            } catch (\Throwable $e) {
                $this->logger->error(
                    sprintf(
                        'Could not create the report. Benchamrk processor %s failed: %s',
                        get_class($processor), $e->getMessage()
                    ),
                    ['exception' => $e]
                );
            }
        }
    }

    /**
     * Uses Symfony's built-in validator to validate input
     * @throws IncorrectUrlsException
     */
    private function validateInput()
    {

        $violations = $this->validator->validate($this->url);
        $otherViolations = $this->validator->validate($this->otherUrls);
        $violations->addAll($otherViolations);
        if ($violations->count() > 0) {
            throw new IncorrectUrlsException($violations);
        }
    }
}