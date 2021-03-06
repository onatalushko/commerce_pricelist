<?php

/**
 * @file
 * Contains price_list.page.inc.
 *
 * Page callback for Price list entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Price list templates.
 *
 * Default template: price_list.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_price_list(array &$variables) {
  // Fetch PriceList Entity Object.
  $price_list = $variables['elements']['#price_list'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

/**
* Prepares variables for a custom entity type creation list templates.
*
* Default template: price_list-content-add-list.html.twig.
*
* @param array $variables
*   An associative array containing:
*   - content: An array of price_list-types.
*
* @see block_content_add_page()
*/
function template_preprocess_price_list_content_add_list(&$variables) {
  $variables['types'] = array();
  $query = \Drupal::request()->query->all();
  foreach ($variables['content'] as $type) {
    $variables['types'][$type->id()] = array(
      'link' => Link::fromTextAndUrl($type->label(), new Url('entity.price_list.add_form', array(
        'price_list_type' => $type->id()
      ), array('query' => $query))),
      'description' => array(
      '#markup' => $type->label(),
      ),
      'title' => $type->label(),
      'localized_options' => array(
      'query' => $query,
      ),
    );
  }
}
