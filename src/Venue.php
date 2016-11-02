<?php

namespace Cruk\EventSdk;

class Venue extends EWSObject {

  /**
   * @var string
   */
  private $id;

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $line1;

  /**
   * @var string
   */
  private $line2;

  /**
   * @var string
   */
  private $line3;

  /**
   * @var string
   */
  private $city;

  /**
   * @var string
   */
  private $postalCode;

  /**
   * @var string
   */
  private $country;

  /**
   * @var string
   */
  private $latitude;

  /**
   * @var string
   */
  private $longitude;

  /**
   * @var string
   */
  private $status;

  /**
   * {@inheritdoc}
   */
  public function getUri() {
    return $this->client->getPath() . "/venues/{$this->id}";
  }

  /**
   * {@inheritdoc}
   */
  public function getCreateUri() {
    return $this->client->getPath() . "/venues";
  }

  /**
   * {@inheritdoc}
   */
  protected function getSearchUri() {
    return $this->client->getPath() . "/venues";
  }

  /**
   * {@inheritdoc}
   */
  protected function getIdKey() {
    return 'id';
  }

  /**
   * {@inheritdoc}
   */
  protected function getArrayStructure() {
    return [
      'id',
      'name',
      'line1',
      'line2',
      'line3',
      'city',
      'postalCode',
      'country',
      'latitude',
      'longitude',
      'status',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function search($client, $query, $class = __CLASS__, $path = '/venues') {
    return parent::search($client, $query, $class, $path);
  }

  /**
   * {@inheritdoc}
   */
  public static function searchPaginated($client, $query, $pageSize, $class = __CLASS__, $path = '/venues') {
    return parent::searchPaginated($client, $query, $pageSize, $class, $path);
  }

  /**
   * {@inheritdoc}
   */
  public static function searches($client, $queries, $class = __CLASS__, $path = '/venues') {
    return parent::searches($client, $queries, $class, $path);
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getLine1() {
    return $this->line1;
  }

  public function setLine1($line1) {
    $this->line1 = $line1;
  }

  public function getLine2() {
    return $this->line2;
  }

  public function setLine2($line2) {
    $this->line2 = $line2;
  }

  public function getLine3() {
    return $this->line3;
  }

  public function setLine3($line3) {
    $this->line3 = $line3;
  }

  public function getCity() {
    return $this->city;
  }

  public function setCity($city) {
    $this->city = $city;
  }

  public function getPostalCode() {
    return $this->postalCode;
  }

  public function setPostalCode($postalCode) {
    $this->postalCode = $postalCode;
  }

  public function getCountry() {
    return $this->country;
  }

  public function setCountry($country) {
    $this->country = $country;
  }

  public function getLatitude() {
    return $this->latitude;
  }

  public function setLatitude($latitude) {
    $this->latitude = $latitude;
  }

  public function getLongitude() {
    return $this->longitude;
  }

  public function setLongitude($longitude) {
    $this->longitude = $longitude;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
  }
}
