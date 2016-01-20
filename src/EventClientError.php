<?php

namespace Cruk\EventSdk;

class EventClientError extends \Exception
{

    /**
     * @var array $data
     *   Data array as returned by the EWS. It may be useful for us to be able to get a hold of this.
     */
    protected $data;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Override the default constructor so that we can send through the data array sent from EWS.
     *
     * @param string $message
     *   The message that is displayed to the users
     * @param int $code
     *   Code
     * @param Exception $previous
     *   Previous exception
     * @param array $data
     *   Data array as sent from EWS. This can be retrieved, or is used
     */
    public function __construct($message = '', $code = 0, Exception $previous = null, array $data = array())
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }
}
