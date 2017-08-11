<?php

namespace Drupal\commerce_pricelist\Resolver;

use Drupal\commerce\Context;
use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_price\Price;
use Drupal\commerce_pricelist\PriceListService;
use Drupal\user\Entity\User;


/**
 * Class PriceListDefaultBasePriceResolver.
 *
 * @package Drupal\commerce_pricelist
 */
class PriceListDefaultBasePriceResolver implements PriceListBasePriceResolverInterface {

  /**
   * The PriceList Service.
   *
   * @var \Drupal\commerce_pricelist\PriceListService
   */
  protected $priceListService;

  /**
   * Constructs a new PriceResolver object.
   *
   * @param \Drupal\commerce_pricelist\PriceListService $pricelist_service
   *   The entity type manager.
   */
  public function __construct(PriceListService $pricelist_service) {
    $this->priceListService = $pricelist_service;
  }

  /**
   * {@inheritdoc}
   */
  public function resolve(PurchasableEntityInterface $entity, $quantity = 1, Context $context) {
    if ($this->applies($entity)) {
      $price = $entity->getPrice();
      // TODO: Need to order pricelist and pricelist items by weight
      $items = $this->priceListService->getPriceListItemsByVariationId([$entity->id()]);
      foreach ($items as $key => $item) {
        // Load the PriceList Entity associated with the PriceListItem.
        $pricelist = $this->priceListService->getPriceListEntities([$item->get('price_list_id')->getValue()[0]['target_id']]);
        foreach ($pricelist as $key => $value) {
          if ($value->applies(User::load($context->getCustomer()->id()))) {
            return $item->getPrice();
          }
          break;
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
