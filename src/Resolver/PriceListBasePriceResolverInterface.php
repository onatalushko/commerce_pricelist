<?php

namespace Drupal\commerce_pricelist\Resolver;

use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_price\Resolver\PriceResolverInterface;

/**
 * Interface PriceListBasePriceResolverInterface.
 *
 * @package Drupal\commerce_pricelist
 */
interface PriceListBasePriceResolverInterface extends PriceResolverInterface {

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
  public function applies(PurchasableEntityInterface $entity);

}
