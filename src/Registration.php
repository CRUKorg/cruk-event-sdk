<?php

namespace Cruk\EventSdk;

class Registration extends EWSObject {

  /**
   * @var string
   */
  private $id;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * @var RegistrationStatus
   */
  private $registrationStatus;

  /**
   * @var Reservation[]
   */
  private $reservations;

  /**
   * Registration constructor.
   * @param EWSClient $client
   * @param mixed $data
   * @param Event $event
   */
  public function __construct(EWSClient $client, $data, Event $event)
  {
    $this->event = $event;
    $this->reservations = array();
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
   * Set created
   *
   * @param \DateTime $created
   * @return Registration
   */
  public function setCreated($created)
  {
    $this->created = $created;

    return $this;
  }

  /**
   * Get created
   *
   * @return \DateTime
   */
  public function getCreated()
  {
    return $this->created;
  }

  /**
   * Set updated
   *
   * @param \DateTime $updated
   * @return Registration
   */
  public function setUpdated($updated)
  {
    $this->updated = $updated;

    return $this;
  }

  /**
   * Get updated
   *
   * @return \DateTime
   */
  public function getUpdated()
  {
    return $this->updated;
  }

  /**
   * Set registrationStatus
   *
   * @param RegistrationStatus|null $registrationStatus
   * @return Registration
   */
  public function setRegistrationStatus($registrationStatus = null)
  {
    $this->registrationStatus = $registrationStatus;

    return $this;
  }

  /**
   * Get registrationStatus
   *
   * @return RegistrationStatus
   */
  public function getRegistrationStatus()
  {
    return $this->registrationStatus;
  }

  /**
   * Get reservation
   *
   * @return ArrayCollection|Reservation[]
   */
  public function getReservations()
  {
    return $this->reservations;
  }

  /**
   * @param string $donation
   */
  public function setReservation($donation)
  {
    // TODO:
  }

  /**
   * Simple function to return the URI for loading the Registration.
   *
   * @return string
   */
  public function getUri() {
    return $this->client->getPath() . "/registrations/{$this->id}";
  }

  public function setId($id) {
    $this->id = $id;
  }

  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    // Should possibly throw an error here, as this does not exist.
    return $this->client->getPath() . "/registrations";
  }

  /**
   * Simple function to return the URI that should be used to search for objects
   * from the EWS.
   *
   * @return string
   */
  protected function getSearchUri() {
    throw new EWSClientError('Unable to update Registration directly');
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
      'created',
      'updated',
      'registrationStatus',
      'reservations',
    ];
  }

  public function createReservation($data)
  {
    $reservation = new Reservation($this->client, $data, $this->event, $this);
    $reservation->create();
    $this->setReservation($reservation);
    return $reservation;
  }
}
