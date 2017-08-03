<?php

namespace Drupal\commerce_pricelist\Plugin\Commerce\Condition;

use Drupal\commerce\Plugin\Commerce\Condition\ConditionBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the product condition for order items.
 *
 * @CommerceCondition(
 *   id = "current_user",
 *   label = @Translation("User"),
 *   display_label = @Translation("Limit by User"),
 *   category = @Translation("User"),
 *   entity_type = "user",
 * )
 */
class CurrentUser extends ConditionBase implements ContainerFactoryPluginInterface {

  /**
   * The user storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $userStorage;

  /**
   * Constructs a new OrderItemProduct object.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->userStorage = $entity_type_manager->getStorage('user');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'users' => [],
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $users = NULL;
    $uids = array_column($this->configuration['users'], 'uid');
    if (!empty($uids)) {
      $users = $this->userStorage->loadMultiple($uids);
    }
    $form['users'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Users'),
      '#default_value' => $users,
      '#target_type' => 'user',
      '#tags' => TRUE,
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    $values = $form_state->getValue($form['#parents']);
    $this->configuration['users'] = [];
    foreach ($values['users'] as $value) {
      $this->configuration['users'][] = [
        'uid' => $value['target_id'],
      ];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate(EntityInterface $entity) {
    $this->assertEntity($entity);
    $user = $entity;

    $uids = array_column($this->configuration['users'], 'uid');

    return in_array($user->id(), $uids);
  }

}
