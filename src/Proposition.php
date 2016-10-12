<?php

namespace Cruk\EventSdk;

class Proposition extends EWSObject {

  /**
   * @var int Proposition ID
   */
  private $id;

  /**
   * @var string The Proposition name
   */
  private $name;

  /**
   * @var Collection|SubProposition[]
   */
  private $subPropositions;

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

  public function __construct()
  {
    $this->subPropositions = new array();
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
   * @return Proposition
   */
  public function setName($name)
  {
    $this->name = $name;

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
   * @return \Cruk\EventSdk\SubProposition
   */
  public function getSubPropositions()
  {
    return $this->subPropositions;
  }

  /**
   * @param \Cruk\EventSdk\SubProposition
   * @return Proposition
   */
  public function setSubPropositions($subPropositions)
  {
    $this->subPropositions = array();
    foreach ($subPropositions as $subProposition) {
      $this->SubPropositions[] = $subProposition;
    }

    return $this;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function setStatus($status = null)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   * @return Proposition
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
   * @return Proposition
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
   * Simple function to return the URI for loading the Event.
   *
   * @return string
   */
  public function getUri() {
    return $this->client->getPath() . "/propositions/{$this->id}";
  }

  public function setId($id) {
    $this->id = $id;
  }

  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri($propositionId) {
    // Should possibly throw an error here, as this does not exist.
    return $this->client->getPath() . "/propositions/{$propositionId}";
  }

  /**
   * Simple function to return the URI that should be used to search for objects
   * from the EWS.
   *
   * @return string
   */
  protected function getSearchUri() {
    // Should possibly throw an error here, as this does not exist.
    return $this->client->getPath() . "/propositions";
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
      'subPropositions',
    ];
  }

  /**
   * Simple function to return an array of propositions based on search criteria.
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
  public static function search($client, $query, $class = '\Cruk\EventSdk\Proposition', $path = '/propositions') {
    return parent::search($client, $query, $class, $path);
  }

  /**
   * Simple function to return an array of propositions based on search criterias.
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
  public static function searches($client, $queries, $class = '\Cruk\EventSdk\Proposition', $path = '/propositions') {
    return parent::searches($client, $queries, $class, $path);
  }
}
