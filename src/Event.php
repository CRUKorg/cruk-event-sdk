<?php

namespace Cruk\EventSdk;

class Event extends EWSObject {
  /**
   * @var string
   */
  private $id;

  /**
   * @var string This is the event series name from Siebel
   */
  private $eventName;

  /**
   * @var string This is the event series code from Siebel")
   */
  private $eventCode;

  /**
   * @var string This is the event series code from last year
   */
  private $previousEventCode;

  /**
   * @var OrganiserCategory
   */
  private $organiserCategory;

  /**
   * @var EventStatus
   */
  private $eventStatus;

  /**
   * @var CancellationReason If the event Status is changed to "cancelled" then a cancellationReason MUST be supplied
   */
  private $cancellationReason;

  /**
   * @var string If the event status is changed to "cancelled" then a cancellationReasonDescription MAY be supplied
   */
  private $cancellationReasonDescription;

  /**
   * @var string Searchable text about the event
   */
  private $description;

  /**
   * @var string
   */
  private $criticalAmendMessage;

  /**
   * @var Owner Optional owner of the event
   */
  private $owner;

  /**
   * @var \DateTime
   */
  private $startDateTime;

  /**
   * @var \DateTime
   */
  private $endDateTime;

  /**
   * @var string Reference to a Venue id from the Venue service
   */
  private $venueReference;

  /**
   * @var string Reference to a Sub Proposition id
   */
  private $subPropositionReference;

  /**
   * @var FundraisingRestriction
   */
  private $fundraisingRestriction;

  /**
   * @var FundraisingProduct
   */
  private $fundraisingProduct;

  /**
   * @var ArrayCollection|EventType[]
   */
  private $eventTypes;

  /**
   * @var ArrayCollection|VenueInfo[]
   */
  private $venueInfo;

  /**
   * @var ArrayCollection|ConfirmationPageSettings[]:
   */
  private $confirmationPageSettings;

  /**
   * @var float
   */
  private $distance;

  /**
   * @var DistanceUnit
   */
  private $distanceUnit;

  /**
   * @var integer
   */
  private $ageFrom;

  /**
   * @var integer
   */
  private $ageTo;

  /**
   * @var Gender
   */
  private $gender;

  /**
   * @var FinancialYear
   */
  private $financialYear;

  /**
   * @var boolean Setting to true will allow us to assign running number start values to waves and also generate running numbers for participants. NOTE: You can't change it after a running number has been set for any of the waves in the event!
   */
  private $runningNumberRequired;

  /**
   * @var boolean
   */
  private $fundraisingEnabled;

  /**
   * @var boolean
   */
  private $paidTicketsRequired;

  /**
   * @var ArrayCollection|Wave[]
   */
  private $waves;

  /**
   * @var integer
   */
  private $allowedOpenWaves;

  /**
   * @var ArrayCollection|EventConfig[]
   */
  private $configs;

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
    return $this->client->getPath() . "/events/{$this->eventCode}";
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getEventName() {
    return $this->eventName;
  }


  public function setEventName($eventName) {
    $this->eventName = $eventName;
  }

  public function getEventCode() {
    return $this->eventCode;
  }


  public function setEventCode($eventCode) {
    $this->eventCode = $eventCode;
  }

  public function getPreviousEventCode() {
    return $this->previousEventCode;
  }


  public function setPreviousEventCode($previousEventCode) {
    $this->previousEventCode = $previousEventCode;
  }

  public function getOrganiserCategory() {
    return $this->organiserCategory;
  }


  public function setOrganiserCategory($organiserCategory) {
    $this->organiserCategory = $organiserCategory;
  }

  public function getEventStatus() {
    return $this->eventStatus;
  }

  public function setEventStatus($eventStatus) {
    $this->eventStatus = $eventStatus;
  }

  public function getCancellationReason() {
    return $this->cancellationReason;
  }

  public function setCancellationReason($cancellationReason) {
    $this->cancellationReason = $cancellationReason;
  }

