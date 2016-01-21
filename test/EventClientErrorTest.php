<?php

namespace Cruk\EventSdk\Test;

use Cruk\EventSdk\EventClientError;

class EventClientErrorTest extends TestCase
{
    public function testDataCanBeRetrieved()
    {
        $data = ['foo' => 'bar'];
        $error = new EventClientError('', 0, null, $data);

        $this->assertSame($data, $error->getData());
    }
}
