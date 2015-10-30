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
        $this->assertSame('/api/v1/events', $request->getUri()->getPath());

        // Assert the request includes no query parameters by default.
        $this->assertSame('', $request->getUri()->getQuery());
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
}
