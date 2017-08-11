<?php

namespace Drupal\commerce_pricelist;

use Drupal\Core\Entity\EntityTypeManagerInterface;

class PriceListService
{
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new PriceListService object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Loads multiple price_list entities.
   *
   * @param mixed $list_ids
   *   Array of PriceList ids.
   *
   * * @return array \Drupal\commerce_pricelist\Entity\PriceList
   *   An array of PriceList entities.
   */
  public function getPriceListEntities($list_ids = NULL) {
    $entities = $this->entityTypeManager->getStorage('price_list')->loadMultiple($list_ids);

    return $entities;
  }

  /**
   * Loads multiple price_list_tiem entities.
   *
   * @param mixed $item_ids
   *   Array of PriceListItem ids.
   *
   * * @return array \Drupal\commerce_pricelist\Entity\PriceListItem
   *   An array of PriceListItem entities.
   */
  public function getPriceListItems($item_ids = NULL) {
    $entities = $this->entityTypeManager->getStorage('price_list_item')->loadMultiple($item_ids);

    return $entities;
  }

  /**
   * Loads multiple price_list_item entities by product variation id.
   *
   * @param array $vids
   *   Array of product variation ids.
   *
   * @return array \Drupal\commerce_pricelist\Entity\PriceListItem
   *   An array of PriceListItem entities.
   */
  public function getPriceListItemsByVariationId(array $vids) {
    $entities = [];
    foreach($vids as $key => $id) {
      $item = \Drupal::entityQuery('price_list_item')
        ->condition('product_variation_id', $id)
        ->execute();
      if(!empty($item)) {
        $entities[$item[1]] = $this->entityTypeManager->getStorage('price_list_item')->load($item[1]);
      }
    }

    return $entities;
  }
}