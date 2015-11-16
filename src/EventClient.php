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
    private static $baseUrl = '/app_dev.php/api/v1';

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
        return $this->http->get(self::$baseUrl . '/events', [
            'query' => $query,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        ]);
    }
    
    /**
     * Get the availability for a specific event
     *
     * Returns a registration object (or array - need to check).
     *
     * @param
     *          $eventCode
     * @return ??
     */
    public function getEventAvailability($eventCode)
    {
        return $this->http->get(self::$baseUrl . '/events/' . $eventCode . '/availability', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ]);
    }
    
    /**
     * Get the "next" registration ID for a specific event
     *
     * @TODO: This should pull out the registration ID from the response and
     * return it, returning FALSE if that fails
     *
     * @param
     *          $eventCode
     * @return ??
     */
    public function getNextRegistrationId($eventCode)
    {
        return $this->http->get(self::$baseUrl . '/events/' . $eventCode . '/registration', [
            'query' => [ ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ]);
    }
    
    /**
     * Get a single registration object
     *
     * @param
     *          $eventCode
     * @param
     *          $registrationId
     */
    public function getRegistration($eventCode, $registrationId)
    {
        return $this->http->get(self::$baseUrl . '/events/' . $eventCode . '/registrations/' . $registrationId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ]);
    }
    
    /**
     * Set the participant data for a registration
     */
    public function setParticipant($eventCode, $registrationId, $participant)
    {
        // /events/[EVENT-CODE]/registrations/[REGISTRATION-ID]/participant
        return $this->http->post(self::$baseUrl . '/events/' . $eventCode . '/registrations/' .
            $registrationId . '/participant', [
            'participant' => $participant
            ]);
    }
    
    /**
     * Update the participant, adding extra details
     *
     * This is useful for adding JustGiving details or payment status
     */
    public function updateParticipant($eventCode, $registrationId, $urn, $updateData)
    {
        return $this->http->patch(self::$baseUrl . '/events/' . $eventCode . '/registrations/' .
            $registrationId . '/participant/' . $urn, $updateData);
    }
}
