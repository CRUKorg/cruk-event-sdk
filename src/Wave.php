<?php

namespace Cruk\EventSdk;

use Cruk\MicroserviceBundle\Service\MicroserviceClient;
use Doctrine\Common\Collections\ArrayCollection;

class Wave extends EWSObject {

  /**
   * @var string
   */
  private $id;

  /**
   * @var string
   */
  private $_eventId;

  /**
   * @var integer A (unique within the context of the parent event) ordering for waves
   */
  private $orderingNumber;

  /**
   * @var string
   */
  private $waveCode;

  /**
   * @var string
   */
  private $waveName;

  /**
   * @var WaveStatus
   */
  private $waveStatus;

  /**
   * @var WaveCancellationReason If the wave Status is changed to "cancelled" then a cancellationReason MUST be supplied
   */
  private $cancellationReason;

  /**
   * @var string If the wave status is changed to "cancelled" then a cancellationReasonDescription MAY be supplied
   */
  private $cancellationReasonDescription;

  /**
   * @var Event
   */
  private $event;

  /**
   * @var \DateTime
   */
  private $startDateTime;

  /**
   * @var RunningNumber
   */
  private $runningNumber;

  /**
   * @var string
   */
  private $runningNumberPrefix;

  /**
   * @var integer
   */
  private $runningNumberStart;

  /**
   * @var \DateTime
   */
  private $registrationOpenDate;

  /**
   * @var \DateTime
   */
  private $registrationCloseDate;

  /**
   * @var CapacityGroup[]|ArrayCollection
   */
  private $capacityGroups;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * Simple function to return the URI for loading the Event.
   *
   * @return string
   */
  public function getUri() {
    return "/waves/{$this->waveCode}";
  }

  /**
   * Get id
   *
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function get_eventId() {
    return $this->_eventId;
  }

  /**
   * @param string $eventId
   */
  public function set_eventId($eventId) {
    $this->_eventId = $eventId;
  }

  /**
   * @return int
   */
  public function getOrderingNumber() {
    return $this->orderingNumber;
  }

  /**
   * @param int $orderingNumber
   * @return Wave
   */
  public function setOrderingNumber($orderingNumber) {
    $this->orderingNumber = $orderingNumber;

    return $this;
  }

  /**
   * Set waveCode
   *
   * @param string $waveCode
   * @return Wave
   */
  public function setWaveCode($waveCode) {
    $this->waveCode = $waveCode;

    return $this;
  }

  /**
   * Get waveCode
   *
   * @return string
   */
  public function getWaveCode() {
    return $this->waveCode;
  }

  /**
   * Set waveName
   *
   * @param string $waveName
   * @return Wave
   */
  public function setWaveName($waveName) {
    $this->waveName = $waveName;

    return $this;
  }

  /**
   * Get waveName
   *
   * @return string
   */
  public function getWaveName() {
    return $this->waveName;
  }

  /**
   * @return WaveStatus
   */
  public function getWaveStatus() {
    return $this->waveStatus;
  }

  /**
   * @param WaveStatus|null $waveStatus
   * @return Wave
   */
  public function setWaveStatus($waveStatus = NULL) {
    $this->waveStatus = $waveStatus;

    return $this;
  }

  /**
   * @return string
   */
  public function getCancellationReason() {
    return $this->cancellationReason;
  }

  /**
   * @param $cancellationReason
   * @return Wave
   */
  public function setCancellationReason($cancellationReason) {
    $this->cancellationReason = $cancellationReason;

    return $this;
  }

  /**
   * @return string|null
   */
  public function getCancellationReasonDescription() {
    return $this->cancellationReasonDescription;
  }

  /**
   * @param string|null $cancellationReasonDescription
   * @return Wave
   */
  public function setCancellationReasonDescription(
    $cancellationReasonDescription
  ) {
    $this->cancellationReasonDescription = $cancellationReasonDescription;

    return $this;
  }

  /**
   * Set event
   *
   * @param Event|null $event
   * @return Wave
   */
  public function setEvent(Event $event = NULL) {
    $this->event = $event;

    return $this;
  }

  /**
   * Get event
   *
   * @return Event
   */
  public function getEvent() {
    return $this->event;
  }

  /**
   * @return CapacityGroup[]|ArrayCollection
   */
  public function getCapacityGroups() {
    return $this->capacityGroups;
  }

