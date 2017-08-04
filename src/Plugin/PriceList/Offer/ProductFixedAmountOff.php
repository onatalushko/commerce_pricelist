<?php

namespace Drupal\commerce_pricelist\Plugin\PriceList\Offer;

use Drupal\Core\Entity\EntityInterface;

/**
 * Provides the percentage off offer for order items.
 *
 * @CommercePriceListOffer(
 *   id = "product_fixed_amount_off",
 *   label = @Translation("Fixed amount off product price"),
 *   entity_type = "commerce_product_variation",
 * )
 */
class ProductFixedAmountOff extends FixedAmountOffBase {

  /**
   * {@inheritdoc}
   */
  public function apply(EntityInterface $entity) {
    $this->assertEntity($entity);
    /** @var \Drupal\commerce_order\Entity\OrderItemInterface $order_item */
    $product = $entity;
    $unit_price = $product->getPrice();
    $adjustment_amount = $this->getAmount();
    if ($unit_price->getCurrencyCode() != $adjustment_amount->getCurrencyCode()) {
      return NULL;
    }
    // Don't reduce the order item unit price past zero.
    if ($adjustment_amount->greaterThan($unit_price)) {
      $adjustment_amount = $unit_price;
    }

    $unit_price = $unit_price->subtract($adjustment_amount);

    return $unit_price;
  }

}
