<?php

namespace Drupal\commerce_pricelist\Resolver;

use Drupal\commerce\Context;
use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_price\Price;
use Drupal\user\Entity\User;


/**
 * Class PriceListDefaultBasePriceResolver.
 *
 * @package Drupal\commerce_pricelist
 */
class PriceListDefaultBasePriceResolver implements PriceListBasePriceResolverInterface {

  /**
   * {@inheritdoc}
   */
  public function resolve(PurchasableEntityInterface $entity, $quantity = 1, Context $context) {
    if ($this->applies($entity)) {
      $price = $entity->getPrice();
      $user = User::load(\Drupal::currentUser()->id());
      // TODO: Need to order pricelist and pricelist items by weight
      $items = commerce_pricelist_item_load_by_variation_ids([$entity->id()]);
      foreach ($items as $key => $item) {
        $pricelist = \Drupal::entityTypeManager()->getStorage('price_list')->load($item->get('price_list_id')->getValue()[0]['target_id']);
        if ($pricelist->applies($user)) {
            return $item->apply($entity);
        }
      }
    }
    return NULL;
  }

  /**
   * Determines whether the resolver applies to the given purchasable entity.
   *
   * @param \Drupal\commerce\PurchasableEntityInterface $entity
   *   The purchasable entity.
   *
   * @return bool
   *   TRUE if the resolver applies to the given purchasable entity, FALSE
   *   otherwise.
   */
  public function applies(PurchasableEntityInterface $entity) {
    return $entity->hasField('price') && !$entity->get('price')->isEmpty();
  }

}
