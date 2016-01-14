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
     * Base URL of API including version number
     */
    private $path = 'api/v2';

    /**
     * Create a new EventClient
     *
     * @param ClientInterface $http
     *   Guzzle HTTP client, used to issue requests to EWS endpoints
     */
    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
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
        $body = (string) $response->getBody();

        return json_decode($body, true);
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
    public function requestAccessToken($clientId, $clientSecret)
    {
        $query = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ];

        $response = $this->http->get('/oauth/v2/token', [
            'query' => $query,
        ]);

        $body = (string) $response->getBody();

        return json_decode($body, true);
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
     * Get the availability for a specific event
     *
     * @param string $eventCode
     *   Event code
     * @return array
     *   Response body containing the event capacity and remaining ticket capacity
     */
    public function getEventAvailability($eventCode)
    {
        $uri = $this->path . "/events/$eventCode/availability.json";

        return $this->requestJson('GET', $uri);
    }

    /**
     * Get a registration
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @return array
     *   Response containing the registration
     */
    public function getEventRegistration($eventCode, $registrationId)
    {
        $uri = $this->path . "/events/$eventCode/registrations/$registrationId.json";

        return $this->requestJson('GET', $uri);
    }

    /**
     * Create a new registration for an event
     *
     * @param string $eventCode
     *   Event code
     * @param integer $numTickets
     *   Number of tickets required (must be an integer between 1 and 10).
     * @return array
     *   Response body containing the new registration
     */
    public function createEventRegistration($eventCode, $numTickets = 1)
    {
        $uri = $this->path . "/events/$eventCode/registrations.json";

        return $this->requestJson('POST', $uri, [
            'json' => ['tickets' => $numTickets],
        ]);
    }

    /**
     * Update an event registration's status
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @param string $statusCode
     *   New status code for the registration
     * @return array
     */
    public function updateEventRegistrationStatus($eventCode, $registrationId, $statusCode)
    {
        $uri = $this->path . "/events/$eventCode/registrations/$registrationId/status.json";

        return $this->requestJson('PATCH', $uri, [
            'json' => ['status' => $statusCode],
        ]);
    }

    /**
     * Get an event registration participant
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @param string $participantUniqueId
     *   Participant's generated Siebel ID
     * @return array
     */
    public function getEventRegistrationParticipant($eventCode, $registrationId, $participantUniqueId)
    {
        $uri = $this->path
            . "/events/{$eventCode}/registrations/{$registrationId}/participants/{$participantUniqueId}.json";

        return $this->requestJson('GET', $uri);
    }

    /**
     * Add participant data to a registration
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @param string $participant
     *   New participant data
     * @return array
     */
    public function createEventRegistrationParticipant($eventCode, $registrationId, array $participant)
    {
        $uri = $this->path . "/events/$eventCode/registrations/$registrationId/participants.json";

        return $this->requestJson('POST', $uri, [
            'json' => $participant,
        ]);
    }

    /**
     * Update an event registration's participant data
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @param string $participantUniqueId
     *   Participant's generated Siebel ID
     * @param string $participant
     *   New participant data
     * @return array
     */
    public function updateEventRegistrationParticipant(
        $eventCode,
        $registrationId,
        $participantUniqueId,
        array $participant
    ) {
        $uri = $this->path
            . "/events/$eventCode/registrations/$registrationId/participants/{$participantUniqueId}.json";

        return $this->requestJson('PATCH', $uri, [
            'json' => $participant
        ]);
    }

    /**
     * Get a donation record
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @param string $participant
     *   Donation ID for the registration
     * @return array
     */
    public function getEventRegistrationDonation($eventCode, $registrationId, $donationId)
    {
        $uri = $this->path . "/events/$eventCode/registrations/$registrationId/donations/$donationId.json";

        return $this->requestJson('GET', $uri);
    }

    /**
     * Create a registration donation record
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @param string $participant
     *   New donation data
     * @return array
     */
    public function createEventRegistrationDonation($eventCode, $registrationId, array $donation)
    {
        $uri = $this->path . "/events/$eventCode/registrations/$registrationId/donations.json";

        return $this->requestJson('POST', $uri, [
            'json' => $donation,
        ]);
    }
}
