<?php

namespace Cruk\EventSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;

/**
 * @file
 *
 * Simple file to create the EWS interface that all other EWS classes will implement.
 */
class EWSClient
{

    /**
     * GuzzleHttp\Client
     *
     * @var Client
     */
    protected $http;
    /**
     * OAuth access token
     *
     * @var string
     */
    protected $accessToken;
    /**
     * Base URL of API including version number
     */
    protected $path = 'api/v2';

    /**
     * Create the EWS client.
     */
    public function __construct(Client $http, $clientIdOrAccessToken, $clientSecret = false)
    {
        $this->http = $http;
        // Set the accessToken depending on whether we've been sent it, or
        // if we need to retrieve it.
        if (!$clientSecret) {
            $this->accessToken = $clientIdOrAccessToken;
            return $this;
        }
        $this->accessToken = self::requestAccessToken($http, $clientIdOrAccessToken, $clientSecret);
        return $this;
    }

    /**
     * Request an OAuth access token from the server
     *
     * @param string $clientId
     *   OAuth client ID
     * @param string $clientSecret
     *   OAuth client secret
     * @return array
     *   Response body containing the access token
     */
    public static function requestAccessToken(Client $http, $clientId, $clientSecret)
    {
        $query = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ];

        $response = $http->get('oauth/v2/token', [
            'query' => $query,
        ]);

        $body = (string)$response->getBody();

        $access_token = json_decode($body, true);

        return $access_token['access_token'];
    }

    /**
     * Create and send an HTTP request and return the decoded JSON response
     * body
     *
     * @throws EWSClientError
     *
     * @param string $method
     *   HTTP method e.g. GET, POST, DELETE
     * @param string $uri
     *   URI string
     * @param array $options
     *   Request options to apply
     * @return mixed
     *   JSON decoded body from EWS
     */
    public function requestJson($method, $uri, array $options = [])
    {
        $results = $this->requestJsons($method, [$uri], $options);
        return $results[0];
    }

    /**
     * Create and send an HTTP request and return the decoded JSON response
     * body
     *
     * @throws EWSClientError
     *
     * @param string $method
     *   HTTP method e.g. GET, POST, DELETE
     * @param array $uris
     *   URI strings
     * @param array $options
     *   Request options to apply
     * @return mixed
     *   JSON decoded body from EWS
     */
    public function requestJsons($method, $uris, array $options = [])
    {
        // Add the OAuth access token to the request headers
        $options = array_merge($options, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);
        $promises = [];

        foreach ($uris as $uri) {
            $promises[] = $this->http->requestAsync($method, $uri, $options);
        }

        try {
            $responses = Promise\unwrap($promises);

            $results = [];
            foreach ($responses as $response) {
                $results[] = $this->handleResponse($response);
            }
        } catch (ClientException $e) {
            throw new EWSClientError($e->getCode() . ' error', 0, null, []);
        }

        return $results;
    }

    /**
     * Helper function for the above two methods.
     */
    private function handleResponse($response)
    {
        $body = (string)$response->getBody();

        // Throw an error if we didn't get a 200 code
        if ($response->getStatusCode() != 200) {
            throw new EWSClientError($response->getStatusCode() . ' error', 0, null, []);
        }

        $body = json_decode($body, true);

        if (!$body) {
            throw new EWSClientError('Failed to decode JSON response');
        }

        // EWS returned an error response.
        if (isset($body['error'])) {
            $errorDescription = '';
            $data = [];

            if (isset($body['errorDescription'])) {
                $errorDescription = $body['errorDescription'];
            }

            if (isset($body['data'])) {
                $data = $body['data'];
            }

            throw new EWSClientError($errorDescription, 0, null, $data);
        }

        return $body;
    }

    /**
     * Get the OAuth access token
     *
     * @return string accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the OAuth access token
     *
     * @param string $accessToken
     *   New OAuth access token
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
