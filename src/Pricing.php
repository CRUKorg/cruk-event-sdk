<?php
/**
 * Created by PhpStorm.
 * User: said
 * Date: 14/02/2017
 * Time: 16:13
 */

namespace Cruk\EventSdk;


class Pricing extends EWSObject {
  protected $price;
  protected $discount;
  /**
   * @var PricingConstraint
   */
  protected $constraint;

  /**
   * Pricing constructor.
   * @param \Cruk\EventSdk\EWSClient $client
   * @param mixed $data
   */
  public function __construct(\Cruk\EventSdk\EWSClient $client, $data) {
    parent::__construct($client, $data);
    if (!$this->constraint) {
      $this->constraint = new PricingConstraint($this->client, []);
    }
  }

  /**
   * @return PricingConstraint
   */
  public function getConstraint() {
    return $this->constraint;
  }

  /**
   * @param mixed $constraint
   * @return Pricing
   */
  public function setConstraint($constraint) {
    if (is_array($constraint)) {
      $this->constraint = new PricingConstraint($this->client, $constraint);
    }
    elseif($constraint instanceof PricingConstraint) {
      $this->constraint = $constraint;
    }
    return $this;
  }

  /**
   * @var TicketPrice
   */
  protected $tickets;

  /**
   * @return mixed
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * @param mixed $price
   * @return Pricing
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
   * @return Pricing
   */
  public function setDiscount($discount) {
    $this->discount = $discount;
    return $this;
  }

  /**
   * @return TicketPrice[]
   */
  public function getTickets() {
    return $this->tickets;
  }

  /**
   * Get cou tof tickets grouped by ticketTypeId ticket counts
   * @return array
   */
  public function getTicketTypesCount() {
    $counts = [];
    foreach ($this->tickets as $ticket) {
      $id = $ticket->getTicketTypeId();
      $counts[$id] = isset($counts[$id]) ? $counts[$id] + 1 : 1;
    }
    return $counts;
  }
  /**
   * @param mixed $tickets
   * @return Pricing
   */
  public function setTickets($tickets) {
    foreach ($tickets as $ticket) {
      if (is_array($ticket)) {
        $ticket = new TicketPrice($this->client, $ticket);
      }
      elseif(!is_object($ticket)) {
        throw new \Exception('Ticket must be array or instance of TicketPrice');
      }
      $this->tickets[] = $ticket;
    }
    return $this;
  }


  /**
   * @param \Cruk\EventSdk\PricingConstraint $constraint
   * @return mixed
   */
  public function loadTicketPrices() {
    $data = json_encode($this->constraint->asRequest());
    $uri = $this->client->getPath() . '/pricing/calculate';
    try {
      $response = (object) $this->client->requestJson('POST', $uri, array('body' => $data));
      $this->price = $response->price;
      $this->discount = $response->discount;
      $this->tickets = [];
      foreach ($response->ticketPrices as $price) {
        $this->tickets[]= new TicketPrice($this->client, $price);
      }
      return $this->tickets;
    }
    catch(\Exception $e) {
      return FALSE;
    }
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
      'price',
      'discount',
      'tickets',
      'constraint',
    ];
  }

  /**
   * see parent::asArray.
   */
  public function asArray() {
    $data = parent::asArray();
    if (!empty($data['tickets'])) {
      foreach ($data['tickets'] as $delta => $ticket) {
        $data['tickets'][$delta] = $ticket->asArray();
      }
    }
    if ($this->constraint) {
      $data['constraint'] = $this->constraint->asArray();
    }
    return $data;
  }
}