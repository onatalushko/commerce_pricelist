<?php

namespace Drupal\commerce_pricelist\Plugin\PriceList\Offer;

use Drupal\commerce_price\Price;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides the percentage off offer for order items.
 *
 * @CommercePriceListOffer(
 *   id = "product_fixed_amount",
 *   label = @Translation("Set price to fixed amount"),
 *   entity_type = "commerce_product_variation",
 * )
 */
class ProductFixedAmount extends FixedAmountOffBase {

  /**
   * {@inheritdoc}
   */
  public function apply(EntityInterface $entity) {
    $this->assertEntity($entity);
    /** @var \Drupal\commerce_order\Entity\OrderItemInterface $order_item */
    $product = $entity;
    $unit_price = $product->getPrice();
    $adjustment_amount = $this->getAmount();

    if ($unit_price->getCurrencyCode() != $adjustment_amount->getCurrencyCode() || $adjustment_amount->lessThan(new Price(0, $unit_price->getCurrencyCode()))) {
      return NULL;
    }

    return $adjustment_amount;
  }

}
