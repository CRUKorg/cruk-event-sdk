<?php

namespace Cruk\EventSdk;

class Extra extends EWSObject
{
    /**
     * extraKey
     *
     * @var string
     */
    private $extraKey;

    /**
     * extraValue
     *
     * @var string
     */
    private $extraValue;

    /**
     * event
     *
     * @var Participant
     */
    private $participant;

    /**
     * Extra constructor.
     * @param EWSClient $client
     * @param $data
     * @param Participant $participant
     */
    public function __construct(EWSClient $client, $data, Participant $participant)
    {
        $this->participant = $participant;
        parent::__construct($client, $data);
        $this->participant->addExtra($this);
    }

    /**
     * Simple function that allows us to get an array of extras
     * @param Participant $participant
     * @return Extra[]
     */
    public static function getExtrasForParticipant($participant)
    {
        $path = $participant->getClient()->getPath() . "/events/{$participant->getEvent()->getEventCode()}"
            ."/registrations/{$participant->getRegistration()->getRegistrationId()}"
            ."/participantInfos/{$participant->getUniqueId()}"
            ."/extras.json";
        $json = $participant->client->requestJson('GET', $path);
        $extras = array();
        foreach ($json as $extra) {
            $extra = new Extra($participant->getClient(), $extra, $participant);
            $extras[$extra->getExtraKey()] = $extra;
        }
        return $extras;
    }

    /**
     * @return string
     */
    public function getExtraKey()
    {
        return $this->extraKey;
    }

    /**
     * @param string $extraKey
     */
    public function setExtraKey($extraKey)
    {
        $this->extraKey = $extraKey;
    }

    /**
     * @return string
     */
    public function getExtraValue()
    {
        return $this->extraValue;
    }

    /**
     * @param string $extraValue
     */
    public function setExtraValue($extraValue)
    {
        $this->extraValue = $extraValue;
    }

    /**
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param Participant $participant
     */
    public function setParticipant($participant)
    {
        $this->participant = $participant;
    }

    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     *
     * @return string
     */
    protected function getIdKey()
    {
        return 'extraKey';
    }

    /**
     * Simple function to return the URI that should be used to GET this object
     * from the EWS.
     *
     * @return string
     */
    protected function getUri()
    {
        return $this->participant->getClient()->getPath()
            ."/events/{$this->participant->getEvent()->getEventCode()}"
            ."/registrations/{$this->participant->getRegistration()->getRegistrationId()}"
            ."/participantInfos/{$this->participant->getUniqueId()}"
            ."/extras/{$this->extraKey}.json";
    }

    /**
     * Override the update function so that we call PATCH rather than PUT.
     *
     * @param string $method
     *   Method used.
     * @return EWSObject
     */
    public function update($method = 'PATCH')
    {
        parent::update($method);
    }

    /**
     * Simple function to return the URI that should be used to POST/UPDATE this object
     * from the EWS.
     *
     * @return string
     */
    protected function getCreateUri()
    {
        return $this->participant->getClient()->getPath()
        ."/events/{$this->participant->getEvent()->getEventCode()}"
        ."/registrations/{$this->participant->getRegistration()->getRegistrationId()}"
        ."/participantInfos/{$this->participant->getUniqueId()}"
        ."/extras.json";
    }

    /**
     * Simple function to return the structure of the class. This defines how the
     * object should be built and delivered as an array.
     *
     * @return array
     */
    protected function getArrayStructure()
    {
        return [
            'extraKey',
            'extraValue',
        ];
    }
}
