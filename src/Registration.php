<?php

namespace Cruk\EventSdk;

use GuzzleHttp\ClientInterface;

class Registration extends EWSObject
{
    /**
     * registrationId
     *
     * @var integer
     */
    private $registrationId;

    /**
     * timeOut
     *
     * @var string
     */
    private $timeOut;

    /**
     * unixTimeOut
     *
     * @var integer
     */
    private $unixTimeOut;

    /**
     * status
     *
     * @var string
     */
    private $status;

    /**
     * event
     *
     * @var Event
     */
    private $event;
    /**
     * donationId
     *
     * @var string
     */
    private $donationId;

    /**
     * idKey
     */
    private static $idKey = 'registrationId';

    public function __construct(ClientInterface $http, $event, $numTickets)
    {
        $this->event = $event;
        $this->populate($data);
    }

    /**
     * @return int
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    /**
     * @param int $registrationId
     */
    public function setRegistrationId($registrationId)
    {
        $this->registrationId = $registrationId;
    }

    /**
     * @return string
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @param string $timeOut
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;
        $this->unixTimeOut = strtotime($timeOut);
    }

    /**
     * @return mixed
     */
    public function getUnixTimeOut()
    {
        return $this->unixTimeOut;
    }

    /**
     * @return status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param status $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return donationId
     */
    public function getDonationId()
    {
        return $this->donationId;
    }

    /**
     * @param donationId $donationId
     */
    public function setDonationId($donationId)
    {
        $this->donationId = $donationId;
    }

    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     */
    protected function getIdKey()
    {
        return self::$idKey;
    }

    protected function getGetUri()
    {
        return $this->path . "/events/{$this->event->getEventCode()}/registrations/{$this->eventCode}.json";
    }

    protected function getPostUri()
    {
        return $this->path . "/events/{$this->event->getEventCode()}/registrations.json";
    }
}
