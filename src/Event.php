<?php

namespace Cruk\EventSdk;

class Event extends EWSObject
{
    /**
     * Event code
     *
     * @var string
     */
    private $eventCode;

    /**
     * Event name
     *
     * @var string
     */
    private $eventName;
    /**
     * Event type
     *
     * @var string
     */
    private $eventType;
    /**
     * eventDistance
     *
     * @var string
     */
    private $eventDistance;
    /**
     * EventDistanceUOM
     *
     * @var string
     */
    private $eventDistanceUOM;
    /**
     * sponsorshipPageCreationDuration
     *
     * @var string
     */
    private $sponsorshipPageCreationDuration;
    /**
     * ageFrom
     *
     * @var integer
     */
    private $ageFrom;
    /**
     * ageTo
     *
     * @var integer
     */
    private $ageTo;
    /**
     * ageCriteria
     *
     * @var string
     */
    private $ageCriteria;
    /**
     * gender
     *
     * @var string
     */
    private $gender;
    /**
     * defaultSiebelRegistrationStatus
     *
     * @var string
     */
    private $defaultSiebelRegistrationStatus;
    /**
     * Waves
     *
     * TODO: Add a Waves class to handle these properly.
     *
     * @var array
     */
    private $waves;
    /**
     * Registrations that are associated with this event.
     *
     * @var array
     */
    private $registrations;

    /**
     * Simple function to return the URI for loading the Event.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->client->getPath() . "/events/{$this->eventCode}.json";
    }

    /**
     * Simple function to return the URI for creating the Event.
     *
     * @return string
     */
    public function getCreateUri()
    {
        // Should possibly throw an error here, as this does not exist.
        return $this->client->getPath() . "/events.json";
    }

    /**
     * Get the availability for this event. We do not store this locally, as it is a volatile value.
     *
     * @return array
     *   Array containing the event capacity and remaining ticket capacity
     */
    public function getAvailability()
    {
        $uri = $this->client->getPath() . "/events/{$this->eventCode}/availability.json";
        return $this->client->requestJson('GET', $uri);
    }

    /**
     * Create a new registration for an event
     *
     * @param integer $numTickets
     *   Number of tickets required (must be an integer between 1 and 10).
     * @return Registration
     *   Response body containing the new registration
     */
    public function createRegistration($numTickets = 1)
    {
        $registration = new Registration($this->client, ['tickets' => $numTickets], $this);
        $this->registrations[] = $registration;
        $registration->create();
        return $registration;
    }

    /**
     * @return string
     */
    public function getEventCode()
    {
        return $this->eventCode;
    }

    /**
     * @param string $eventCode
     */
    public function setEventCode($eventCode)
    {
        $this->eventCode = $eventCode;
    }

    /**
     * @return mixed
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param mixed $eventName
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param mixed $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @return mixed
     */
    public function getEventDistance()
    {
        return $this->eventDistance;
    }

    /**
     * @param mixed $eventDistance
     */
    public function setEventDistance($eventDistance)
    {
        $this->eventDistance = $eventDistance;
    }

    /**
     * @return mixed
     */
    public function getEventDistanceUOM()
    {
        return $this->eventDistanceUOM;
    }

    /**
     * @param mixed $eventDistanceUOM
     */
    public function setEventDistanceUOM($eventDistanceUOM)
    {
        $this->eventDistanceUOM = $eventDistanceUOM;
    }

    /**
     * @return mixed
     */
    public function getSponsorshipPageCreationDuration()
    {
        return $this->sponsorshipPageCreationDuration;
    }

    /**
     * @param mixed $sponsorshipPageCreationDuration
     */
    public function setSponsorshipPageCreationDuration($sponsorshipPageCreationDuration)
    {
        $this->sponsorshipPageCreationDuration = $sponsorshipPageCreationDuration;
    }

    /**
     * @return mixed
     */
    public function getAgeFrom()
    {
        return $this->ageFrom;
    }

    /**
     * @param mixed $ageFrom
     */
    public function setAgeFrom($ageFrom)
    {
        $this->ageFrom = $ageFrom;
    }

    /**
     * @return mixed
     */
    public function getAgeTo()
    {
        return $this->ageTo;
    }

    /**
     * @param mixed $ageTo
     */
    public function setAgeTo($ageTo)
    {
        $this->ageTo = $ageTo;
    }

    /**
     * @return mixed
     */
    public function getAgeCriteria()
    {
        return $this->ageCriteria;
    }

    /**
     * @param mixed $ageCriteria
     */
    public function setAgeCriteria($ageCriteria)
    {
        $this->ageCriteria = $ageCriteria;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getDefaultSiebelRegistrationStatus()
    {
        return $this->defaultSiebelRegistrationStatus;
    }

    /**
     * @param mixed $defaultSiebelRegistrationStatus
     */
    public function setDefaultSiebelRegistrationStatus($dsrs)
    {
        $this->defaultSiebelRegistrationStatus = $dsrs;
    }

    /**
     * @return mixed
     */
    public function getWaves()
    {
        return $this->waves;
    }

    /**
     * @param mixed $waves
     */
    public function setWaves($waves)
    {
        $this->waves = $waves;
    }

    /**
     * @return mixed
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * @param mixed $registrations
     */
    public function setRegistrations($registrations)
    {
        $this->registrations = $registrations;
    }

    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     */
    protected function getIdKey()
    {
        return 'eventCode';
    }

    /**
     * Simple function to return the structure of the class. This defines how the
     * object should be built and delivered as an array.
     */
    protected function getArrayStructure()
    {
        return [
            'eventCode',
            'eventName',
            'eventType',
            'eventDistance',
            'eventDistanceUOM',
            'sponsorshipPageCreationDuration',
            'ageFrom',
            'ageTo',
            'ageCriteria',
            'gender',
            'defaultSiebelRegistrationStatus',
            'waves',
        ];
    }
}
