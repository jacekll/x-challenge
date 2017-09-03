<?php

namespace AppBundle\Benchmark;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Leadz\GuzzleHttp\Stopwatch\StopwatchMiddleware;
use Psr\Http\Message\MessageInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class PageLoadTimer
{
    /**
     * @param string $url
     * @return int total page load time in milliseconds
     */
    public function getPageLoadTime(string $url): int
    {
        $request = new Request('GET', $url);
        /** @var MessageInterface $response */
        $response = $this->getClient()->send($request);

        return (int) $response->getHeaderLine('X-Duration');
    }

    protected function getClient(): Client
    {
        $stack = HandlerStack::create();

        $middleware = new StopwatchMiddleware(new Stopwatch());

        $stack->push($middleware);

        return new Client([
            'handler' => $stack
        ]);
    }
}