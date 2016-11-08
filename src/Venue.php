<?php

namespace Cruk\EventSdk;

class Venue extends EWSObject {

  /**
   * @var string
   */
  private $id;

  /**
   * @var float
   */
  private $meetingPointLongitude;

  /**
   * @var float
   */
  private $meetingPointLatitude;

  /**
   * @var string
   */
  private $meetingPointDescription;

  /**
   * @var string
   */
  private $courseDescription;

  /**
   * @var string
   */
  private $accessibilityDescription;

  /**
   * @var string
   */
  private $travelNotes;

  /**
   * @var string
   */
  private $spectatorAccessNotes;

  /**
   * @var boolean
   */
  private $disabilityAccessible;

  /**
   * @var boolean
   */
  private $parkingAvailable;

  /**
   * @var boolean
   */
  private $dogsAllowed;

  /**
   * @var boolean
   */
  private $suitableForPushchairs;

  /**
   * @var boolean
   */
  private $showersAvailable;

  /**
   * @var boolean
   */
  private $toiletsAvailable;

  /**
   * @var boolean
   */
  private $bagDropAvailable;

  /**
   * @var boolean
   */
  private $refreshmentsAvailable;

   /**
   * {@inheritdoc}
   */
  public function getUri() {
    return $this->client->getPath() . "/venues/{$this->id}";
  }

  /**
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param string $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @return float
   */
  public function getMeetingPointLongitude() {
    return $this->meetingPointLongitude;
  }

  /**
   * @param float $meetingPointLongitude
   */
  public function setMeetingPointLongitude($meetingPointLongitude) {
    $this->meetingPointLongitude = $meetingPointLongitude;
  }

  /**
   * @return float
   */
  public function getMeetingPointLatitude() {
    return $this->meetingPointLatitude;
  }

  /**
   * @param float $meetingPointLatitude
   */
  public function setMeetingPointLatitude($meetingPointLatitude) {
    $this->meetingPointLatitude = $meetingPointLatitude;
  }

  /**
   * @return string
   */
  public function getMeetingPointDescription() {
    return $this->meetingPointDescription;
  }

  /**
   * @param string $meetingPointDescription
   */
  public function setMeetingPointDescription($meetingPointDescription) {
    $this->meetingPointDescription = $meetingPointDescription;
  }

  /**
   * @return string
   */
  public function getCourseDescription() {
    return $this->courseDescription;
  }

  /**
   * @param string $courseDescription
   */
  public function setCourseDescription($courseDescription) {
    $this->courseDescription = $courseDescription;
  }

  /**
   * @return string
   */
  public function getAccessibilityDescription() {
    return $this->accessibilityDescription;
  }

  /**
   * @param string $accessibilityDescription
   */
  public function setAccessibilityDescription($accessibilityDescription) {
    $this->accessibilityDescription = $accessibilityDescription;
  }

  /**
   * @return string
   */
  public function getTravelNotes() {
    return $this->travelNotes;
  }

  /**
   * @param string $travelNotes
   */
  public function setTravelNotes($travelNotes) {
    $this->travelNotes = $travelNotes;
  }

  /**
   * @return string
   */
  public function getSpectatorAccessNotes() {
    return $this->spectatorAccessNotes;
  }

  /**
   * @param string $spectatorAccessNotes
   */
  public function setSpectatorAccessNotes($spectatorAccessNotes) {
    $this->spectatorAccessNotes = $spectatorAccessNotes;
  }

  /**
   * @return boolean
   */
  public function getDisabilityAccessible() {
    return $this->disabilityAccessible;
  }

  /**
   * @param boolean $disabilityAccessible
   */
  public function setDisabilityAccessible($disabilityAccessible) {
    $this->disabilityAccessible = $disabilityAccessible;
  }

  /**
   * @return boolean
   */
  public function getParkingAvailable() {
    return $this->parkingAvailable;
  }

  /**
   * @param boolean $parkingAvailable
   */
  public function setParkingAvailable($parkingAvailable) {
    $this->parkingAvailable = $parkingAvailable;
  }

  /**
   * @return boolean
   */
  public function getDogsAllowed() {
    return $this->dogsAllowed;
  }

  /**
   * @param boolean $dogsAllowed
   */
  public function setDogsAllowed($dogsAllowed) {
    $this->dogsAllowed = $dogsAllowed;
  }

  /**
   * @return boolean
   */
  public function getSuitableForPushchairs() {
    return $this->suitableForPushchairs;
  }

  /**
   * @param boolean $suitableForPushchairs
   */
  public function setSuitableForPushchairs($suitableForPushchairs) {
    $this->suitableForPushchairs = $suitableForPushchairs;
  }

  /**
   * @return boolean
   */
  public function getShowersAvailable() {
    return $this->showersAvailable;
  }

  /**
   * @param boolean $showersAvailable
   */
  public function setShowersAvailable($showersAvailable) {
    $this->showersAvailable = $showersAvailable;
  }

  /**
   * @return boolean
   */
  public function getToiletsAvailable() {
    return $this->toiletsAvailable;
  }

  /**
   * @param boolean $toiletsAvailable
   */
  public function setToiletsAvailable($toiletsAvailable) {
    $this->toiletsAvailable = $toiletsAvailable;
  }

  /**
   * @return boolean
   */
  public function getBagDropAvailable() {
    return $this->bagDropAvailable;
  }

  /**
   * @param boolean $bagDropAvailable
   */
  public function setBagDropAvailable($bagDropAvailable) {
    $this->bagDropAvailable = $bagDropAvailable;
  }

  /**
   * @return boolean
   */
  public function getRefreshmentsAvailable() {
    return $this->refreshmentsAvailable;
  }

  /**
   * @param boolean $refreshmentsAvailable
   */
  public function setRefreshmentsAvailable($refreshmentsAvailable) {
    $this->refreshmentsAvailable = $refreshmentsAvailable;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreateUri() {
    throw new EWSClientError('Unable to create Venues');
  }

  /**
   * {@inheritdoc}
   */
  protected function getSearchUri() {
    throw new EWSClientError('Unable to search for Venues');
  }

  /**
   * {@inheritdoc}
   */
  protected function getIdKey() {
    return 'id';
  }

  /**
   * {@inheritdoc}
   */
  protected function getArrayStructure() {
    return [
      'id',
      'meetingPointLongitude',
      'meetingPointLatitude',
      'meetingPointDescription',
      'courseDescription',
      'accessibilityDescription',
      'travelNotes',
      'spectatorAccessNotes',
      'disabilityAccessible',
      'parkingAvailable',
      'dogsAllowed',
      'suitableForPushchairs',
      'showersAvailable',
      'toiletsAvailable',
      'bagDropAvailable',
      'refreshmentsAvailable',
    ];
  }

}
