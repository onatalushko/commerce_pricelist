<?php

namespace Drupal\commerce_pricelist\Resolver;

use Drupal\commerce\Context;
use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_price\Price;
use Drupal\commerce_price\Resolver\PriceResolverInterface;


/**
 * Class PriceListDefaultBasePriceResolver.
 *
 * @package Drupal\commerce_pricelist
 */
class PriceListDefaultBasePriceResolver implements PriceResolverInterface {

  /**
   * {@inheritdoc}
   */
  public function resolve(PurchasableEntityInterface $entity, $quantity = 1, Context $context) {
    $price = new Price("45.34", $entity->getPrice()->getCurrencyCode());
    return $this->applies($entity) ? $price : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function applies(PurchasableEntityInterface $entity) {
    return $entity->hasField('price') && !$entity->getPrice()->isEmpty();
  }

}
