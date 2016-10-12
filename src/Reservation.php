<?php

namespace Cruk\EventSdk;

class Reservation extends EWSObject {


  const UUID_PREFIX = 'res';

  /**
   * @var string
   */
  private $id;

  /**
   * @var Registration
   * @Assert\NotNull
   */
  private $registration;

  /**
   * @var ReservationStatus
   */
  private $reservationStatus;

  /**
   * @var \DateTime
   */
  private $timeoutDateTime;

  /**
   * @var SalesChannel
   */
  private $salesChannel;

  /**
   * @var Ticket[]
   */
  private $tickets;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * Inital Setup
   */
  public function __construct(EWSClient $client, $data, Registration $registration) {
    $this->registration = $registration;
    parent::__construct($client, $data);
  }you

  public function setId($id) {
    $this->id = $id;
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
   * Set timeoutDateTime
   *
   * @param \DateTime $timeoutDateTime
   * @return Reservation
   */
  public function setTimeoutDateTime($timeoutDateTime)
  {
    $this->timeoutDateTime = $timeoutDateTime;

    return $this;
  }

  /**
   * Get timeoutDateTime
   *
   * @return \DateTime
   */
  public function getTimeoutDateTime()
  {
    return $this->timeoutDateTime;
  }

  /**
   * Set channel
   *
   * @param $salesChannel
   *
   * @return Reservation
   */
  public function setSalesChannel($salesChannel = null)
  {
    $this->salesChannel = $salesChannel;

    return $this;
  }

  /**
   * Get channel
   *
   * @return SalesChannel
   */
  public function getSalesChannel()
  {
    return $this->salesChannel;
  }


  /**
   * Set created
   *
   * @param \DateTime $created
   * @return Reservation
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
   * @return Reservation
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
   * Set reservationStatus
   *
   * @param ReservationStatus|null $reservationStatus
   * @return Reservation
   */
  public function setReservationStatus($reservationStatus = null)
  {
    $this->reservationStatus = $reservationStatus;

    return $this;
  }

  /**
   * Get reservationStatus
   *
   * @return ReservationStatus
   */
  public function getReservationStatus()
  {
    return $this->reservationStatus;
  }

  /**
   * @return Ticket[]
   */
  public function getTickets()
  {
    return $this->tickets;
  }

  /**
   * Simple function to return the URI for loading the Event.
   *
   * @return string
   */
  public function getUri() {
    return $this->client->getPath() . "/reservations/{$this->id}";
  }


  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    // Should possibly throw an error here, as this does not exist.
    return $this->client->getPath() . "/registrations/{$this->registration->getId()}/reservations";
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
      ''
    ];
  }

}
