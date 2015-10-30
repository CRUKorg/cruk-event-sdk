<?php

namespace Cruk\EventSdk;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

class EventClient
{
    /** @var ClientInterface */
    private $http;

    /**
     * OAuth access token
     *
     * @var string
     */
    private $accessToken;

    /**
     * Create a new EventClient
     *
     * @param ClientInterface $http Guzzle HTTP client, used to issue
     *   requests to EWS endpoints
     * @param string OAuth access token
     */
    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * Set the OAuth access token
     *
     * @param string $accessToken
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Request an OAuth access token from the server
     *
     * @param string $clientId OAuth client ID
     * @param string $clientSecret OAuth client secret
     * @return Response Response containing the access token
     */
    public function requestAccessToken($clientId, $clientSecret)
    {
        $query = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ];

        return $this->http->get('/oauth/v2/token', [
            'query' => $query,
        ]);
    }

    /**
     * Get a list of events
     *
     * The keys allowed in the query parameters are: orderBy, orderDir, limit,
     * page, fields, dateRangeStart, dateRangeEnd.
     *
     * @param array $query
     * @return Response Response containing a list of events
     */
    public function getEvents(array $query = [])
    {
        return $this->http->get('/api/v1/events', [
            'query' => $query,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);
    }
}
