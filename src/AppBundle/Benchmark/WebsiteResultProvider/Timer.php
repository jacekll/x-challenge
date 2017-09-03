<?php

namespace AppBundle\Benchmark\WebsiteResultProvider;

use AppBundle\Benchmark\WebsiteResultProvider;
use AppBundle\Dto\Url;
use AppBundle\Dto\WebsiteResult;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;

use Symfony\Component\Stopwatch\Stopwatch;

use Leadz\GuzzleHttp\Stopwatch\StopwatchMiddleware;

class Timer implements WebsiteResultProvider
{
    public function getWebsiteResult(Url $url): WebsiteResult
    {
        $request = new Request('GET', $url->getUrl());
        $response = $this->getClient()->send($request,
            [
                'decode_content' => false
            ]);

        return new WebsiteResult($url, (int) $response->getHeaderLine('X-Duration'));
    }

    public function getUnit(): string
    {
        return 'ms';
    }

    protected function getClient(): Client
    {
        // Create default HandlerStack
        $stack = HandlerStack::create();

        $middleware = new StopwatchMiddleware(new Stopwatch());

        $stack->push($middleware);

        return new Client([
            'handler' => $stack
        ]);
    }
}