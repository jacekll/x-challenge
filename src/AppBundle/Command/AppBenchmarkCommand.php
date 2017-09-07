<?php

namespace AppBundle\Command;

use AppBundle\Benchmark\IncorrectUrlsException;

use AppBundle\ConstraintViolationInvalidValueCollector;
use AppBundle\Service\Benchmark;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class AppBenchmarkCommand extends Command
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Benchmark */
    private $benchmark;

    public function __construct(LoggerInterface $logger, Benchmark $benchmark)
    {
        $this->logger = $logger;
        $this->benchmark = $benchmark;

        parent::__construct();
    }


    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this
            ->setName('app:benchmark')
            ->setDescription('Benchmarks a website against other websites; currently checks website response time')
            ->addArgument('url', InputArgument::REQUIRED, 'Website address to benchmark')
            ->addArgument('otherUrl', InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'Other websites to benchmark against (separated by a space)
                All should start with "http(s)://"
                ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $urls = $input->getArgument('otherUrl');

        $logger = $this->getLogger();
        try {
            $this->benchmark->benchmark($url, $urls);
        } catch (IncorrectUrlsException $e) {
            $invalidValues = (new ConstraintViolationInvalidValueCollector())
                ->getInvalidValues($e->getViolations());
            $logger->error(
                sprintf('Incorrect Urls: %s',
                implode(', ', $invalidValues)
            ));
        }


    }

}
