<?php

namespace Cruk\EventSdk\Test;

use Cruk\EventSdk\EWSClientError;

class EWSClientErrorTest extends TestCase
{
    public function testDataCanBeRetrieved()
    {
        $data = ['foo' => 'bar'];
        $error = new EWSClientError('', 0, null, $data);

        $this->assertSame($data, $error->getData());
    }
}
