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
        return json_decode((string)$this->http->get(self::PATH_V1 . '/events.json', [
            'query' => $query,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ])->getBody(), true);
    }

    /**
     * Get the availability for a specific event.
     *
     * @param string $eventCode
     * @return Response
     *   Response containing the event capacity and remaining ticket capacity
     *
     * @TODO: Should this simply return a numeric value?
     */
    public function getEventAvailability($eventCode)
    {
        return json_decode((string)$this->http->get(self::PATH_V1 . "/events/$eventCode/availability.json", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ])->getBody(), true);
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
        return json_decode((string)$this->http->post(self::PATH_V1 . "/events/$eventCode/registrations.json", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ])->getBody(), true);
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
        return json_decode((string)$this->http->get(self::PATH_V1 .
            "/events/$eventCode/registrations/$registrationId.json", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
            ])->getBody(), true);
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
        return json_decode((string)$this->http->post(self::PATH_V1 . "/events/$eventCode/registrations/$registrationId/participants.json", [
            'json' => $participant,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ])->getBody(), true);
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
        return json_decode((string)$this->http->patch(
            self::PATH_V1 . "/events/$eventCode/registrations/$registrationId/status.json", [
                'json' => array('statusCode' => $statusCode),
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ]
            ]
        )->getBody(), true);
    }

    /**
     * Update an event registration's participant date.
     *
     * @param string $eventCode
     * @param string $registrationId
     * @param string $participant
     * @return Response
     */
    public function updateEventRegistrationParticipant($eventCode, $registrationId, $participant)
    {
        return json_decode((string)$this->http->patch(
            self::PATH_V1 . "/events/$eventCode/registrations/$registrationId/participants/{$participant->participantUniqueId}.json", [
                'json' => $participant,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ]
            ]
        )->getBody(), true);
    }
}
