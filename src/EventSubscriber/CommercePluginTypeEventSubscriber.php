<?php

namespace Drupal\commerce_pricelist\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommercePluginTypeEventSubscriber implements EventSubscriberInterface
{
  /**
   * Adds new plugin type to "commerce plugin type" field type.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The workflow transition event.
   */
  public function addPluginType($event)
  {
    $plugin_types = $event->getPluginTypes();
    $plugin_types['commerce_pricelist_offer'] = t('Promotion offer');
    $event->setPluginTypes($plugin_types);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents()
  {
    $events = [
        'commerce.referenceable_plugin_types' => 'addPluginType',
    ];
    return $events;
  }
}