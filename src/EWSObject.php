<?php

namespace Cruk\EventSdk;

use Cruk\MicroserviceBundle\Entity\MicroserviceClient\Data;
use Cruk\MicroserviceBundle\Service\MicroserviceClient;

/**
 * @file
 *
 * Simple file to create the EWS interface that all other EWS classes will implement.
 */
abstract class EWSObject implements \JsonSerializable {
  /** @var MicroserviceClient */
  protected $microserviceClient;

  /**
   * List of fields that have been updated. This allows us to use the patch function in a stupid way.
   *
   * @var array
   */
  protected $fieldsToPatch;

  /**
   * Create a new EWSObject
   *
   * @param MicroserviceClient $microserviceClient
   *   EWSClient which does all the HTTP requests for us.
   * @param mixed $data
   *   Either an ID, or an array to populate the object.
   */
  public function __construct(MicroserviceClient $microserviceClient, $data) {
    $this->setMicroserviceClient($microserviceClient);
    $this->fieldsToPatch = [];
    $this->populate($data);
  }

  /**
   * Populate an EWSClient Object with data sent through to us.
   *
   * @param mixed $data
   * @return EWSObject
   */
  protected function populate($data) {
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        if (!$this->setValueFromKey($key, $value) && is_array($value)) {
          foreach ($value as $key2 => $value2) {
            $this->setValueFromKey($key2, $value2);
          }
        }
      }
    }
    elseif ($data) {
      $key = $this->getIdKey();
      $setter = 'set' . ucfirst($key);
      if (method_exists($this, $setter)) {
        $this->$setter($data);
        $this->load();
      }
    }
    return $this;
  }

  /**
   * Simple helper function to set a value from a key and value
   *
   * @param string $key
   * @param mixed $value
   * @return EWSObject
   */
  public function setValueFromKey($key, $value) {
    if (!is_null($value)) {
      $setter = 'set' . ucfirst($key);
      if (method_exists($this, $setter)) {
        return $this->$setter($value);
      }
    }
    return FALSE;
  }

  /**
   * Simple function to return the idKey of a class. This allows us to use
   * a common populate function across all objects/classes.
   *
   * @return string
   */
  abstract protected function getIdKey();

  /**
   * Load an object from the EWS and set the local variables.
   *
   * @return EWSObject
   */
  public function load() {
    $authenticationCredentials = $this->getMicroserviceClient()->getCredentials(
    );
    $response = $this->getMicroserviceClient()->call(
      $this->getUri(),
      'GET',
      $authenticationCredentials
    );
    $this->populate($response);

    return $this;
  }

  /**
   * Simple function to return the URI that should be used to GET this object
   * from the EWS.
   *
   * @return string
   */
  abstract protected function getUri();

  /**
   * Create a new object on the EWS and set the local variables
   *
   * @return EWSObject
   */
  public function create() {
    $response = $this->client->requestJson(
      'POST',
      $this->getCreateUri(),
      ['json' => $this->asArray()]
    );
    $this->populate($response);
    return $this;
  }

  /**
   * Simple function to return the URI that should be used to POST/UPDATE this object
   * from the EWS.
   *
   * @return string
   */
  abstract protected function getCreateUri();

  /**
   * Create an array that can be used to send to the EWS or simply to send to Drupal
   * or any other client.
   *
   * TODO: Convert this to use array_walk or to recurse. This currently only works with
   * two levels.
   *
   * @return array
   */
  public function asArray() {
    return $this->asArrayWithStructure($this->getArrayStructure());
  }

  /**
   * Helper function to return an array of this object. This allows us to
   * filter the array for patch calls.
   *
   * @param $structure
   * @return array;
   */
  private function asArrayWithStructure($structure) {
    $returnArray = [];
    foreach ($structure as $array_key => $key) {
      if (is_array($key)) {
        foreach ($key as $key2) {
          if (is_array($key2)) {
            foreach ($key2 as $key3) {
              $value = $this->getValueFromKey($key3);
              if (!is_null($value)) {
                $returnArray[$array_key][$key3] = $value;
              }
            }
          }
          else {
            $value = $this->getValueFromKey($key2);
            if (!is_null($value)) {
              $returnArray[$key2] = $value;
            }
          }
        }
      }
      else {
        $value = $this->getValueFromKey($key);
        if (!is_null($value)) {
          $returnArray[$key] = $value;
        }
      }
    }
    return $returnArray;
  }

  /**
   * Simple helper function to get a value from a key
   *
   * @param string $key
   * @return mixed
   */
  public function getValueFromKey($key) {

    $getter = 'get' . ucfirst($key);
    if (method_exists($this, $getter)) {
      $value = $this->$getter();
      if (is_object($value)) {
        $value = $value->asArray();
      }
      return $value;
    }
    return NULL;
  }

  /**
   * Simple function to return the structure of the class. This defines how the
   * object should be built and delivered as an array.
   *
   * @return array
   */
  abstract protected function getArrayStructure();

  /**
   * Patch data to an existing object (effectively uses patch)
   *
   * @param mixed $data
   * @return EWSObject
   */
  public function patch($data = FALSE) {
    if (!$data) {
      // We haven't been sent any data, so we attempt to build it based on the values of $fieldsToPatch
      $data = $this->asArrayWithStructure($this->fieldsToPatch);
    }
    $this->fieldsToPatch = [];
    $authenticationCredentials = $this->getMicroserviceClient()->getCredentials(
    );
    $response = $this->getMicroserviceClient()->call(
      $this->getUri(),
      'PATCH',
      $authenticationCredentials,
      new Data($data)
    );
    $this->populate($response);

    return $this;
  }

  /**
   * Update an existing object
   *
   * @param string $method
   *   HTTP method to use (either PUT or PATCH - patch should only be used with very specific objects)
   * @return EWSObject $this
   *   The object that has been updated
   * @throws EWSClientError
   */
  public function update($method = 'PUT') {
    $data = $this->asArray();
    // EWS does not allow us to send the ID (it's in the URL), so we need to
    // unset it.
    $idKey = $this->getIdKey();
    if (isset($data[$idKey])) {
      unset($data[$idKey]);
    }
    else {
      foreach ($data as $key => $value) {
        if (is_array($value) && isset($data[$key][$idKey])) {
          unset($data[$key][$idKey]);
          break;
        }
      }
    }

    $authenticationCredentials = $this->getMicroserviceClient()->getCredentials(
    );
    $response = $this->getMicroserviceClient()->call(
      $this->getUri(),
      $method,
      $authenticationCredentials,
      new Data($data)
    );

    $this->populate($response);

    return $this;
  }

  /**
   * Simple function to return an array of Participants based on search criteria.
   *
   * @param MicroserviceClient $microserviceClient
   *   Client.
   * @param array $query
   *   Query array for building the query string.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   */
  public static function search(
    MicroserviceClient $microserviceClient,
    $query,
    $class = '',
    $path = ''
  ) {
    $authenticationCredentials = $microserviceClient->getCredentials();
    $results = $microserviceClient->call(
      $path . '?' . http_build_query($query),
      'GET',
      $authenticationCredentials
    );
    $objects = [];
    foreach ($results['results'] as $result) {
      $objects[] = new $class($microserviceClient, $result);
    }
    return $objects;
  }

  /**
   * Repeatedly perform a search of a paginated resource until there are no more results
   *
   * @param MicroserviceClient $microserviceClient
   *   Client.
   * @param array $query
   *   Query array for building the query string.
   * @param integer $pageSize
   *   Number of results to request per page.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   */
  public static function searchPaginated(
    MicroserviceClient $microserviceClient,
    $query,
    $pageSize,
    $class = '',
    $path = ''
  ) {
    $page = 0;
    $results = array();

    if ($pageSize <= 0) {
      return $results;
    }

    do {
      $query['limit'] = $pageSize;
      $query['offset'] = $pageSize * $page;
      $pageResults = self::search($microserviceClient, $query, $class, $path);
      $results = array_merge($results, $pageResults);
      $page++;
    } while (count($pageResults) >= $pageSize);

    return $results;
  }

  /**
   * Simple function to return an array of Participants based on search criteria.
   *
   * @param MicroserviceClient $microserviceClient
   *   Client.
   * @param array $queries
   *   Array of query arrays for building the query string.
   * @param string $class
   *   Class name of the objects to create with the results.
   * @param string $path
   *   Path to the API.
   *
   * @return array
   */
  public static function searches(
    MicroserviceClient $microserviceClient,
    $queries,
    $class = '',
    $path = ''
  ) {
    $objects = array();
    foreach ($queries as $query) {
      $objects = array_merge($objects, self::search($microserviceClient, $query, $class, $path));
    }

    return $objects;
  }

  /**
   * Returns data for a JSON representation of this object
   */
  public function jsonSerialize() {
    return $this->asArray();
  }

  /**
   * @return MicroserviceClient
   */
  protected function getMicroserviceClient() {
    return $this->microserviceClient;
  }

  /**
   * @param MicroserviceClient $microserviceClient
   * @return EWSObject
   */
  protected function setMicroserviceClient($microserviceClient) {
    $this->microserviceClient = $microserviceClient;

    return $this;
  }
}
