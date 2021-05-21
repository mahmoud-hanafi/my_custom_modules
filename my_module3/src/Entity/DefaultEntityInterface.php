<?php

namespace Drupal\my_module\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Notifications entities.
 *
 * @ingroup my_module
 */
interface DefaultEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Notifications name.
   *
   * @return string
   *   Name of the Notifications.
   */
  public function getName();

  /**
   * Sets the Notifications name.
   *
   * @param string $name
   *   The Notifications name.
   *
   * @return \Drupal\my_module\Entity\DefaultEntityInterface
   *   The called Notifications entity.
   */
  public function setName($name);

  /**
   * Gets the Notifications creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Notifications.
   */
  public function getCreatedTime();

  /**
   * Sets the Notifications creation timestamp.
   *
   * @param int $timestamp
   *   The Notifications creation timestamp.
   *
   * @return \Drupal\my_module\Entity\DefaultEntityInterface
   *   The called Notifications entity.
   */
  public function setCreatedTime($timestamp);

}
