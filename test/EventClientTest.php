<?php

namespace Cruk\EventSdk\Test;

use Cruk\EventSdk\EventClient;

/**
 * Tests for EventClient
 */
class EventClientTest extends \PHPUnit_Framework_TestCase
{
    use HttpClientTrait;

    /**
     * Test that requestAccessToken() makes a GET request to /oauth/v2/token,
     * and passes the client ID and secret in the query string.
     */
    public function testRequestAccessToken()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));

        // Execute the API call.
        $ews->requestAccessToken('my_client_id', 'my_client_secret');

        // Get the request from the history.
        $request = $history[0]['request'];

        // Assert the request is made to the correct endpoint.
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('/oauth/v2/token', $request->getUri()->getPath());

        // Parse the request's query string into an array.
        $query = [];
        parse_str($request->getUri()->getQuery(), $query);

        // Assert that the query parameters are correct.
        $this->assertSame('my_client_id', $query['client_id']);
        $this->assertSame('my_client_secret', $query['client_secret']);
    }

    /**
     * Test that getEvents() makes a GET request to the /events endpoint, to
     * retrieve a list of events.
     */
    public function testGetEvents()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));

        // Execute the API call.
        $ews->getEvents();

        // Get the request from the history.
        $request = $history[0]['request'];

        // Assert the request is made to the correct endpoint.
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('api/v1/events', $request->getUri()->getPath());

        // Assert the request includes no query parameters by default.
        $this->assertSame('', $request->getUri()->getQuery());
    }

    /**
     * Test that getEvents() uses the access token to authenticate.
     */
    public function testGetEventsAuthenticates()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));
        $ews->setAccessToken(
            'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw'
        );

        // Execute the API call.
        $ews->getEvents();

        // Get the headers from the request in the history.
        $request = $history[0]['request'];
        $headers = $request->getHeaders();

        // Assert that the Authorization header contains the same access token.
        $this->assertSame(
            'Bearer MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw',
            $headers['Authorization'][0]
        );
    }

    /**
     * Test that getEvents() passes query parameters to the GET /events
     * endpoint.
     */
    public function testGetEventsOptions()
    {
        $history = [];

        $ews = new EventClient(
            $this->getHttpClient($history)
        );

        // Execute the API call.
        $ews->getEvents([
            'orderBy' => 'eventCode',
            'orderDir' => 'ASC',
            'limit' => 30,
            'page' => 1,
            'fields' => 'eventCode,eventName,eventDateTime',
            'dateRangeStart' => '2015-10-29 12:34:30',
            'dateRangeEnd' => '2015-10-29 12:34:30',
        ]);

        // Get the request from the history.
        $request = $history[0]['request'];

        // Parse the request's query string into an array.
        $query = [];
        parse_str($request->getUri()->getQuery(), $query);

        // Assert that the query parameters are correct.
        $this->assertSame('eventCode', $query['orderBy']);
        $this->assertSame('ASC', $query['orderDir']);
        $this->assertSame('30', $query['limit']);
        $this->assertSame('1', $query['page']);
        $this->assertSame('eventCode,eventName,eventDateTime', $query['fields']);
        $this->assertSame('2015-10-29 12:34:30', $query['dateRangeStart']);
        $this->assertSame('2015-10-29 12:34:30', $query['dateRangeEnd']);
    }

    /**
     * Test that getEventAvailability() makes a GET request to the
     * /events/[eventCode]/availability endpoint, to retrieve the availability
     * for an event.
     */
    public function testGetEventAvailability()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));

        // Execute the API call.
        $ews->getEventAvailability('N15RLM');

        // Get the request from the history.
        $request = $history[0]['request'];

        // Assert the request is made to the correct endpoint.
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('api/v1/events/N15RLM/availability', $request->getUri()->getPath());

        // Assert the request includes no query parameters by default.
        $this->assertSame('', $request->getUri()->getQuery());
    }

    /**
     * Test that getEventAvailability() uses the access token to authenticate.
     */
    public function testGetEventAvailabilityAuthenticates()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));
        $ews->setAccessToken(
            'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw'
        );

        // Execute the API call.
        $ews->getEventAvailability('N15RLM');

        // Get the headers from the request in the history.
        $request = $history[0]['request'];
        $headers = $request->getHeaders();

        // Assert that the Authorization header contains the same access token.
        $this->assertSame(
            'Bearer MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw',
            $headers['Authorization'][0]
        );
    }

    /**
     * Test that createEventRegistration() makes a GET request to the
     * /events/[eventCode]/registration endpoint, to create a new registration
     * for an event.
     */
    public function testCreateEventRegistration()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));

        // Execute the API call.
        $ews->createEventRegistration('N15RLM');

        // Get the request from the history.
        $request = $history[0]['request'];

        // Assert the request is made to the correct endpoint.
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('api/v1/events/N15RLM/registration', $request->getUri()->getPath());

        // Assert the request includes no query parameters by default.
        $this->assertSame('', $request->getUri()->getQuery());
    }

    /**
     * Test that createEventRegistration() uses the access token to authenticate.
     */
    public function testCreateEventRegistrationAuthenticates()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));
        $ews->setAccessToken(
            'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw'
        );

        // Execute the API call.
        $ews->createEventRegistration('N15RLM');

        // Get the headers from the request in the history.
        $request = $history[0]['request'];
        $headers = $request->getHeaders();

        // Assert that the Authorization header contains the same access token.
        $this->assertSame(
            'Bearer MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw',
            $headers['Authorization'][0]
        );
    }

    /**
     * Test that getEventRegistration() makes a GET request to the
     * /events/[eventCode]/registrations/[registrationId] endpoint, to retrieve
     * data about an event registration.
     */
    public function testGetEventRegistration()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));

        // Execute the API call.
        $ews->getEventRegistration('N15RLM', 123);

        // Get the request from the history.
        $request = $history[0]['request'];

        // Assert the request is made to the correct endpoint.
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('api/v1/events/N15RLM/registrations/123', $request->getUri()->getPath());

        // Assert the request includes no query parameters by default.
        $this->assertSame('', $request->getUri()->getQuery());
    }

    /**
     * Test that getEventAvailability() uses the access token to authenticate.
     */
    public function testGetEventRegistrationAuthenticates()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));
        $ews->setAccessToken(
            'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw'
        );

        // Execute the API call.
        $ews->getEventRegistration('N15RLM', 123);

        // Get the headers from the request in the history.
        $request = $history[0]['request'];
        $headers = $request->getHeaders();

        // Assert that the Authorization header contains the same access token.
        $this->assertSame(
            'Bearer MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw',
            $headers['Authorization'][0]
        );
    }

    /**
     * Test that createEventRegistration() makes a POST request to the
     * /events/[eventCode]/registrations/[registrationId]/participant endpoint,
     * to add data about a participant to an event registration.
     */
    public function testCreateEventRegistrationParticipant()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));

        // Execute the API call.
        $ews->createEventRegistrationParticipant('N15RLM', 123, [
            'field' => 'key',
        ]);

        // Get the request from the history.
        $request = $history[0]['request'];

        // Assert the request is made to the correct endpoint.
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('api/v1/events/N15RLM/registrations/123/participant', $request->getUri()->getPath());

        // Parse the request body into an array.
        $body = [];
        parse_str($request->getBody()->read(1024), $body);

        // Assert the body contains the participant details.
        $this->assertSame('key', $body['field']);

        // Assert the request includes no query parameters by default.
        $this->assertSame('', $request->getUri()->getQuery());
    }

    /**
     * Test that getEventAvailability() uses the access token to authenticate.
     */
    public function testCreateEventRegistrationParticipantAuthenticates()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));
        $ews->setAccessToken(
            'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw'
        );

        // Execute the API call.
        $ews->getEventRegistration('N15RLM', 123);

        // Get the headers from the request in the history.
        $request = $history[0]['request'];
        $headers = $request->getHeaders();

        // Assert that the Authorization header contains the same access token.
        $this->assertSame(
            'Bearer MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw',
            $headers['Authorization'][0]
        );
    }

    /**
     * Test that updateEventRegistrationStatus() makes a PATCH request to the
     * /events/[eventCode]/registrations/[registrationId]/status endpoint,
     * to update a registration's status.
     */
    public function testUpdateEventRegistrationParticipantStatus()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));

        // Execute the API call.
        $ews->updateEventRegistrationStatus('N15RLM', 123, 'everything-is-ok');

        // Get the request from the history.
        $request = $history[0]['request'];

        // Assert the request is made to the correct endpoint.
        $this->assertSame('PATCH', $request->getMethod());
        $this->assertSame(
            'api/v1/events/N15RLM/registrations/123/status/everything-is-ok',
            $request->getUri()->getPath()
        );

        // Assert the request includes no query parameters by default.
        $this->assertSame('', $request->getUri()->getQuery());
    }

    /**
     * Test that updateEventRegistrationStatus() uses the access token to authenticate.
     */
    public function testUpdateEventRegistrationStatusAuthenticates()
    {
        $history = [];

        $ews = new EventClient($this->getHttpClient($history));
        $ews->setAccessToken(
            'MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw'
        );

        // Execute the API call.
        $ews->updateEventRegistrationStatus('N15RLM', 123, 'everything-is-ok');

        // Get the headers from the request in the history.
        $request = $history[0]['request'];
        $headers = $request->getHeaders();

        // Assert that the Authorization header contains the same access token.
        $this->assertSame(
            'Bearer MGNjNjNhNDg2YWVhODFhNmY3NjMyODY0YWI3MTYzMzdlMWM0Yjk4MWY0OTNkYzNhMjQ4MGQzZGEwY2Q3NmRhNw',
            $headers['Authorization'][0]
        );
    }
}
