<?php

namespace Drupal\commerce_pricelist\Plugin\PriceList\Offer;

use Drupal\commerce_order\Adjustment;
use Drupal\commerce_promotion\Entity\PromotionInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides the percentage off offer for order items.
 *
 * @CommercePriceListOffer(
 *   id = "product_percentage_off",
 *   label = @Translation("Percentage off product price"),
 *   entity_type = "commerce_product_variation",
 * )
 */
class ProductPercentageOff extends PercentageOffBase {

  /**
   * {@inheritdoc}
   */
  public function apply(EntityInterface $entity) {
    $this->assertEntity($entity);

    $product = $entity;
    $adjustment_amount = $product->getPrice()->multiply($this->getAmount());

    return $this->rounder->round($adjustment_amount);
  }

}
