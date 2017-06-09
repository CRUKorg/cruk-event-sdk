<?php
/**
 * Created by PhpStorm.
 * User: said
 * Date: 15/02/2017
 * Time: 09:52
 */

namespace Cruk\EventSdk;


class Coupon extends EWSObject {
  protected $code;
  protected $discountName;
  protected $corporate;
  protected $companyName;

  /**
   * @return mixed
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * @param mixed $code
   */
  public function setCode($code) {
    $this->code = $code;
  }

  /**
   * @return mixed
   */
  public function getDiscountName() {
    return $this->discountName;
  }

  /**
   * @param mixed $discountName
   */
  public function setDiscountName($discountName) {
    $this->discountName = $discountName;
  }

  /**
   * @return mixed
   */
  public function getCorporate() {
    return $this->corporate;
  }

  /**
   * @return mixed
   */
  public function isCorporate() {
    return (boolean) $this->corporate;
  }

  /**
   * @param mixed $corporate
   */
  public function setCorporate($corporate) {
    $this->corporate = $corporate;
  }

  /**
   * @return mixed
   */
  public function getCompanyName() {
    return $this->companyName;
  }

  /**
   * @param mixed $companyName
   */
  public function setCompanyName($companyName) {
    $this->companyName = $companyName;
  }


  /**
   * Simple function to return the idKey of a class. This allows us to use
   * a common populate function across all objects/classes.
   *
   * @codeCoverageIgnore
   *
   * @return string
   */
  protected function getIdKey() {
    return 'code';
  }

  /**
   * Simple function to return the URI that should be used to GET this object
   * from the EWS.
   *
   * @codeCoverageIgnore
   *
   * @return string
   */
  protected function getUri() {
    return $this->client->getPath() . "/pricing/coupons/{$this->code}";
  }

  /**
   * Simple function to return the URI that should be used to POST/UPDATE this object
   * from the EWS.
   *
   * @codeCoverageIgnore
   *
   * @return string
   */
  protected function getCreateUri() {
    throw new EWSClientError('Unable to update Address directly');
  }

  /**
   * Simple function to return the structure of the class. This defines how the
   * object should be built and delivered as an array.
   *
   * @return array
   */
  protected function getArrayStructure() {
    return [
      'code',
      'discountName',
      'corporate',
      'companyName',
    ];
  }
}