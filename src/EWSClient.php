<?php

namespace Cruk\EventSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @file
 *
 * Simple file to create the EWS interface that all other EWS classes will implement.
 */
class EWSClient implements LoggerAwareInterface
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
    protected $path = 'api/v3';

    /** @var bool */
    private $loggingEnabled = false;

    /** @var LoggerInterface */
    private $logger;

    /** @var string */
    private $logId;

    /**
     * EWSClient constructor.
     *
     * @param \GuzzleHttp\Client            $http
     * @param mixed                         $clientIdOrAccessToken
     * @param bool                          $clientSecret
     * @param \Psr\Log\LoggerInterface|null $logger
     */
    public function __construct(
        Client $http,
        $clientIdOrAccessToken,
        $clientSecret = false,
        LoggerInterface $logger = null
    ) {
        $this->setLogId(Uuid::uuid4()->toString());
        if ($logger !== null) {
            $this->setLogger($logger);
        }

        $this->http = $http;
        // Set the accessToken depending on whether we've been sent it, or
        // if we need to retrieve it.
        if (!$clientSecret) {
            $this->accessToken = $clientIdOrAccessToken;
        }

        $this->accessToken = self::requestAccessToken($http, $clientIdOrAccessToken, $clientSecret);

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

        $response = $http->get(
            'oauth/v2/token',
            [
                'query' => $query,
            ]
        );

        $body = (string) $response->getBody();
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
     * @param array  $options
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
     * @param array  $uris
     *   URI strings
     * @param array  $options
     *   Request options to apply
     * @return mixed
     *   JSON decoded body from EWS
     */
    public function requestJsons($method, $uris, array $options = [])
    {
        // Add the OAuth access token to the request headers
        $options = array_merge(
            $options,
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]
        );
        /** @var Promise\PromiseInterface[] $promises */
        $promises = [];

        $transactionIds = [];
        $counter = 0;
        foreach ($uris as $uri) {
            $transactionIds[] = Uuid::uuid4()->toString();

            $this->logRequest($transactionIds[$counter], $method, $uri, $options);
            $promises[] = $this->http->requestAsync($method, $uri, $options);
        }

        try {
            $responses = Promise\unwrap($promises);

            $results = [];
            $counter = 0;
            foreach ($responses as $response) {
                $this->logResponse($transactionIds[$counter], $method, $uris[$counter], $response);
                $results[] = $this->handleResponse($response);
                $counter++;
            }
        } catch (ClientException $e) {
            throw new EWSClientError($e->getCode().' error', 0, null, []);
        }

        return $results;
    }

    /**
     * Helper function for the above two methods.
     */
    private function handleResponse(Response $response)
    {
        $body = (string) $response->getBody();

        // Throw an error if we didn't get a 200 code
        if ($response->getStatusCode() !== 200) {
            throw new EWSClientError($response->getStatusCode().' error', 0, null, []);
        }

        $body = json_decode($body, true);

        if ($body === null) {
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

    /**
     * @return boolean
     */
    public function isLoggingEnabled()
    {
        return $this->loggingEnabled;
    }

    /**
     * @param boolean $loggingEnabled
     * @return EWSObject
     */
    public function setLoggingEnabled($loggingEnabled)
    {
        $this->loggingEnabled = $loggingEnabled;

        return $this;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return EWSObject
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->setLoggingEnabled(true);

        $this->logger = $logger;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * @param string $logId
     * @return EWSClient
     */
    public function setLogId($logId)
    {
        $this->logId = $logId;

        return $this;
    }

    /**
     * @param string $transactionId
     * @param string $method
     * @param string $uri
     * @param array  $options
     */
    private function logRequest($transactionId, $method, $uri, $options)
    {
        if ($this->isLoggingEnabled()) {
            $data = $this->getRequestDataFromOptions($options);

            $this->getLogger()->info($this->formatRequestLogMessage($transactionId, $method, $uri, $data));
        }
    }

    /**
     * @param string            $transactionId
     * @param string            $method
     * @param string            $uri
     * @param ResponseInterface $response
     */
    private function logResponse($transactionId, $method, $uri, ResponseInterface $response)
    {
        if ($this->isLoggingEnabled()) {
            $data = $this->getResponseDataFromResponse($response);

            $this->getLogger()->info($this->formatResponseLogMessage($transactionId, $method, $uri, $data));
        }
    }

    /**
     * @param array|null $options
     * @return string|null
     */
    private function getRequestDataFromOptions($options = null)
    {
        if ($options !== null && array_key_exists('json', $options)) {
            return json_encode($options['json']);
        }

        return null;
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    private function getResponseDataFromResponse(ResponseInterface $response)
    {
        return $response->getBody()->getContents();
    }

    /**
     * @param string      $transactionId
     * @param string      $method
     * @param string      $uri
     * @param string|null $data
     * @return mixed
     */
    private function formatRequestLogMessage($transactionId, $method, $uri, $data = null)
    {
        return $this->formatLogMessage($transactionId, $method, $uri, 'request', $data);
    }

    /**
     * @param string      $transactionId
     * @param string      $method
     * @param string      $uri
     * @param string|null $data
     * @return mixed
     */
    private function formatResponseLogMessage($transactionId, $method, $uri, $data = null)
    {
        return $this->formatLogMessage($transactionId, $method, $uri, 'response', $data);
    }

    /**
     * @param string      $transactionId
     * @param string      $method
     * @param string      $uri
     * @param string      $callType
     * @param string|null $data
     * @return mixed
     */
    private function formatLogMessage($transactionId, $method, $uri, $callType, $data = null)
    {
        return implode("\t", [$this->getLogId(), $transactionId, $method, $uri, $callType, $data]);
    }
}
