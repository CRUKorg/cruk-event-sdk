<?php

namespace Cruk\EventSdk\Test;

use GuzzleHttp\Psr7\Request;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Assert that the HTTP request method of a request is the same as $method
     *
     * @param string $method
     *   Expected HTTP request method i.e. GET, POST
     * @param Request $request
     *   Request object to check
     * @return void
     */
    public function assertRequestMethodSame($method, Request $request)
    {
        $this->assertSame($method, $request->getMethod());
    }

    /**
     * Assert that the path of a request is the same as $uriPath
     *
     * @param string $uriPath
     *   Expected path of the request
     * @param Request $request
     *   Request object to check
     * @return void
     */
    public function assertRequestUriPathSame($uriPath, Request $request)
    {
        $this->assertSame($uriPath, $request->getUri()->getPath());
    }

    /**
     * Assert that the value of a query string parameter of a request is equal
     * to $queryParameterValue
     *
     * @param string $queryParameterKey
     *   Name of a query string parameter in the request
     * @param string $queryParameterValue
     *   Expected value of that query string parameter
     * @param Request $request
     *   Request object to check
     * @return void
     */
    public function assertRequestQueryParameterSame($queryParameterKey, $queryParameterValue, Request $request)
    {
        // Parse the request's query string into an array
        $query = [];
        parse_str($request->getUri()->getQuery(), $query);

        // Assert that the query parameter's value matches
        $this->assertSame($queryParameterValue, $query[$queryParameterKey]);
    }

    /**
     * Assert that the value a a parameter in the body of a request is equal to
     * $bodyParameterValue
     *
     * @param string $bodyParameterKey
     *   Name of a parameter in the body of the request
     * @param string $bodyParameterValue
     *   Expected value of that parameter
     * @param Request $request
     * @return void
     */
    public function assertRequestBodyParameterSame($bodyParameterKey, $bodyParameterValue, Request $request)
    {
        // Parse the request body into an array
        $body = (string) $request->getBody();
        $body = json_decode($body, true);

        // Assert the body contains the participant details
        $this->assertSame($bodyParameterValue, $body[$bodyParameterKey]);
    }

    /**
     * Assert that the request uses $accessToken as the bearer token in its
     * Authorization header
     *
     * @param string $accessToken
     *   Expected OAuth access token in the Authorization header of the request
     * @param Request $request
     *   Request object to check
     * @return void
     */
    public function assertRequestAuthenticates($accessToken, Request $request)
    {
        $headers = $request->getHeaders();

        // Assert that the Authorization header contains the access token
        $this->assertSame("Bearer $accessToken", $headers['Authorization'][0]);
    }
}