  /**
   * @param CapacityGroup[]|ArrayCollection $capacityGroups
   * @return Wave
   */
  public function setCapacityGroups($capacityGroups) {
    $this->capacityGroups = array();
    foreach ($capacityGroups as $capacityGroup) {
      if (is_array($capacityGroup)) {
        $this->capacityGroups[] = new CapacityGroup(
          $this->getMicroserviceClient(),
          $capacityGroup
        );
      }
      elseif (is_object($capacityGroup)) {
        $this->capacityGroups[] = $capacityGroup;
      }
    }

    return $this;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   * @return Wave
   */
  public function setCreated($created) {
    $this->created = $created;

    return $this;
  }

  /**
   * Get created
   *
   * @return \DateTime
   */
  public function getCreated() {
    return $this->created;
  }

  /**
   * Set updated
   *
   * @param \DateTime $updated
   * @return Wave
   */
  public function setUpdated($updated) {
    $this->updated = $updated;

    return $this;
  }

  /**
   * Get updated
   *
   * @return \DateTime
   */
  public function getUpdated() {
    return $this->updated;
  }

  /**
   * Set startDateTime
   *
   * @param \DateTime $startDateTime
   * @return Wave
   */
  public function setStartDateTime($startDateTime) {
    $this->startDateTime = $startDateTime;

    return $this;
  }

  /**
   * Get startDateTime
   *
   * @return \DateTime
   */
  public function getStartDateTime() {
    return $this->startDateTime;
  }

  /**
   * @return int
   */
  public function getRunningNumber() {
    return $this->runningNumber;
  }

  /**
   * Set runningNumberPrefix
   *
   * @param string $runningNumberPrefix
   * @return Wave
   */
  public function setRunningNumberPrefix($runningNumberPrefix) {
    $this->runningNumberPrefix = $runningNumberPrefix;

    return $this;
  }

  /**
   * Get runningNumberPrefix
   *
   * @return string
   */
  public function getRunningNumberPrefix() {
    return $this->runningNumberPrefix;
  }

  /**
   * Set runningNumberStart
   *
   * @param integer $runningNumberStart
   * @return Wave
   */
  public function setRunningNumberStart($runningNumberStart) {
    $this->runningNumberStart = $runningNumberStart;

    return $this;
  }

  /**
   * Get runningNumberStart
   *
   * @return integer
   */
  public function getRunningNumberStart() {
    return $this->runningNumberStart;
  }

  /**
   * Set registrationOpenDate
   *
   * @param \DateTime|null $registrationOpenDate
   * @return Wave
   */
  public function setRegistrationOpenDate($registrationOpenDate) {
    $this->registrationOpenDate = $registrationOpenDate;

    return $this;
  }

  /**
   * Get registrationOpenDate
   *
   * @return \DateTime
   */
  public function getRegistrationOpenDate() {
    return $this->registrationOpenDate;
  }

  /**
   * Set registrationCloseDate
   *
   * @param \DateTime|null $registrationCloseDate
   * @return Wave
   */
  public function setRegistrationCloseDate($registrationCloseDate) {
    $this->registrationCloseDate = $registrationCloseDate;

    return $this;
  }

  /**
   * Get registrationCloseDate
   *
   * @return \DateTime
   */
  public function getRegistrationCloseDate() {
    return $this->registrationCloseDate;
  }


  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    // Should possibly throw an error here, as this does not exist.
    return '/waves';
  }

  /**
   * Get the availability for this event. We do not store this locally, as it is a volatile value.
   *
   * @param string $channel
   * @return array Array containing the event capacity and remaining ticket capacity
   * @throws \GuzzleHttp\Exception\RequestException
   * @throws \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
   * @throws \RuntimeException
   * @throws \GuzzleHttp\Exception\GuzzleException
   * @throws \Exception
   */
  public function getAvailability($channel = 'web') {
    $authenticationCredentials = $this->getMicroserviceClient()->getCredentials(
    );
    return $this->getMicroserviceClient()->call(
      "/waves/{$this->waveCode}/availability?salesChannel={$channel}",
      'GET',
      $authenticationCredentials
    );
  }

  /**
   * Simple function to return the idKey of a class. This allows us to use
   * a common populate function across all objects/classes.
   */
  protected function getIdKey() {
    return 'waveCode';
  }

  /**
   * Simple function to return the structure of the class. This defines how the
   * object should be built and delivered as an array.
   */
  protected function getArrayStructure() {
    return [
      'id',
      '_eventId',
      'orderingNumber',
      'waveCode',
      'waveName',
      'waveStatus',
      'cancellationReason',
      'cancellationReasonDescription',
      'event',
      'startDateTime',
      'runningNumber',
      'runningNumberPrefix',
      'runningNumberStart',
      'registrationOpenDate',
      'registrationCloseDate',
      'capacityGroups',
      'created',
      'updated',
    ];
  }

  /**
   * Simple function to return an array of Waves based on search criteria.
   *
   * @param MicroserviceClient $microserviceClient
   *   Client.
   * @param array $query
   *   Query array for building the query string.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   *
   * @throws EWSClientError
   */
  public static function search(
    MicroserviceClient $microserviceClient,
    $query,
    $class = __CLASS__,
    $path = '/waves'
  ) {
    return parent::search($microserviceClient, $query, $class, $path);
  }

  /**
   * Repeatedly perform a search of a paginated resource until there are no more results
   *
   * @param MicroserviceClient $microserviceClient
   *   Client.
   * @param array $query
   *   Query array for building the query string.
   * @param integer $pageSize
   *   Number of results to request per page.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   */
  public static function searchPaginated(
    MicroserviceClient $microserviceClient,
    $query,
    $pageSize,
    $class = __CLASS__,
    $path = '/waves'
  ) {
    return parent::searchPaginated(
      $microserviceClient,
      $query,
      $pageSize,
      $class,
      $path
    );
  }

  /**
   * Simple function to return an array of Waves based on search criterias.
   *
   * @param MicroserviceClient $microserviceClient
   *   Client.
   * @param array $queries
   *   Array of query arrays for building the query string.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   *
   * @throws EWSClientError
   */
  public static function searches(
    MicroserviceClient $microserviceClient,
    $queries,
    $class = __CLASS__,
    $path = '/waves'
  ) {
    return parent::searches($microserviceClient, $queries, $class, $path);
  }
}
