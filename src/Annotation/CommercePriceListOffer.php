<?php

namespace Drupal\commerce_pricelist\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines the pricelist offer plugin annotation object.
 *
 * Plugin namespace: Plugin\PriceList\Offer.
 *
 * @Annotation
 */
class CommercePriceListOffer extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
