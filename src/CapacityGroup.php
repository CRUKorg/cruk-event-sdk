<?php

namespace Cruk\EventSdk;

use Cruk\MicroserviceBundle\Service\MicroserviceClient;
use Doctrine\Common\Collections\ArrayCollection;

class CapacityGroup extends EWSObject {

  /**
   * @var string
   */
  private $id;

  /**
   * @var integer Total capacity of this ticket
   */
  private $capacity;

  /**
   * @var TicketType[]
   */
  private $ticketTypes;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * CapacityGroup constructor.
   *
   * @param MicroserviceClient $microserviceClient
   * @param mixed $data
   */
  public function __construct(MicroserviceClient $microserviceClient, $data)
  {
    $this->ticketTypes = array();
    parent::__construct($microserviceClient, $data);
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
   * Set capacity
   *
   * @param integer $capacity
   *
   * @return CapacityGroup
   */
  public function setCapacity($capacity)
  {
    $this->capacity = $capacity;

    return $this;
  }

  /**
   * Get capacity
   *
   * @return int
   */
  public function getCapacity()
  {
    return $this->capacity;
  }

  /**
   * @return TicketType[]|ArrayCollection
   */
  public function getTicketTypes()
  {
    return $this->ticketTypes;
  }

  /**
   * @param TicketType[]|ArrayCollection $ticketTypes
   * @return CapacityGroup
   */
  public function setTicketTypes($ticketTypes)
  {
    $this->ticketTypes = array();
    foreach ($ticketTypes as $ticketType) {
      if (is_array($ticketType)) {
        $this->ticketTypes[] = new TicketType($this->getMicroserviceClient(), $ticketType);
      }
      elseif (is_object($ticketType)) {
        $this->ticketTypes[] = $ticketType;
      }
    }

    return $this;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   *
   * @return CapacityGroup
   */
  public function setCreated(\DateTime $created)
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
   *
   * @return CapacityGroup
   */
  public function setUpdated(\DateTime $updated)
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
    return "/capacity-groups/{$this->id}";
  }

  public function setId($id) {
    $this->id = $id;
  }

  /**
   * Simple function to return the URI that should be used to search for objects
   * from the EWS.
   *
   * @return string
   */
  protected function getSearchUri($waveId) {
    // Should possibly throw an error here, as this does not exist.
    return "/waves/{$waveId}/capacity-groups";
  }

  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    // Should possibly throw an error here, as this does not exist.
    return "/waves/{$waveId}/capacity-groups";
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
      'capacity',
      'ticketTypes',
      'created',
      'updated',
    ];
  }
}
