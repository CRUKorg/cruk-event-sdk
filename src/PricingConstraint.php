<?php
/**
 * Created by PhpStorm.
 * User: said
 * Date: 14/02/2017
 * Time: 16:23
 */

namespace Cruk\EventSdk;


class PricingConstraint extends EWSObject {
  protected $tickets = [];
  protected $coupons = [];

  /**
   * @return array
   */
  public function getTickets() {
    return $this->tickets;
  }

  /**
   * @param array $tickets
   * @return PricingConstraint
   */
  public function setTickets($tickets) {
    $this->tickets = $tickets;
    return $this;
  }

  /**
   * @return array
   */
  public function getCoupons() {
    return $this->coupons;
  }

  /**
   * @param array $coupons
   * @return PricingConstraint
   */
  public function setCoupons($coupons) {
    $this->coupons = $coupons;
    return $this;
  }

  /**
   * Add ticket type.
   * @param $ticketTypeId
   * @param $quantity
   * @throws \Exception
   */
  public function addTicket($ticketTypeId, $quantity) {
    if (is_int($quantity) && $quantity > 0) {
      $this->tickets[$ticketTypeId] = array(
        'ticketTypeId' => $ticketTypeId,
        'quantity' => $quantity,
      );
    }
  }

  /**
   * Add coupon code.
   * @param $couponCode
   * @param $ticketTypeId
   * @param $quantity
   * @throws \Exception
   */
  public function addCoupon($couponCode, $ticketTypeId = NULL, $quantity = NULL) {
    $coupon = array('couponCode' => $couponCode);
    if (!empty($ticketTypeId)) {
      $coupon['ticketTypeId'] = $ticketTypeId;
    }
    if (!empty($quantity)) {
      $coupon['quantity'] = $quantity;
    }
    $this->coupons[]= $coupon;
  }

  /**
   * Remove coupon from constraint.
   * @param $couponCode
   * @return bool
   */
  public function removeCoupon($couponCode) {
    foreach ($this->coupons as $index => $coupon) {
      if ($coupon['couponCode'] == $couponCode) {
        unset($this->coupons[$index]);
      }
    }
  }

  /**
   * Check whether coupon code is in the constraint.
   * @param $couponCode
   * @return bool
   */
  public function couponExists($couponCode) {
    foreach ($this->coupons as $index => $coupon) {
      if ($coupon['couponCode'] == $couponCode) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Get constraint in format usuable for a request.
   * @return array
   */
  public function asRequest() {
    $data = [];
    if (!empty($this->coupons)) {
      $data['coupons'] = $this->coupons;
    }
    if (!empty($this->tickets)) {
      $data['tickets'] = array_values($this->tickets);
    }
    return $data;
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
  protected function getArrayStructure()
  {
    return [
      'coupons',
      'tickets',
    ];
  }
}