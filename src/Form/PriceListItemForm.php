<?php

namespace Drupal\commerce_pricelist\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Price list item edit forms.
 *
 * @ingroup commerce_pricelist
 */
class PriceListItemForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\commerce_pricelist\Entity\PriceListItem */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    $form['#tree'] = TRUE;
    $form['#theme'] = ['commerce_pricelist_form'];
    $form['#attached']['library'][] = 'commerce_pricelist/form';

    $form['advanced'] = [
        '#type' => 'container',
        '#attributes' => ['class' => ['entity-meta']],
        '#weight' => 99,
    ];

    $form['option_details'] = [
        '#type' => 'container',
        '#title' => $this->t('Options'),
        '#group' => 'advanced',
        '#attributes' => ['class' => ['entity-meta__header']],
        '#weight' => -100,
    ];
    $form['date_details'] = [
        '#type' => 'details',
        '#open' => TRUE,
        '#title' => $this->t('Dates'),
        '#group' => 'advanced',
    ];

    $field_details_mapping = [
        'status' => 'option_details',
        'weight' => 'option_details',
        'start_date' => 'date_details',
        'end_date' => 'date_details',
    ];

    foreach ($field_details_mapping as $field => $group) {
      if (isset($form[$field])) {
        $form[$field]['#group'] = $group;
      }
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Price list item.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Price list item.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.price_list_item.canonical', ['price_list_item' => $entity->id()]);
  }

}
