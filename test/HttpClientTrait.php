<?php

namespace Cruk\EventSdk\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

trait HttpClientTrait
{
    /**
     * Create a mock HTTP client that logs its responses into a variable
     *
     * @param array &$history
     *   Array where requests will be logged
     * @param array $responses
     *   Queue of dummy responses for the MockHandler. Default is one blank response with a status code of 200
     * @return Client
     */
    public function getHttpClient(array &$history, array $responses = null)
    {
        if ($responses === null) {
            $responses = [new Response(200, [], json_encode(['response']))];
        }

        $handler = new MockHandler($responses);

        $historyMiddleware = Middleware::history($history);

        $handler = HandlerStack::create($handler);
        $handler->push($historyMiddleware);

        // Return a Guzzle client with the history logger and mock handler attached
        return new Client(['handler' => $handler]);
    }
}
