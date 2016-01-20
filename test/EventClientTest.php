<?php

namespace Cruk\EventSdk\Test;

use Cruk\EventSdk\EventClient;
use Cruk\EventSdk\EventClientError;
use GuzzleHttp\Psr7;

class EventClientTest extends TestCase
{
    use HttpClientTrait;

    const ACCESS_TOKEN = 'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw';

    /** @var EventClient */
    private $ews;

    /** @var array */
    private $history;

    public function setUp()
    {
        $this->history = [];

        $this->ews = new EventClient($this->getHttpClient($this->history));
        $this->ews->setAccessToken(self::ACCESS_TOKEN);
    }

    public function testRequestAccessToken()
    {
        // Execute the API call
        $this->ews->requestAccessToken('my_client_id', 'my_client_secret');

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('/oauth/v2/token', $request);

        // Assert that the query parameters are correct
        $this->assertRequestQueryParameterSame('client_id', 'my_client_id', $request);
        $this->assertRequestQueryParameterSame('client_secret', 'my_client_secret', $request);
    }

    public function testGetEvents()
    {
        // Execute the API call
        $this->ews->getEvents();

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v1/events.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventsV2()
    {
        // Create a client that uses V2 of the EWS API
        $this->ews = new EventClient($this->getHttpClient($this->history), EventClient::EWS_VERSION_2);
        $this->ews->setAccessToken(self::ACCESS_TOKEN);

        // Execute the API call
        $this->ews->getEvents();

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestUriPathSame('api/v2/events.json', $request);
    }

    public function testGetEventsOptions()
    {
        // Execute the API call
        $this->ews->getEvents([
            'orderBy' => 'eventCode',
            'orderDir' => 'ASC',
            'limit' => 30,
            'page' => 1,
            'fields' => 'eventCode,eventName,eventDateTime',
            'dateRangeStart' => '2015-10-29 12:34:30',
            'dateRangeEnd' => '2015-10-29 12:34:30',
        ]);

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the query parameters are correct
        $this->assertRequestQueryParameterSame('orderBy', 'eventCode', $request);
        $this->assertRequestQueryParameterSame('orderDir', 'ASC', $request);
        $this->assertRequestQueryParameterSame('limit', '30', $request);
        $this->assertRequestQueryParameterSame('page', '1', $request);
        $this->assertRequestQueryParameterSame('fields', 'eventCode,eventName,eventDateTime', $request);
        $this->assertRequestQueryParameterSame('dateRangeStart', '2015-10-29 12:34:30', $request);
        $this->assertRequestQueryParameterSame('dateRangeEnd', '2015-10-29 12:34:30', $request);
    }

    public function testGetEventAvailability()
    {
        // Execute the API call
        $this->ews->getEventAvailability('N15RLM');

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/availability.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventAvailabiltiyFailure()
    {
        // Create a new EventClient just for this test which returns a failure.
        $new_ews = new EventClient($this->getHttpClient($this->history, [new Psr7\Response(200, [], json_encode(['error' => 'error', 'errorDescription' => 'errorDescription', 'data' => []]))]));
        // Execute the API call
        $this->setExpectedException(EventClientError::class);
        $new_ews->getEventAvailability('MISSING');
    }

    public function testGetEventRegistration()
    {
        // Execute the API call
        $this->ews->getEventRegistration('N15RLM', 123);

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations/123.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testCreateEventRegistration()
    {
        // Execute the API call
        $this->ews->createEventRegistration('N15RLM');

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations.json', $request);

        // Assert that the body contains a number of tickets to reserve
        $this->assertRequestBodyParameterSame('tickets', 1, $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testCreateEventRegistrationTickets()
    {
        // Execute the API call
        $this->ews->createEventRegistration('N15RLM', 4);

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the body contains the correct number of tickets to reserve
        $this->assertRequestBodyParameterSame('tickets', 4, $request);
    }

    public function testUpdateEventRegistrationStatus()
    {
        // Execute the API call
        $this->ews->updateEventRegistrationStatus('N15RLM', 123, 'everything-is-ok');

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('PATCH', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations/123/status.json', $request);

        // Assert the body contains the new participant status
        $this->assertRequestBodyParameterSame('status', 'everything-is-ok', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventRegistrationParticipant()
    {
        // Execute the API call
        $this->ews->getEventRegistrationParticipant('N15RLM', 123, 'a1b2c3d4');

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations/123/participants/a1b2c3d4.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testCreateEventRegistrationParticipant()
    {
        // Execute the API call
        $this->ews->createEventRegistrationParticipant('N15RLM', 123, [
            'participant_key' => 'participant_value',
        ]);

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations/123/participants.json', $request);

        // Assert the body contains the participant details
        $this->assertRequestBodyParameterSame('participant_key', 'participant_value', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testUpdateEventRegistrationParticipant()
    {
        // Execute the API call
        $this->ews->updateEventRegistrationParticipant('N15RLM', 123, 'abc', [
            'participant_key' => 'participant_value',
        ]);

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('PATCH', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations/123/participants/abc.json', $request);

        // Assert the body contains the participant details
        $this->assertRequestBodyParameterSame('participant_key', 'participant_value', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventRegistrationDonation()
    {
        // Execute the API call
        $this->ews->getEventRegistrationDonation('N15RLM', 123, 456);

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations/123/donations/456.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testCreateEventRegistrationDonation()
    {
        // Execute the API call
        $this->ews->createEventRegistrationDonation('N15RLM', 123, [
            'donation_key' => 'donation_value',
        ]);

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v1/events/N15RLM/registrations/123/donations.json', $request);

        // Assert the body contains the donation details
        $this->assertRequestBodyParameterSame('donation_key', 'donation_value', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }
}
