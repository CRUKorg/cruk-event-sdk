<?php

namespace Cruk\EventSdk;

use GuzzleHttp\ClientInterface;

/**
 * @file
 *
 * Simple file to create the EWS interface that all other EWS classes will implement.
 */
class EWSClient
{

    /** @var ClientInterface */
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
    public function __construct(ClientInterface $http, $clientIdOrAccessToken, $clientSecret = false)
    {
        $this->http = $http;
        // Set the accessToken depending on whether we've been sent it, or
        // if we need to retrieve it.
        if (!$clientSecret) {
            $this->accessToken = $clientIdOrAccessToken;
        } else {
            $this->accessToken = self::requestAccessToken($http, $clientIdOrAccessToken, $clientSecret);
        }
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
    public static function requestAccessToken(ClientInterface $http, $clientId, $clientSecret)
    {
        $query = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ];

        $response = $http->get('/oauth/v2/token', [
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
     * @param string $method
     *   HTTP method e.g. GET, POST, DELETE
     * @param string $uri
     *   URI string
     * @param array $options
     *   Request options to apply
     */
    public function requestJson($method, $uri, array $options = [])
    {
        // Add the OAuth access token to the request headers
        $options = array_merge($options, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);

        $response = $this->http->request($method, $uri, $options);
        $body = (string)$response->getBody();

        return json_decode($body, true);
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