  public function getCancellationReasonDescription() {
    return $this->cancellationReasonDescription;
  }

  public function setCancellationReasonDescription($cancellationReasonDescription) {
    $this->cancellationReasonDescription = $cancellationReasonDescription;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function getCriticalAmendMessage() {
    return $this->criticalAmendMessage;
  }

  public function setCriticalAmendMessage($criticalAmendMessage) {
    $this->criticalAmendMessage = $criticalAmendMessage;
  }

  public function getOwner() {
    return $this->owner;
  }

  public function setOwner($owner) {
    $this->owner = $owner;
  }

  public function getStartDateTime() {
    return $this->startDateTime;
  }

  public function setStartDateTime($startDateTime) {
    $this->startDateTime = $startDateTime;
  }

  public function getEndDateTime() {
    return $this->endDateTime;
  }

  public function setEndDateTime($endDateTime) {
    $this->endDateTime = $endDateTime;
  }

  public function getVenueReference() {
    return $this->venueReference;
  }

  public function setVenueReference($venueReference) {
    $this->venueReference = $venueReference;
  }

  public function getSubPropositionReference() {
    return $this->subPropositionReference;
  }

  public function setSubPropositionReference($subPropositionReference) {
    $this->subPropositionReference = $subPropositionReference;
  }

  public function getFundraisingRestriction() {
    return $this->fundraisingRestriction;
  }

  public function setFundraisingRestriction($fundraisingRestriction) {
    $this->fundraisingRestriction = $fundraisingRestriction;
  }

  public function getFundraisingProduct() {
    return $this->fundraisingProduct;
  }

  public function setFundraisingProduct($fundraisingProduct) {
    $this->fundraisingProduct = $fundraisingProduct;
  }

  public function getEventTypes() {
    return $this->eventTypes;
  }

  public function setEventTypes($eventTypes) {
    $this->eventTypes = $eventTypes;
  }

  public function getVenueInfo() {
    return $this->venueInfo;
  }

  public function setVenueInfo($venueInfo) {
    $this->venueInfo = $venueInfo;
    return $this;
  }

  /**
   * @return ArrayCollection|ConfirmationPageSettings[]
   */
  public function getConfirmationPageSettings() {
    return $this->confirmationPageSettings;
  }

  /**
   * @param $confirmationPageSettings
   *
   * @return $this
   */
  public function setConfirmationPageSettings($confirmationPageSettings) {
    $this->confirmationPageSettings = $confirmationPageSettings;
    return $this;
  }

  public function getDistance() {
    return $this->distance;
  }

  public function setDistance($distance) {
    $this->distance = $distance;
  }

  public function getDistanceUnit() {
    return $this->distanceUnit;
  }

  public function setDistanceUnit($distanceUnit) {
    $this->distanceUnit = $distanceUnit;
  }

  public function getAgeFrom() {
    return $this->ageFrom;
  }

  public function setAgeFrom($ageFrom) {
    $this->ageFrom = $ageFrom;
  }

  public function getAgeTo() {
    return $this->ageTo;
  }

  public function setAgeTo($ageTo) {
    $this->ageTo = $ageTo;
  }

  public function getGender() {
    return $this->gender;
  }

  public function setGender($gender) {
    $this->gender = $gender;
  }

  public function getFinancialYear() {
    return $this->financialYear;
  }

  public function setFinancialYear($financialYear) {
    $this->financialYear = $financialYear;
  }

  public function getRunningNumberRequired() {
    return $this->runningNumberRequired;
  }

  public function setRunningNumberRequired($runningNumberRequired) {
    $this->runningNumberRequired = $runningNumberRequired;
  }

  /**
   * @return boolean
   */
  public function getFundraisingEnabled() {
    return $this->fundraisingEnabled;
  }

  /**
   * @param boolean $fundraisingEnabled
   */
  public function setFundraisingEnabled($fundraisingEnabled) {
    $this->fundraisingEnabled = $fundraisingEnabled;
  }

  /**
   * @return boolean
   */
  public function getPaidTicketsRequired() {
    return $this->paidTicketsRequired;
  }

  /**
   * @param boolean $paidTicketsRequired
   */
  public function setPaidTicketsRequired($paidTicketsRequired) {
    $this->paidTicketsRequired = $paidTicketsRequired;
  }

  public function getWaves() {
    return $this->waves;
  }

  public function setWaves($waves) {
    $this->waves = array();
    foreach ($waves as $wave) {
      if (is_array($wave)) {
        $this->waves[] = new Wave($this->client, $wave, $this);
      }
      elseif (is_object($capacityGroup)) {
        $this->waves[] = $wave;
      }
    }

    return $this;
  }

  public function getAllowedOpenWaves() {
    return $this->allowedOpenWaves;
  }

  public function setAllowedOpenWaves($allowedOpenWaves) {
    $this->allowedOpenWaves = $allowedOpenWaves;
  }

  public function getConfigs() {
    return $this->configs;
  }

  public function setConfigs($configs) {
    $this->configs = $configs;
  }

  public function getCreated() {
    return $this->created;
  }

  public function setCreated($created) {
    $this->created = $created;
  }

  public function getUpdated() {
    return $this->updated;
  }

  public function setUpdated($updated) {
    $this->updated = $updated;
  }

  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    // Should possibly throw an error here, as this does not exist.
    return $this->client->getPath() . "/events";
  }

