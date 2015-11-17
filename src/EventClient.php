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
     * Base URL of API (includes version number)
     */
    const PATH_V1 = 'api/v1';

    /**
     * Create a new EventClient.
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
     * Set the OAuth access token.
     *
     * @param string $accessToken
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Request an OAuth access token from the server.
     *
     * @param string $clientId OAuth client ID
     * @param string $clientSecret OAuth client secret
     * @return Response
     *   Response containing the access token
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
     * Get a list of events.
     *
     * The keys allowed in the query parameters are: orderBy, orderDir, limit,
     * page, fields, dateRangeStart, dateRangeEnd.
     *
     * @param array $query
     * @return Response
     *   Response containing a list of events
     */
    public function getEvents(array $query = [])
    {
        return $this->http->get(self::PATH_V1 . '/events', [
            'query' => $query,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);
    }

    /**
     * Get the availability for a specific event.
     *
     * @param string $eventCode
     * @return Response
     *   Response containing the event capacity and remaining ticket capacity
     */
    public function getEventAvailability($eventCode)
    {
        return $this->http->get(self::PATH_V1 . "/events/$eventCode/availability", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);
    }

    /**
     * Create a new registration for an event.
     *
     * @param string $eventCode Event code.
     * @return Response
     *   Response containing the new registration's ID.
     */
    public function createEventRegistration($eventCode)
    {
        return $this->http->get(self::PATH_V1 . "/events/$eventCode/registration", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);
    }

    /**
     * Get a registration.
     *
     * @param string $eventCode
     * @param string $registrationId
     * @return Response
     *   Response containing the registration
     */
    public function getEventRegistration($eventCode, $registrationId)
    {
        return $this->http->get(self::PATH_V1 . "/events/$eventCode/registrations/$registrationId", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);
    }

    /**
     * Add participant data to a registration.
     *
     * @param string $eventCode
     * @param string $registrationId
     * @param string $participant ??
     * @return Response
     */
    public function createEventRegistrationParticipant($eventCode, $registrationId, $participant)
    {
        return $this->http->post(self::PATH_V1 . "/events/$eventCode/registrations/$registrationId/participant", [
            'form_params' => $participant,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ]);
    }

    /**
     * Update an event registration's status.
     *
     * @param string $eventCode
     * @param string $registrationId
     * @param string $statusCode
     * @return Response
     */
    public function updateEventRegistrationStatus($eventCode, $registrationId, $statusCode)
    {
        return $this->http->patch(
            self::PATH_V1 . "/events/$eventCode/registrations/$registrationId/status/$statusCode",
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ]
            ]
        );
    }
}
