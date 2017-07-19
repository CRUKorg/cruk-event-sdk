<?php
/**
 * Created by PhpStorm.
 * User: said
 * Date: 15/02/2017
 * Time: 10:43
 */

namespace Cruk\EventSdk;


class TicketPrice extends EWSObject {
  protected $price;
  protected $discount;
  protected $ticketId;
  protected $ticketTypeId;
  protected $coupon;


  /**
   * @return mixed
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * @param mixed $price
   * @return TicketPrice
   */
  public function setPrice($price) {
    $this->price = $price;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getDiscount() {
    return $this->discount;
  }

  /**
   * @param mixed $discount
   * @return TicketPrice
   */
  public function setDiscount($discount) {
    $this->discount = $discount;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getTicketId() {
    return $this->ticketId;
  }

  /**
   * @param mixed $ticketId
   * @return TicketPrice
   */
  public function setTicketId($ticketId) {
    $this->ticketId = $ticketId;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getTicketTypeId() {
    return $this->ticketTypeId;
  }

  /**
   * @param mixed $ticketTypeId
   * @return TicketPrice
   */
  public function setTicketTypeId($ticketTypeId) {
    $this->ticketTypeId = $ticketTypeId;
    return $this;
  }

  /**
   * @return Coupon
   */
  public function getCoupon() {
    return $this->coupon;
  }

  /**
   * @param mixed $coupon
   * @return TicketPrice
   */
  public function setCoupon($coupon) {
    if ($coupon) {
      $this->coupon = new Coupon($this->getMicroserviceClient(), $coupon);
    }
    return $this;
  }

  /**
   * Simple function to return the idKey of a class. This allows us to use
   * a common populate function across all objects/classes.
   *
   * @codeCoverageIgnore
   *
   * @return string
   */
  protected function getIdKey()
  {
    // We do not actually need this for this particular class, although it's staying as it's required, and it's also
    // possible that the EWS could be altered to allow this (creating a single address for multiple participants).
    throw new EWSClientError('Unable to update pricing directly');
  }

  /**
   * Simple function to return the URI that should be used to GET this object
   * from the EWS.
   *
   * @codeCoverageIgnore
   *
   * @return string
   */
  protected function getUri()
  {
    // Same issue as getIdKey().
    throw new EWSClientError('Unable to update pricing directly');
  }

  /**
   * Simple function to return the URI that should be used to POST/UPDATE this object
   * from the EWS.
   *
   * @codeCoverageIgnore
   *
   * @return string
   */
  protected function getCreateUri()
  {
    // Same issue as getIdKey().
    throw new EWSClientError('Unable to update pricing directly');
  }

  /**
   * Simple function to return the structure of the class. This defines how the
   * object should be built and delivered as an array.
   *
   * @return array
   */
  protected function getArrayStructure() {
    return [
      'price',
      'discount',
      'ticketId',
      'ticketTypeId',
      'coupon',
    ];
  }

  /**
   * Simple helper function to set a value from a key and value
   *
   * @param string $key
   * @param mixed $value
   * @return EWSObject
   */
  public function setValueFromKey($key, $value)
  {
    $setter = 'set' . ucfirst($key);
    if (method_exists($this, $setter)) {
      return $this->$setter($value);
    }
    return false;
  }
}
