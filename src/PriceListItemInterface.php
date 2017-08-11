<?php

namespace Drupal\commerce_pricelist;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Price list item entities.
 *
 * @ingroup commerce_pricelist
 */
interface PriceListItemInterface extends ContentEntityInterface, EntityChangedInterface {
  // Add get/set methods for your configuration properties here.
  /**
   * Gets the Price list item name.
   *
   * @return string
   *   Name of the Price list item.
   */
  public function getName();

  /**
   * Sets the Price list item name.
   *
   * @param string $name
   *   The Price list item name.
   *
   * @return \Drupal\commerce_pricelist\PriceListItemInterface
   *   The called Price list item entity.
   */
  public function setName($name);

  /**
   * Gets the Price list item creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Price list item.
   */
  public function getCreatedTime();

  /**
   * Gets the offer.
   *
   * @return \Drupal\commerce_pricelist\Plugin\PriceList\Offer\PriceListOfferInterface|null
   *   The offer, or NULL if not yet available.
   */
  public function getOffer();

  /**
   * Gets the pricelist item start date.
   *
   * @return \Drupal\Core\Datetime\DrupalDateTime
   *   The pricelist item start date.
   */
  public function getStartDate();

  /**
   * Sets the pricelist item start date.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $start_date
   *   The pricelist item start date.
   *
   * @return $this
   */
  public function setStartDate(DrupalDateTime $start_date);

  /**
   * Gets the picelist item end date.
   *
   * @return \Drupal\Core\Datetime\DrupalDateTime
   *   The pricelist item end date.
   */
  public function getEndDate();

  /**
   * Sets the pricelist item end date.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $end_date
   *   The pricelist item end date.
   *
   * @return $this
   */
  public function setEndDate(DrupalDateTime $end_date = NULL);

  /**
   * Gets the weight.
   *
   * @return int
   *   The weight.
   */
  public function getWeight();

  /**
   * Sets the weight.
   *
   * @param int $weight
   *   The weight.
   *
   * @return $this
   */
  public function setWeight($weight);

  /**
   * Checks whether the pricelist item is available.
   *
   * Ensures that the pricelist item is enabled and the current date
   * matches the start and end dates.
   *
   * @return bool
   *   TRUE if pricelist item is available, FALSE otherwise.
   */
  public function available();

  /**
   * Sets the Price list item creation timestamp.
   *
   * @param int $timestamp
   *   The Price list item creation timestamp.
   *
   * @return \Drupal\commerce_pricelist\PriceListItemInterface
   *   The called Price list item entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Price list item published status indicator.
   *
   * Unpublished Price list item are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Price list item is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Price list item.
   *
   * @param bool $published
   *   TRUE to set this Price list item to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\commerce_pricelist\PriceListItemInterface
   *   The called Price list item entity.
   */
  public function setPublished($published);

}
