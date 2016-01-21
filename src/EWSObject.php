<?php

namespace Cruk\EventSdk;

/**
 * @file
 *
 * Simple file to create the EWS interface that all other EWS classes will implement.
 */
abstract class EWSObject
{

    /** @var EWSClient */
    protected $client;

    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     */
    abstract protected function getIdKey();
    abstract protected function getGetUri();
    abstract protected function getPostUri();

    /**
     * Create a new EWSObject
     *
     * @param EWSClient $client
     *   EWSClient which does all the HTTP requests for us.
     */
    public function __construct(EWSClient $client)
    {
        $this->client = $client;
    }

    /**
     * Populate an EWSClient Object with data sent through to us.
     *
     * @param mixed $data
     * @return void
     */
    public function populate($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $setter = 'set' . ucfirst($key);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        } elseif (is_string($data) && strlen($data)) {
            $key = $this->getIdKey();
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($data);
                $this->load();
            }
        }
    }

    /**
     * Load an object from the EWS and set the local variables.
     *
     * @return EWSObject
     */
    public function load()
    {
        $response = $this->client->requestJson('GET', $this->getGetUri());
        $this->populate($response);
        return $this;
    }

    /**
     * Create a new object on the EWS and set the local variables
     *
     * @return EWSObject
     */
    public function create()
    {
        $response = $this->client->requestJson('GET', $this->getPostUri());
        $this->populate($response);
        return $this;
    }
}
