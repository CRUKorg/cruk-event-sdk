<?php

namespace Cruk\EventSdk;

class SubProposition extends EWSObject {

  /**
   * @var string
   */
  private $id;

  /**
   * @var Proposition
   */
  private $proposition;

  /**
   * @var string The Sub-Proposition name
   */
  private $name;

  /**
   * @var Status
   */
  private $status;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * @var \DateTime|null Deleted timestamp
   */
  private $deleted;

  public function __construct(EWSClient $client, $data, Proposition $proposition = NULL) {
    parent::__construct($client, $data);
  }

  /**
   * Get id
   *
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   *
   * @return SubProposition
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * @return Proposition
   */
  public function getProposition()
  {
    return $this->proposition;
  }

  /**
   * @param $proposition
   * @return SubProposition
   */
  public function setProposition($proposition)
  {
    $this->proposition = $proposition;

    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return Status
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * @param Status|null $status
   * @return SubProposition
   */
  public function setStatus($status = null)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   * @return SubProposition
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
   * @return SubProposition
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
   * @return \DateTime|null
   */
  public function getDeleted()
  {
    return $this->deleted;
  }

  /**
   * @param \DateTime|null $deleted
   * @return SubProposition
   */
  public function setDeleted($deleted = null)
  {
    $this->deleted = $deleted;

    return $this;
  }

  /**
   * Simple function to return the URI for loading the Event.
   *
   * @return string
   */
  public function getUri() {
    return $this->client->getPath() . "/sub-propositions/{$this->id}";
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
    return $this->client->getPath() . "/propositions/{$this->proposition}/sub-propositions";
  }

  /**
   * Simple function to return the URI that should be used to search for objects
   * from the EWS.
   *
   * @return string
   */
  protected function getSearchUri() {
    return $this->client->getPath() . "/propositions/{$this->proposition}/sub-propositions";
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
      'name',
      'status',
    ];
  }

  /**
   * Simple function to return an array of sub propositions based on search criteria.
   *
   * @param EWSClient $client
   *   Client.
   * @param array $query
   *   Query array for building the query string.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   *
   * @throws EWSClientError
   */
  public static function search($client, $query, $class = '\Cruk\EventSdk\SubProposition', $path = '/propositions/{$this->propositionId}/sub-propositions') {
    return parent::search($client, $query, $class, $path);
  }

  /**
   * Simple function to return an array of sub propositions based on search criterias.
   *
   * @param EWSClient $client
   *   Client.
   * @param array $queries
   *   Array of query arrays for building the query string.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   *
   * @throws EWSClientError
   */
  public static function searches($client, $queries, $class = '\Cruk\EventSdk\SubProposition', $path = '/propositions/{$this->propositionId}/sub-propositions') {
    return parent::searches($client, $queries, $class, $path);
  }
}
