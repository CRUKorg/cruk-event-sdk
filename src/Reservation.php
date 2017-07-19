<?php

namespace Cruk\EventSdk;

use Cruk\MicroserviceBundle\Entity\MicroserviceClient\Data;
use Cruk\MicroserviceBundle\Service\MicroserviceClient;

/**
 * Class Reservation
 * @package Cruk\EventSdk
 */
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
   * @var array
   */
  private $coupons;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * @var
   */
  private $payment;

  /**
   * Initial Setup
   */
  public function __construct(MicroserviceClient $microserviceClient, $data, Registration $registration) {
    $this->registration = $registration;
    parent::__construct($microserviceClient, $data);
  }

  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getPayment() {
    return $this->payment;
  }

  /**
   * @param mixed $payment
   */
  public function setPayment($payment) {
    $this->payment = $payment;
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
   * Set timeoutDateTime
   *
   * @param \DateTime $timeoutDateTime
   * @return Reservation
   */
  public function setTimeoutDateTime($timeoutDateTime) {
    $this->timeoutDateTime = $timeoutDateTime;

    return $this;
  }

  /**
   * Get timeoutDateTime
   *
   * @return \DateTime
   */
  public function getTimeoutDateTime() {
    return $this->timeoutDateTime;
  }

  /**
   * Set channel
   *
   * @param $salesChannel
   *
   * @return Reservation
   */
  public function setSalesChannel($salesChannel = NULL) {
    $this->salesChannel = $salesChannel;

    return $this;
  }

  /**
   * Get channel
   *
   * @return SalesChannel
   */
  public function getSalesChannel() {
    return $this->salesChannel;
  }


  /**
   * Set created
   *
   * @param \DateTime $created
   * @return Reservation
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
   * @return Reservation
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
   * Set reservationStatus
   *
   * @param ReservationStatus|null $reservationStatus
   * @return Reservation
   */
  public function setReservationStatus($reservationStatus = NULL) {
    $this->reservationStatus = $reservationStatus;

    return $this;
  }

  /**
   * Get reservationStatus
   *
   * @return ReservationStatus
   */
  public function getReservationStatus() {
    return $this->reservationStatus;
  }

  /**
   * @return Ticket[]
   */
  public function getTickets() {
    return $this->tickets;
  }

  /**
   * @return array
   */
  public function getCoupons() {
    return $this->coupons;
  }

  /**
   * @param array $coupons
   */
  public function setCoupons($coupons) {
    $this->coupons = $coupons;
  }

  /**
   * Set tickets
   *
   * @param ReservationStatus|null $reservationStatus
   * @return Reservation
   */
  public function setTickets($tickets) {
    $this->tickets = $tickets;

    return $this;
  }

  /**
   * Simple function to return the URI for loading the Event.
   *
   * @return string
   */
  public function getUri() {
    return "/reservations/{$this->id}";
  }


  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    // Should possibly throw an error here, as this does not exist.
    return "/registrations/{$this->registration->getId()}/reservations?salesChannel={$this->salesChannel}";
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
      'status',
      'timeoutDateTime',
      'salesChannel',
      'tickets',
      'coupons',
      'payment'
    ];
  }

  /**
   * Post participant / person data to the tickets
   * @param $ticket_id
   * @param $data
   * @return mixed
   */
  public function addParticipant($ticket_id, $data) {
    // @TODO: Move this call into a Ticket entity
    $authenticationCredentials = $this->getMicroserviceClient()->getCredentials();
    return $this->getMicroserviceClient()->call(
      "/tickets/{$ticket_id}/participants",
      'POST',
      $authenticationCredentials,
      new Data($data)
    );
  }

  /**
   * @param $data
   *
   * @return mixed
   */
  public function createPayment($data) {
    $payment = new Payment($this->getMicroserviceClient(), $data, $this);
    $this->payment = $payment;
    $payment->create();
    return $payment;
  }

  /**
   * @return string
   */
  public function completeReservation() {
    $authenticationCredentials = $this->getMicroserviceClient()->getCredentials();
    return $this->getMicroserviceClient()->call(
      "/reservations/{$this->getId()}/complete",
      'POST',
      $authenticationCredentials
    );
  }
}
