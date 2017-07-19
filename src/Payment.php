<?php

namespace Cruk\EventSdk;

use Cruk\MicroserviceBundle\Service\MicroserviceClient;

/**
 * Class Payment
 * @package Cruk\EventSdk
 */
class Payment extends EWSObject {

  /**
   * @var string
   */
  private $id;

  /**
   * @var Reservation|NULL
   */
  private $reservation;

  /**
   * @var string
   */
  private $dotsId;

  /**
   * @var string
   */
  private $paymentId;

  /**
   * @var integer
   */
  private $paymentMethodId;

  /**
   * @var float
   */
  private $amount;

  /**
   * @var string
   */
  private $dataSource;

  /**
   * @var \DateTime
   */
  private $dateReceived;

  /**
   * @var string
   */
  private $paymentType;

  /**
   * @var string
   */
  private $paymentMethod;

  /**
   * @var string
   */
  private $paymentStatus;

  /**
   * @var boolean
   */
  private $personalGiftAid;

  /**
   * @var boolean
   */
  private $toBeGiftAided;

  /**
   * @var string
   */
  private $transactionId;

  /**
   * Payment constructor.
   *
   * @param MicroserviceClient $microserviceClient
   * @param mixed              $data
   * @param Reservation|NULL   $reservation
   */
  public function __construct(MicroserviceClient $microserviceClient, $data, Reservation $reservation = NULL) {
    $this->reservation = $reservation;
    parent::__construct($microserviceClient, $data);
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
   * @return string
   */
  public function getDotsId() {
    return $this->dotsId;
  }

  /**
   * @param string $dotsId
   */
  public function setDotsId($dotsId) {
    $this->dotsId = $dotsId;
  }

  /**
   * @return string
   */
  public function getPaymentId() {
    return $this->paymentId;
  }

  /**
   * @param string $paymentId
   */
  public function setPaymentId($paymentId) {
    $this->paymentId = $paymentId;
  }

  /**
   * @return int
   */
  public function getPaymentMethodId() {
    return $this->paymentMethodId;
  }

  /**
   * @param int $paymentMethodId
   */
  public function setPaymentMethodId($paymentMethodId) {
    $this->paymentMethodId = $paymentMethodId;
  }

  /**
   * @return float
   */
  public function getAmount() {
    return $this->amount;
  }

  /**
   * @param float $amount
   */
  public function setAmount($amount) {
    $this->amount = $amount;
  }

  /**
   * @return string
   */
  public function getDataSource() {
    return $this->dataSource;
  }

  /**
   * @param string $dataSource
   */
  public function setDataSource($dataSource) {
    $this->dataSource = $dataSource;
  }

  /**
   * @return \DateTime
   */
  public function getDateReceived() {
    return $this->dateReceived;
  }

  /**
   * @param \DateTime $dateReceived
   */
  public function setDateReceived($dateReceived) {
    $this->dateReceived = $dateReceived;
  }

  /**
   * @return string
   */
  public function getPaymentType() {
    return $this->paymentType;
  }

  /**
   * @param string $paymentType
   */
  public function setPaymentType($paymentType) {
    $this->paymentType = $paymentType;
  }

  /**
   * @return string
   */
  public function getPaymentMethod() {
    return $this->paymentMethod;
  }

  /**
   * @param string $paymentMethod
   */
  public function setPaymentMethod($paymentMethod) {
    $this->paymentMethod = $paymentMethod;
  }

  /**
   * @return string
   */
  public function getPaymentStatus() {
    return $this->paymentStatus;
  }

  /**
   * @param string $paymentStatus
   */
  public function setPaymentStatus($paymentStatus) {
    $this->paymentStatus = $paymentStatus;
  }

  /**
   * @return boolean
   */
  public function getPersonalGiftAid() {
    return $this->personalGiftAid;
  }

  /**
   * @param boolean $personalGiftAid
   */
  public function setPersonalGiftAid($personalGiftAid) {
    $this->personalGiftAid = $personalGiftAid;
  }

  /**
   * @return boolean
   */
  public function getToBeGiftAided() {
    return $this->toBeGiftAided;
  }

  /**
   * @param boolean $toBeGiftAided
   */
  public function setToBeGiftAided($toBeGiftAided) {
    $this->toBeGiftAided = $toBeGiftAided;
  }

  /**
   * @return string
   */
  public function getTransactionId() {
    return $this->transactionId;
  }

  /**
   * @param string $transactionId
   */
  public function setTransactionId($transactionId) {
    $this->transactionId = $transactionId;
  }

  /**
   * Simple function to return the URI for loading the Payment.
   *
   * @return string
   */
  public function getUri() {
    return "/payments/{$this->getId()}";
  }

  /**
   * Simple function to return the URI for creating the Payment.
   *
   * @return string
   */
  public function getCreateUri() {
    return "/reservations/{$this->reservation->getId()}/payments";
  }

  /**
   * Simple function to return the URI that should be used to search for objects
   * from the EWS.
   * @return string
   * @throws EWSClientError
   */
  protected function getSearchUri() {
    throw new EWSClientError('Unable to search for Payments');
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
      "id",
      "dotsId",
      "paymentId",
      "paymentMethodId",
      "amount",
      "dataSource",
      "dateReceived",
      "paymentType",
      "paymentMethod",
      "paymentStatus",
      "personalGiftAid",
      "toBeGiftAided",
      "transactionId",
    ];
  }
}
