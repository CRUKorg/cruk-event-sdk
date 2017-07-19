<?php

namespace Cruk\EventSdk;

use Cruk\MicroserviceBundle\Service\MicroserviceClient;
use Doctrine\Common\Collections\ArrayCollection;

class TicketTypeConstraint extends EWSObject {

  private $id;

  /**
   * @var \DateTime
   */
  private $registrationOpenDate;

  /**
   * @var \DateTime
   */
  private $registrationCloseDate;

  /**
   * @var integer
   */
  private $maximumTickets;

  /**
   * @var integer
   */
  private $minimumTickets;

  /**
   * @var array
   */
  private $salesChannels;

  /**
   * @var TicketType[]|array Define if this ticket type must be purchased with another one in the same wave
   */
  private $requiresTicketTypes;

  /**
   * @var \DateTime Created timestamp
   */
  private $created;

  /**
   * @var \DateTime Updated timestamp
   */
  private $updated;

  /**
   * TicketType constructor.
   */
  public function __construct(MicroserviceClient $microserviceClient, $data, TicketType $ticketType)
  {
    $this->requiresTicketTypes = array();
    $this->salesChannels = array();
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
   * @return array
   */
  public function getSalesChannels()
  {
    return $this->salesChannels;
  }

  /**
   * @param $salesChannels
   * @return TicketTypeConstraint
   */
  public function setSalesChannels($salesChannels = [])
  {
    $this->salesChannels = $salesChannels;

    return $this;
  }

  /**
   * @return TicketType[]|ArrayCollection
   */
  public function getRequiresTicketTypes()
  {
    return $this->requiresTicketTypes;
  }

  /**
   * @param TicketType[]|ArrayCollection $requiresTicketTypes
   * @return TicketTypeConstraint
   */
  public function setRequiresTicketTypes($requiresTicketTypes = [])
  {
    $this->requiresTicketTypes = $requiresTicketTypes;
    return $this;
  }

  /**
   * @return int
   */
  public function getMaximumTickets()
  {
    return $this->maximumTickets;
  }

  /**
   * @param int $maximumTickets
   */
  public function setMaximumTickets($maximumTickets)
  {
    $this->maximumTickets = $maximumTickets;
  }

  /**
   * @return int
   */
  public function getMinimumTickets()
  {
    return $this->minimumTickets;
  }

  /**
   * @param int $minimumTickets
   */
  public function setMinimumTickets($minimumTickets)
  {
    $this->minimumTickets = $minimumTickets;
  }

  /**
   * Set registrationOpenDate
   *
   * @param \DateTime|null $registrationOpenDate
   * @return TicketTypeConstraint
   */
  public function setRegistrationOpenDate($registrationOpenDate = null)
  {
    $this->registrationOpenDate = $registrationOpenDate;

    return $this;
  }

  /**
   * Get registrationOpenDate
   *
   * @return \DateTime
   */
  public function getRegistrationOpenDate()
  {
    return $this->registrationOpenDate;
  }

  /**
   * Set registrationCloseDate
   *
   * @param \DateTime|null $registrationCloseDate
   * @return TicketTypeConstraint
   */
  public function setRegistrationCloseDate($registrationCloseDate = null)
  {
    $this->registrationCloseDate = $registrationCloseDate;

    return $this;
  }

  /**
   * Get registrationCloseDate
   *
   * @return \DateTime
   */
  public function getRegistrationCloseDate()
  {
    return $this->registrationCloseDate;
  }

  /**
   * @return \DateTime
   */
  public function getCreated()
  {
    return $this->created;
  }

  /**
   * @param \DateTime $created
   * @return TicketTypeConstraint
   */
  public function setCreated($created)
  {
    $this->created = $created;

    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getUpdated()
  {
    return $this->updated;
  }

  /**
   * @param \DateTime $updated
   * @return TicketTypeConstraint
   */
  public function setUpdated($updated)
  {
    $this->updated = $updated;

    return $this;
  }

  /**
   * Simple function to return the URI for loading the ticket types.
   *
   * @return string
   */
  public function getUri() {
    throw new EWSClientError('Unable to update ticket type constraint directly');
  }

  public function setId($id) {
    $this->id = $id;
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
      'registrationOpenDate',
      'registrationCloseDate',
      'maximumTickets',
      'minimumTickets',
      'salesChannels',
      'requiresTicketTypes',
    ];
  }

  /**
   * Simple function to return the URI for creating the Event.
   *
   * @return string
   */
  public function getCreateUri() {
    throw new EWSClientError('Unable to update ticket type directly');
  }
}
