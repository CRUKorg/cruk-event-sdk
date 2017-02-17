<?php
/**
 * Created by PhpStorm.
 * User: said
 * Date: 14/02/2017
 * Time: 16:23
 */

namespace Cruk\EventSdk;


class PricingConstraint {
  protected $data = [];

  public function __construct() {
    $this->data = array(
      'tickets' => [],
    );
  }

  /**
   * Add ticket type.
   * @param $ticketTypeId
   * @param $quantity
   * @throws \Exception
   */
  public function addTicket($ticketTypeId, $quantity) {
    if (!is_int($quantity) || $quantity <= 0) {
      throw new \Exception("Quantity must be an integer and greater than 0");
    }
    $this->data['tickets'][] = array(
      'ticketTypeId' => $ticketTypeId,
      'quantity' => $quantity,
    );
  }

  /**
   * Add coupon code.
   * @param $couponCode
   * @param $ticketTypeId
   * @param $quantity
   * @throws \Exception
   */
  public function addCouponCode($couponCode, $ticketTypeId = NULL, $quantity = NULL) {
    $coupon = array('couponCode' => $couponCode);
    if (!empty($ticketTypeId)) {
      $coupon['ticketTypeId'] = $ticketTypeId;
    }
    if (!empty($quantity)) {
      $coupon['quantity'] = $quantity;
    }
    $this->data['coupons'][$couponCode]= $coupon;
    return $couponCode;
  }

  public function getCoupons() {
    return empty($this->data['coupons']) ? [] : $this->data['coupons'];
  }

  /**
   * Get constraint as an array.
   * @return array
   */
  public function asArray() {
    $data = $this->data;
    if (!empty($data['coupons'])) {
      $data['coupons'] = array_values($data['coupons']);
    }
    return $this->data;
  }
}