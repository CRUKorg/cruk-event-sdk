<?php

namespace Cruk\EventSdk\Test;

use Cruk\EventSdk\Donation;
use Cruk\EventSdk\Event;
use Cruk\EventSdk\EWSClient;
use Cruk\EventSdk\EWSClientError;
use Cruk\EventSdk\Registration;
use Cruk\EventSdk\Participant;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

class EWSClientTest extends TestCase
{
    use HttpClientTrait;

    const ACCESS_TOKEN = 'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw';

    /** @var EWSClient */
    private $ews;

    /** @var array */
    private $history;

    /**
     * Responses from HTTP Client
     *
     * @var array
     */
    private $responses;

    /**
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    public function setUp()
    {
        $response_body = [
            'registrationId' => 123,
            'access_token' => 'here-be-my-token',
        ];
        $this->responses = [
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body))
        ];
        // History that's going to be populated by the HTTP Client.
        $this->history = [];
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, $this->responses);
        // Create the client with responses.
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
    }

    public function testRequestAccessToken()
    {
        // Execute the API call
        EWSClient::requestAccessToken($this->httpClient, 'my_client_id', 'my_client_secret');

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('/oauth/v2/token', $request);

        // Assert that the query parameters are correct
        $this->assertRequestQueryParameterSame('client_id', 'my_client_id', $request);
        $this->assertRequestQueryParameterSame('client_secret', 'my_client_secret', $request);
    }

    public function testGetEvent()
    {
        // Create the Event.
        $event = new Event($this->ews, 'N15RLM');

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventAvailability()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $event->getAvailability();

        // Get the request from the history
        $request = $this->history[1]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/availability.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventAvailabiltiyFailure()
    {
        $this->setExpectedException(EWSClientError::class);

        // Create a new EWSClient just for this test which returns a failure.
        $body = json_encode([
            'error' => 'error',
            'errorDescription' => 'errorDescription',
            'data' => []
        ]);

        $responses = [new Response(200, [], $body)];
        $ews = new EWSClient($this->getHttpClient($this->history, $responses), self::ACCESS_TOKEN);

        // Execute the API call
        new Event($ews, 'MISSING');
    }

    public function testGetEventRegistration()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        new Registration($this->ews, 123, $event);

        // Get the request from the history
        $request = $this->history[1]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testCreateEventRegistration()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $event->createRegistration(1);
        // Get availability. (Response 2)
        $event->createRegistration(4);

        // Get the request from the history
        $request = $this->history[1]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations.json', $request);

        // Assert that the body contains a number of tickets to reserve
        $this->assertRequestBodyParameterSame('tickets', 1, $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);

        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations.json', $request);

        // Assert that the body contains a number of tickets to reserve
        $this->assertRequestBodyParameterSame('tickets', 4, $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testUpdateEventRegistrationStatus()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = $event->createRegistration(1);
        // Execute the API call
        $registration->updateStatus('everything-is-ok');

        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('PATCH', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123/status.json', $request);

        // Assert the body contains the new participant status
        $this->assertRequestBodyParameterSame('status', 'everything-is-ok', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventRegistrationParticipant()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Get participant. (Response 2)
        new Participant($this->ews, 'a1b2c3d4', $event, $registration);

        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123/participantInfos/a1b2c3d4.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testCreateEventRegistrationParticipant()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Create participant. (Response 2)
        $registration->createParticipant([
            'forename' => 'participant_value'
        ]);

        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123/participantInfos.json', $request);

        // Parse the request body into an array
        $body = (string) $request->getBody();
        $body = json_decode($body, true);

        // Assert the body contains the participant details
        $this->assertSame('participant_value', $body['participant']['forename']);
    }

    public function testUpdateEventRegistrationParticipant()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Get participant. (Response 2)
        $participant = new Participant($this->ews, 'abc', $event, $registration);
        // Update the participant. (Response 3)
        $participant->patch([
            'forename' => 'participant_value',
        ]);

        // Get the request from the history
        $request = $this->history[3]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('PATCH', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123/participantInfos/abc.json', $request);

        // Assert the body contains the participant details
        $this->assertRequestBodyParameterSame('forename', 'participant_value', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testGetEventRegistrationDonation()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Get the donation. (Response 2)
        new Donation($this->ews, 456, $event, $registration);


        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123/donations/456.json', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }

    public function testCreateEventRegistrationDonation()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Create the Donation. (Response 2)
        $registration->createDonation([
            'bankAccountCode' => 'donation_value'
        ]);

        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123/donations.json', $request);

        // Assert the body contains the donation details
        $this->assertRequestBodyParameterSame('bankAccountCode', 'donation_value', $request);

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);
    }
}
