<?php

namespace Cruk\EventSdk\Test;

use Cruk\EventSdk\EventClientError;

class EventClientErrorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * EventClientError class
     */
    private $ewse;

    public function setUp()
    {
        $this->ewse = new EventClientError();
        parent::setUp();
    }

    public function testDataCanBeRetrieved()
    {
        $this->assertSame(array(), $this->ewse->getData());
    }

    public function testDataCanBeSet()
    {
        $data = array(
            'error' => 'Awesome',
        );
        $this->ewse->setData($data);
        $this->assertSame($data, $this->ewse->getData());
    }
}
