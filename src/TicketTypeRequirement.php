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
