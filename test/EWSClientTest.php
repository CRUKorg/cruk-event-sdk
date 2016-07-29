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
}
