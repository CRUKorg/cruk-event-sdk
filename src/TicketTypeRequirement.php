<?php

namespace Cruk\EventSdk;

class TicketTypeRequirement extends EWSObject {


  /**
   * @var string
   */
  private $id;

  /**
   * @var boolean
   */
  private $requireEmergencyContact;

  /**
   * @var boolean
   */
  private $requireFundraisingRestrictions;

  /**
   * @var boolean
   */
  private $requireMotivation;

  /**
   * @var boolean
   */
  private $requireFundraisingTarget;

  /**
   * @var boolean
   */
  private $requireMinimumFundraisingTarget;

  /**
   * @var integer
   */
  private $minimumFundraisingTarget;

  /**
   * @var string
   */
  private $fundraisingTargetSupportingCopy;

  /**
   * @var boolean
   */
  private $requireParentalConsent;

  /**
   * @var boolean
   */
  private $requireParentalConsentContact;

  /**
   * @var string
   */
  private $requireEventKit;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * TicketType constructor.
   */
  public function __construct(EWSClient $client, $data, TicketType $ticketType)
  {
    parent::__construct($client, $data);
  }

  /**
   * Get id
   *
   * @return string
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return boolean
   */
  public function getRequireEmergencyContact()
  {
    return $this->requireEmergencyContact;
  }

  /**
   * @param boolean $requireEmergencyContact
   */
  public function setRequireEmergencyContact($requireEmergencyContact)
  {
    $this->requireEmergencyContact = $requireEmergencyContact;
  }

  /**
   * @return boolean
   */
  public function getRequireFundraisingRestrictions()
  {
    return $this->requireFundraisingRestrictions;
  }

  /**
   * @param boolean $requireFundraisingRestrictions
   */
  public function setRequireFundraisingRestrictions($requireFundraisingRestrictions)
  {
    $this->requireFundraisingRestrictions = $requireFundraisingRestrictions;
  }

  /**
   * @return boolean
   */
  public function getRequireMotivation()
  {
    return $this->requireMotivation;
  }

  /**
   * @param boolean $requireMotivation
   */
  public function setRequireMotivation($requireMotivation)
  {
    $this->requireMotivation = $requireMotivation;
  }

  /**
   * @return boolean
   */
  public function getRequireFundraisingTarget() {
    return $this->requireFundraisingTarget;
  }

  /**
   * @param boolean $requireFundraisingTarget
   */
  public function setRequireFundraisingTarget($requireFundraisingTarget) {
    $this->requireFundraisingTarget = $requireFundraisingTarget;
  }

  /**
   * @return boolean
   */
  public function getRequireMinimumFundraisingTarget() {
    return $this->requireMinimumFundraisingTarget;
  }

  /**
   * @param boolean $requireMinimumFundraisingTarget
   */
  public function setRequireMinimumFundraisingTarget($requireMinimumFundraisingTarget) {
    $this->requireMinimumFundraisingTarget = $requireMinimumFundraisingTarget;
  }

  /**
   * @return int
   */
  public function getMinimumFundraisingTarget() {
    return $this->minimumFundraisingTarget;
  }

  /**
   * @param int $minimumFundraisingTarget
   */
  public function setMinimumFundraisingTarget($minimumFundraisingTarget) {
    $this->minimumFundraisingTarget = $minimumFundraisingTarget;
  }

  /**
   * @return string
   */
  public function getFundraisingTargetSupportingCopy() {
    return $this->fundraisingTargetSupportingCopy;
  }

  /**
   * @param string $fundraisingTargetSupportingCopy
   */
  public function setFundraisingTargetSupportingCopy($fundraisingTargetSupportingCopy) {
    $this->fundraisingTargetSupportingCopy = $fundraisingTargetSupportingCopy;
  }

  /**
   * @return boolean
   */
  public function getRequireParentalConsent() {
    return $this->requireParentalConsent;
  }

  /**
   * @param boolean $requireParentalConsent
   */
  public function setRequireParentalConsent($requireParentalConsent) {
    $this->requireParentalConsent = $requireParentalConsent;
  }

  /**
   * @return mixed
   */
  public function getRequireParentalConsentContact() {
    return $this->requireParentalConsentContact;
  }

  /**
   * @param mixed $requireParentalConsentContact
   */
  public function setRequireParentalConsentContact($requireParentalConsentContact) {
    $this->requireParentalConsentContact = $requireParentalConsentContact;
  }

  /**
   * @return string
   */
  public function getRequireEventKit() {
    return $this->requireEventKit;
  }

  /**
   * @param string $requireEventKit
   */
  public function setRequireEventKit($requireEventKit) {
    $this->requireEventKit = $requireEventKit;
  }

  /**
   * @return \DateTime
   */
  public function getCreated()
  {
    return $this->created;
  }

  /**
   * @param \DateTime $created
   * @return Requirement
   */
  public function setCreated($created)
  {
    $this->created = $created;

    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getUpdated()
  {
    return $this->updated;
  }

  /**
   * @param \DateTime $updated
   * @return TicketType
   */
  public function setUpdated($updated)
  {
    $this->updated = $updated;

    return $this;
  }

  /**
   * Simple function to return the URI for loading the ticket types.
   *
   * @return string
   */
  public function getUri() {
    throw new EWSClientError('Unable to update ticket type requirement directly');
  }

  public function setId($id) {
    $this->id = $id;
  }

  /**
   * Simple function to return the idKey of a class. This allows us to use
   * a common populate function across all objects/classes.
   */
  protected function getIdKey() {
    return 'id';
  }

  /**
   * Simple function to return the structure of the class. This defines how the
   * object should be built and delivered as an array.
   */
  protected function getArrayStructure() {
    return [
      'id',
      'requireEmergencyContact',
      'requireFundraisingRestrictions',
      'requireParentalConsent',
      'requireParentalConsentContact',
      'requireMotivation',
      'requireFundraisingTarget',
      'requireMinimumFundraisingTarget',
      'minimumFundraisingTarget',
      'fundraisingTargetSupportingCopy',
      'requireEventKit'
    ];
  }

  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    throw new EWSClientError('Unable to update ticket type directly');
  }
}