  /**
   * Simple function to return the URI that should be used to search for objects
   * from the EWS.
   *
   * @return string
   */
  protected function getSearchUri() {
    // Should possibly throw an error here, as this does not exist.
    return $this->client->getPath() . "/events";
  }

  /**
   * Get the availability for this event. We do not store this locally, as it is a volatile value.
   *
   * @return array
   *   Array containing the event capacity and remaining ticket capacity
   */
  public function getAvailability($channel = 'web') {
    $uri = $this->client->getPath() . "/events/{$this->eventCode}/availability?salesChannel={$channel}";
    return $this->client->requestJson('GET', $uri);
  }

  /**
   * Simple function to return the idKey of a class. This allows us to use
   * a common populate function across all objects/classes.
   */
  protected function getIdKey() {
    return 'eventCode';
  }

  /**
   * Simple function to return the structure of the class. This defines how the
   * object should be built and delivered as an array.
   */
  protected function getArrayStructure() {
    return [
      'id',
      'eventName',
      'eventCode',
      'previousEventCode',
      'organiserCategory',
      'eventStatus',
      'cancellationReason',
      'cancellationReasonDescription',
      'description',
      'criticalAmendMessage',
      'owner',
      'startDateTime',
      'endDateTime',
      'venueReference',
      'subPropositionReference',
      'fundraisingRestriction',
      'fundraisingProduct',
      'eventTypes',
      'venueInfo',
      'confirmationPageSettings',
      'distance',
      'distanceUnit',
      'ageFrom',
      'ageTo',
      'gender',
      'financialYear',
      'runningNumberRequired',
      'fundraisingEnabled',
      'paidTicketsRequired',
      'waves',
      'allowedOpenWaves',
      'configs',
      'created',
      'updated',
    ];
  }

  /**
   * Simple function to return an array of Events based on search criteria.
   *
   * @param EWSClient $client
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
  public static function search($client, $query, $class = __CLASS__, $path = '/events') {
    return parent::search($client, $query, $class, $path);
  }

  /**
   * Repeatedly perform a search of a paginated resource until there are no more results
   *
   * @param EWSClient $client
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
  public static function searchPaginated($client, $query, $pageSize, $class = __CLASS__, $path = '/events') {
    return parent::searchPaginated($client, $query, $pageSize, $class, $path);
  }

  /**
   * Simple function to return an array of Events based on search criterias.
   *
   * @param EWSClient $client
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
  public static function searches($client, $queries, $class = __CLASS__, $path = '/events') {
    return parent::searches($client, $queries, $class, $path);
  }
}
