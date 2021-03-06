<?php

namespace Cruk\EventSdk\Test;

use Cruk\EventSdk\Address;
use Cruk\EventSdk\Donation;
use Cruk\EventSdk\Event;
use Cruk\EventSdk\Config;
use Cruk\EventSdk\EWSClient;
use Cruk\EventSdk\EWSClientError;
use Cruk\EventSdk\Participant;
use Cruk\EventSdk\Registration;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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
     * @var Client
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
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body)),
        ];
        // History that's going to be populated by the HTTP Client.
        $this->history = [];
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, $this->responses);
        // Create the client with responses.
        $logger = new Logger('bdd');
        $logger->pushHandler(new NullHandler());
        //$logger->pushHandler(new StreamHandler('/tmp/bdd.log', Logger::INFO));
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN, false, $logger);

        array_shift($this->history);
    }

    public function testRequestAccessToken()
    {
        // Execute the API call
        EWSClient::requestAccessToken($this->httpClient, 'my_client_id', 'my_client_secret');

        // Test the constructor fully
        new EWSClient($this->httpClient, 'my_client_id', 'my_client_secret');

        // Get the request from the history
        $request = $this->history[1]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame('oauth/v2/token', $request);

        // Assert that the query parameters are correct
        $this->assertRequestQueryParameterSame('client_id', 'my_client_id', $request);
        $this->assertRequestQueryParameterSame('client_secret', 'my_client_secret', $request);

        // Test getting and setting accessToken
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        $access_token = 'token';
        $this->ews->setAccessToken($access_token);
        $this->assertSame($access_token, $this->ews->getAccessToken());

        // Test getting and setting the path
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        $path = 'path';
        $this->ews->setPath($path);
        $this->assertSame($path, $this->ews->getPath());
    }

    public function testGettingAndSettingClient()
    {
        $event = new Event($this->ews, []);
        $this->assertEquals($this->ews, $event->getClient());

        // New client
        $new_client = new EWSClient($this->httpClient, 'my_client_id_2', 'my_client_secret_2');
        $event->setClient($new_client);
        $this->assertEquals($new_client, $event->getClient());
    }

    public function testCreateEvent()
    {
        // Create the Event.
        $event = new Event($this->ews, [
            'eventName' => 'Banana shower of heavenly parents',
            'eventType' => 'HUH',
            'eventDistance' => '1000m',
            'eventDistanceUOM' => '1000UOM',
            'ageFrom' => 0,
            'ageTo' => 100,
            'ageCriteria' => 'Positive',
            'gender' => 'male or female',
            'waves' => [],
            'sponsorshipPageCreationDuration' => '1m',
            'defaultSiebelRegistrationStatus' => '',
        ]);
        $event->create();
        $this->assertEquals('Banana shower of heavenly parents', $event->getEventName());
        $this->assertEquals('HUH', $event->getEventType());
        $this->assertEquals('1000m', $event->getEventDistance());
        $this->assertEquals('1000UOM', $event->getEventDistanceUOM());
        $this->assertEquals(0, $event->getAgeFrom());
        $this->assertEquals(100, $event->getAgeTo());
        $this->assertEquals('Positive', $event->getAgeCriteria());
        $this->assertEquals('male or female', $event->getGender());
        $this->assertEquals([], $event->getWaves());
        $this->assertEquals('1m', $event->getSponsorshipPageCreationDuration());
        $this->assertEquals('', $event->getDefaultSiebelRegistrationStatus());

        // Get the request from the history
        $request = $this->history[0]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v2/events.json', $request);

        // Test setting registrations (possibly code that is not required).
        $registration = new Registration($this->ews, [], $event);
        $event->setRegistrations([$registration]);
        $this->assertEquals([$registration], $event->getRegistrations());
    }


    public function test404()
    {
        $this->setExpectedException(EWSClientError::class);
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, [new Response(404, [], json_encode([]))]);
        // Create the client with responses.
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        // Create the Event.
        new Event($this->ews, 'N15RLM');
    }

    public function test201()
    {
        $this->setExpectedException(EWSClientError::class);
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, [new Response(201, [], json_encode([]))]);
        // Create the client with responses.
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        // Create the Event.
        new Event($this->ews, 'N15RLM');
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

    public function testInabilityToPatchRegistration()
    {
        $this->setExpectedException(EWSClientError::class);

        $event = new Event($this->ews, []);
        $registration = new Registration($this->ews, [], $event);
        $registration->patch();
    }

    public function testGetEventRegistration()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        $registration->asArray();

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
        // Call update for code coverage and to ensure there are no adverse effects.
        $registration->update();

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
        $participant = new Participant($this->ews, 'a1b2c3d4', $event, $registration);
        $participant->asArray();

        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('GET', $request);
        $this->assertRequestUriPathSame(
            'api/v2/events/N15RLM/registrations/123/participantInfos/a1b2c3d4.json',
            $request
        );

        // Assert that the request uses the OAuth access token to authenticate
        $this->assertRequestAuthenticates(self::ACCESS_TOKEN, $request);

        return $participant;
    }

    public function testCreateEventRegistrationParticipant()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Create participant. (Response 2)
        $participant = $registration->createParticipant([
            'forename' => 'participant_value'
        ]);
        $this->assertEquals([$participant], $registration->getParticipants());
        $registration->setParticipants([$participant]);
        $this->assertEquals([$participant], $registration->getParticipants());

        // Set timeout
        $registration->setTimeOut('1970-01-01 00:00 GMT');
        $this->assertEquals('1970-01-01 00:00 GMT', $registration->getTimeOut());
        $this->assertEquals(0, $registration->getUnixTimeOut());

        // Test status
        $registration->setStatus('complete');
        $this->assertEquals('complete', $registration->getStatus());

        // Get the request from the history
        $request = $this->history[2]['request'];

        // Assert that the request is made to the correct endpoint
        $this->assertRequestMethodSame('POST', $request);
        $this->assertRequestUriPathSame('api/v2/events/N15RLM/registrations/123/participantInfos.json', $request);

        // Parse the request body into an array
        $body = (string)$request->getBody();
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
        $registration->setDonationId(456);
        $registration->getDonation();
        // Get the donation. (Response 2)
        $donation = new Donation($this->ews, 456, $event, $registration);

        $this->assertSame($donation, $registration->getDonation());
        $registration->setDonation($donation->getId());
        $this->assertSame($donation, $registration->getDonation());

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
        $donation = $registration->createDonation([
            'id' => '100',
            'bankAccountCode' => 'donation_value',
            'amount' => 1000,
            'dataSource' => 'data_source',
            'donationType' => 'donation_type',
            'financialPaymentReference' => 'financial_pay_ref',
            'paymentMethod' => 'payment_method',
            'paymentStatus' => 'payment_status',
            'dateReceived' => '2000-01-01',
            'personalGiftAid' => 'yep',
            'product' => 'rabbits',
            'source' => 'over these',
            'originalPaymentId' => 'blahalksgh',
            'toBeGiftAided' => 'nope',
            'paymentProviderTransactionId' => '1234567890',
        ]);
        $this->assertEquals('2000-01-01', $donation->getDateReceived());
        $this->assertEquals(100, $donation->getId());
        $this->assertEquals(1000, $donation->getAmount());
        $this->assertEquals('data_source', $donation->getDataSource());
        $this->assertEquals('donation_type', $donation->getDonationType());
        $this->assertEquals('financial_pay_ref', $donation->getFinancialPaymentReference());
        $this->assertEquals('payment_method', $donation->getPaymentMethod());
        $this->assertEquals('payment_status', $donation->getPaymentStatus());
        $this->assertEquals('2000-01-01', $donation->getDateReceived());
        $this->assertEquals('yep', $donation->getPersonalGiftAid());
        $this->assertEquals('rabbits', $donation->getProduct());
        $this->assertEquals('over these', $donation->getSource());
        $this->assertEquals('blahalksgh', $donation->getOriginalPaymentId());
        $this->assertEquals('1234567890', $donation->getPaymentProviderTransactionId());

        $this->assertEquals(100, $registration->getDonationId());
        $this->assertEquals($donation, $registration->getDonation());

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

    public function testCreateParticipantFromArray()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Create the participant
        $data = [
            'primaryParticipant' => true,
            'participant' => [
                'externalReference' => 'externalReference',
                'forename' => 'Wow',
                'surname' => 'McPants',
                'title' => 'Mrs',
                'gender' => 'male',
                'dob' => '1969-01-01',
                'primaryDataSourceCode' => 'yessir',
                'address' => [
                    'validated' => true,
                    'line1' => 'First line',
                    'line2' => 'Second line',
                    'line3' => 'Third line',
                    'city' => 'London',
                    'country' => 'GBR',
                    'postalCode' => 'BD23 1UB',
                ],
                'emailAddress' => 'email@email.com',
                'telephoneNumberLandline' => '02012345678',
                'telephoneNumberMobile' => '07777777777',
                'suppressions' => [
                    'SUP'
                ],
            ],
            'eventSpecific' => [
                'tshirtSizeCode' => 'abcdef',
                'tshirtName' => 'ABCDEF',
                'fundraisingUrl' => 'http://www.justgiving.com/gimme-your-money',
                'fundraisingTarget' => 10000,
                'emergencyContactName' => 'Smarty McPants',
                'emergencyContactNumber' => '07111111111111',
                'runningNumber' => 1000,
                'cancerType' => 'head cancer',
                'motivation' => 'Head hurts',
                'motivationOther' => 'Hurts really bad right on top',
            ],
        ];
        $participant = new Participant($this->ews, $data, $event, $registration);
        $this->assertEquals($registration, $participant->getRegistration());
        $participant->setRegistration($registration);
        $this->assertEquals($registration, $participant->getRegistration());
        $this->assertEquals($event, $participant->getEvent());
        $participant->setEvent($event);
        $this->assertEquals($event, $participant->getEvent());
        $this->assertEquals($data, $participant->asArray());

        // Check we can get a value from a key
        $this->assertEquals('Smarty McPants', $participant->getValueFromKey('emergencyContactName'));

        // Check that a missing key returns null
        $this->assertEquals(null, $participant->getValueFromKey('trump'));
    }

    public function testCreateAddressFromArray()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Create the participant
        $data = [
            'primaryParticipant' => true,
            'participant' => [
                'externalReference' => 'externalReference',
                'forename' => 'Wow',
                'surname' => 'McPants',
                'title' => 'Mrs',
                'gender' => 'male',
                'dob' => '1969-01-01',
                'primaryDataSourceCode' => 'yessir',
                'address' => [
                    'validated' => true,
                    'line1' => 'First line',
                    'line2' => 'Second line',
                    'line3' => 'Third line',
                    'city' => 'London',
                    'country' => 'GBR',
                    'postalCode' => 'BD23 1UB',
                ],
                'emailAddress' => 'email@email.com',
                'telephoneNumberLandline' => '02012345678',
                'telephoneNumberMobile' => '07777777777',
                'suppressions' => [
                    'SUP'
                ],
            ],
            'eventSpecific' => [
                'tshirtSizeCode' => 'abcdef',
                'tshirtName' => 'ABCDEF',
                'fundraisingUrl' => 'http://www.justgiving.com/gimme-your-money',
                'fundraisingTarget' => 10000,
                'emergencyContactName' => 'Smarty McPants',
                'emergencyContactNumber' => '07111111111111',
                'runningNumber' => 1000,
                'cancerType' => 'head cancer',
                'motivation' => 'Head hurts',
                'motivation' => 'Fried chicken required',
            ],
        ];
        $address = new Address($this->ews, $data['participant']['address']);
        $participant_data = $data;
        unset($participant_data['participant']['address']);
        $participant = new Participant($this->ews, $participant_data, $event, $registration);
        $participant->setAddress($address);
        $this->assertEquals($data, $participant->asArray());
    }

    public function testMapInvalidCountryCode()
    {
        $this->setExpectedException(EWSClientError::class);
        new Address($this->ews, ['country' => 'ABCD']);
    }

    public function testMapInvalidCountryCodeCorrectLength()
    {
        $this->setExpectedException(EWSClientError::class);
        new Address($this->ews, ['country' => 'QQQ']);
    }

    public function testCountryCodeMapping()
    {
        // Create the Event. (Response 0)
        $event = new Event($this->ews, 'N15RLM');
        // Get availability. (Response 1)
        $registration = new Registration($this->ews, 123, $event);
        // Create the participant
        $data = [
            'primaryParticipant' => true,
            'participant' => [
                'externalReference' => 'externalReference',
                'forename' => 'Wow',
                'surname' => 'McPants',
                'title' => 'Mrs',
                'gender' => 'male',
                'dob' => '1969-01-01',
                'primaryDataSourceCode' => 'yessir',
                'address' => [
                    'line1' => 'First line',
                    'line2' => 'Second line',
                    'country' => 'GB',
                ],
                'emailAddress' => 'email@email.com',
                'telephoneNumberLandline' => '02012345678',
                'telephoneNumberMobile' => '07777777777',
                'suppressions' => [
                    'SUP'
                ],
            ],
            'eventSpecific' => [
                'tshirtSizeCode' => 'abcdef',
                'tshirtName' => 'ABCDEF',
                'fundraisingUrl' => 'http://www.justgiving.com/gimme-your-money',
                'fundraisingTarget' => 10000,
                'emergencyContactName' => 'Smarty McPants',
                'emergencyContactNumber' => '07111111111111',
                'runningNumber' => 1000,
                'cancerType' => 'head cancer',
                'motivation' => 'Head hurts',
                'motivation' => 'Give me more chicken',
            ],
        ];
        $participant = new Participant($this->ews, $data, $event, $registration);
        $this->assertEquals('GBR', $participant->getAddress()->getCountry());
        $this->assertEquals('GB', $participant->getAddress()->getCountryISO2());
        $this->assertEquals('United Kingdom', $participant->getAddress()->getCountryName());
    }

    public function testUpdateParticipant()
    {
        $response_body = [
            'registrationId' => 123,
            'access_token' => 'here-be-my-token',
        ];
        $this->responses = [
            new Response(200, [], json_encode($response_body)),
            new Response(200, [], json_encode($response_body)),
        ];
        // History that's going to be populated by the HTTP Client.
        $this->history = [];
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, $this->responses);
        // Create the client with responses.
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);

        // Create the Event.
        $event = new Event($this->ews, []);
        // Get availability.
        $registration = new Registration($this->ews, [], $event);
        // Create the participant
        $participant = new Participant($this->ews, ['uniqueId' => 'abc'], $event, $registration);

        $participant->setForename('Howard');
        $this->assertEquals('Howard', $participant->getForename());

        // Response 0
        $participant->patch();
        // Response 1
        $participant->update();

        // Get request from history
        $request = $this->history[0]['request'];
        $this->assertRequestMethodSame('PATCH', $request);

        // Get request from history
        $request = $this->history[1]['request'];
        $this->assertRequestMethodSame('PUT', $request);
    }

    public function testPatchEventSpecificStatus()
    {
        $event = new Event($this->ews, ['eventCode' => 'N15FA2']);
        $registration = new Registration($this->ews, ['registrationId' => 8008], $event);
        $participant = new Participant($this->ews, ['uniqueId' => 'abc'], $event, $registration);

        $participant->patchEventSpecificStatus('rejected');

        $this->assertSame('rejected', $participant->getEventSpecificStatus());

        // Get request from history
        $request = $this->history[0]['request'];
        $this->assertRequestBodyParameterSame('status', 'rejected', $request);
    }

    public function testConfig()
    {
        $configArray = [
            'configKey' => 123,
            'configValue' => 'Shorts',
        ];
        $response_body = [$configArray];
        $this->responses = [
            new Response(200, [], json_encode($response_body)),
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
        $event = new Event($this->ews, ['eventCode' => 'N15FA2']);
        $event->getConfigs();
        $configs = $event->getConfigs();
        $config = array_pop($configs);
        $this->assertSame($configArray, $config->asArray());
        $config->setConfigValue('Trousers');
        $configArray['configValue'] = 'Trousers';
        $this->assertSame($configArray, $config->asArray());
        $config->update();
        $this->assertSame($event, $config->getEvent());
        $config->setEvent($event);
        $this->assertSame($event, $config->getEvent());
        $new_config = new Config($this->ews, [
            'configKey' => 124,
            'configValue' => 'Skirt',
        ], $event);
        $new_config->create();
        $event->createOrUpdateConfig(123, 'Kilt');
        $event->createOrUpdateConfig(125, 'Shirt');
        $this->assertSame(3, count($event->getConfigs()));
        $event->setConfigs($configs);
    }

    public function testSearchParticipant()
    {
        $response_body = [
            'results' => [
                [
                    'uniqueId' => 123,
                    'forename' => 'Banana',
                    'surname' => 'Man',
                ],
            ],
        ];
        $this->responses = [
            new Response(200, [], json_encode($response_body)),
        ];
        // History that's going to be populated by the HTTP Client.
        $this->history = [];
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, $this->responses);
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        $participants = Participant::search($this->ews, []);
        $this->assertEquals($participants[0]->asArray(), ['participant' => $response_body['results'][0]]);

        $this->setExpectedException(EWSClientError::class);
        $participants[0]->patch();
    }

    public function testSearchEvent()
    {
        $response_body = [
            'results' => [
                [
                    'eventCode' => 123,
                    'eventName' => 'Banana',
                ],
            ],
        ];
        $this->responses = [
            new Response(200, [], json_encode($response_body)),
        ];
        // History that's going to be populated by the HTTP Client.
        $this->history = [];
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, $this->responses);
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        $events = Event::search($this->ews, []);
        $this->assertEquals($events[0]->asArray(), $response_body['results'][0]);
    }

    public function testSearchesEvent()
    {
        $response_body = [
            'results' => [
                [
                    'eventCode' => 123,
                    'eventName' => 'Banana',
                ],
            ],
        ];
        $this->responses = [
            new Response(200, [], json_encode($response_body)),
        ];
        // History that's going to be populated by the HTTP Client.
        $this->history = [];
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, $this->responses);
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        $events = Event::searches($this->ews, [[]]);
        $this->assertEquals($events[0]->asArray(), $response_body['results'][0]);
    }

    public function testThrowsInvalidJson()
    {
        $this->setExpectedException(EWSClientError::class);
        $this->responses = [
            new Response(200, [], 'asdlfkjdslfj{}[]'),
        ];
        // Create httpClient
        $this->httpClient = $this->getHttpClient($this->history, $this->responses);
        $this->ews = new EWSClient($this->httpClient, self::ACCESS_TOKEN);
        Event::search($this->ews, []);
    }

    public function testParticipantExtras()
    {
        $participant = $this->testGetEventRegistrationParticipant();
        $participant->createOrUpdateExtra('123', 'Value');
        $participant->createOrUpdateExtra('123456', 'Value');
        $extras = $participant->getExtras();
        $this->assertEquals($participant, $extras[123]->getParticipant());
        $extras[123]->setParticipant($participant);
        $this->assertEquals($participant, $extras[123]->getParticipant());
        $participant->setExtras($extras);

    }
}
