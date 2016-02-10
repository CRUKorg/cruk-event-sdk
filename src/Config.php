<?php

namespace Cruk\EventSdk;

class Config extends EWSObject
{
    /**
     * configKey
     *
     * @var string
     */
    private $configKey;

    /**
     * configValue
     *
     * @var string
     */
    private $configValue;

    /**
     * event
     *
     * @var Event
     */
    private $event;

    /**
     * Donation constructor.
     * @param EWSClient $client
     * @param $data
     * @param Event $event
     * @param Registration $registration
     */
    public function __construct(EWSClient $client, $data, Event $event)
    {
        $this->event = $event;
        parent::__construct($client, $data);
    }

    /**
     * Simple function that allows us to get an array of configurations
     * @param Event $event
     * return Config[]
     */
    public static function getConfigsForEvent($event)
    {
        $path = $event->getClient()->getPath() . "/events/{$event->getEventCode()}/configs.json";
        $json = $event->client->requestJson('GET', $path);
        $configs = array();
        foreach ($json as $config) {
            $config = new Config($event->getClient(), $config, $event);
            $configs[$config->getConfigKey()] = $config;
        }
        return $configs;
    }

    /**
     * @return string
     */
    public function getConfigKey()
    {
        return $this->configKey;
    }

    /**
     * @param string $configKey
     */
    public function setConfigKey($configKey)
    {
        $this->configKey = $configKey;
    }

    /**
     * @return string
     */
    public function getConfigValue()
    {
        return $this->configValue;
    }

    /**
     * @param string $configValue
     */
    public function setConfigValue($configValue)
    {
        $this->configValue = $configValue;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     *
     * @return string
     */
    protected function getIdKey()
    {
        return 'configKey';
    }

    /**
     * Simple function to return the URI that should be used to GET this object
     * from the EWS.
     *
     * @return string
     */
    protected function getUri()
    {
        return $this->client->getPath() . "/events/{$this->event->getEventCode()}/configs/{$this->configKey}.json";
    }

    /**
     * Simple function to return the URI that should be used to POST/UPDATE this object
     * from the EWS.
     *
     * @return string
     */
    protected function getCreateUri()
    {
        return $this->client->getPath() . "/events/{$this->event->getEventCode()}/configs.json";
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
            'configKey',
            'configValue',
        ];
    }
}
