<?php

namespace Cruk\EventSdk;

class Registration extends EWSObject
{
    /**
     * idKey
     */
    private static $idKey = 'registrationId';
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
     * tickets
     *
     * @var integer
     */
    private $tickets;

    /**
     * participants
     *
     * @var array
     */
    private $participants;

    /**
     * Registration constructor.
     * @param EWSClient $client
     * @param mixed $data
     * @param Event $event
     */
    public function __construct(EWSClient $client, $data, Event $event)
    {
        $this->event = $event;
        parent::__construct($client, $data);
    }

    /**
     * Simple function to create a participant associated with this registration
     *
     * @param mixed $data
     *
     * @return Participant
     */
    public function createParticipant($data)
    {
        $participant = new Participant($this->client, $this->event, $this, $data);
        $this->participants[] = $participant;
        $participant->create();
        return $participant;
    }

    /**
     * Update an event registration's status
     *
     * @param string $eventCode
     *   Event code
     * @param string $registrationId
     *   Registration ID for the event
     * @param string $statusCode
     *   New status code for the registration
     * @return array
     */
    public function updateStatus($statusCode)
    {
        $this->patch(['status' => $statusCode]);
    }

    /**
     * @return int
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    /**
     * @return int
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param int $tickets
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * @return array
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants(array $participants)
    {
        $this->participants = $participants;
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
     * Simple function to create a donation associated with this Registration
     */
    public function createDonation($data)
    {
        $donation = new Donation($this->client, $this->event, $this, $data);
        $donation->create();
        $this->setDonationId($donation->getId());
        return $donation;
    }

    /**
     * Create a donation
     *
     *
     */

    /**
     * Simple function to return the structure of the class. This defines how the
     * object should be built and delivered as an array.
     */
    protected function getArrayStructure()
    {
        // We return a different array depending on whether we have the
        // registrationId set.
        if ($this->registrationId) {
            return [
                'registrationId',
                'timeOut',
                'status',
                'donationId',
            ];
        }
        return [
            'tickets',
        ];
    }

    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     */
    protected function getIdKey()
    {
        return self::$idKey;
    }

    protected function getUri()
    {
        return $this->client->getPath() . "/events/{$this->event->getEventCode()}/registrations/{$this->registrationId}.json";
    }

    protected function getCreateUri()
    {
        return $this->client->getPath() . "/events/{$this->event->getEventCode()}/registrations.json";
    }
}
