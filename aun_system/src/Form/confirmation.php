<?php

namespace Drupal\aun_system\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Url;

/**
 * Class News ConfirmForm.
 */
class confirmation extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'confirmation';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    $form['#attributes']['class'][] = 'text-center margin-top-20';

    $form['confirm'] = [
      '#type' => 'submit',
      '#value' => $this->t('Confirm Adding News'),
      '#weight' => '0',
      '#attributes' => ['class' => ['btn btn-primary btn-confirm']],
    ];

    $form['cancel'] = [
      '#type' => 'submit',
      '#value' => $this->t('Cancel News'),
      '#weight' => '0',
      '#attributes' => ['class' => ['btn btn-link btn-cancel']],
      '#submit' => array('::onCancelNews'),
    ];

    if (!empty($node)) {
      $form_state->set('node', $node);
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $node = $form_state->get('node');
    $node->setPublished(TRUE);
    $node->save();
    \Drupal::messenger()->addMessage($this->t('News Added successfully.'), 'status', TRUE);
    //$url = Url::fromUserInput($this->getRedirectPath());
    //$form_state->setRedirectUrl($url);
    print "Added";
    exit();
  }

   /**
   * Custom submission handler on canceling news.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function onCancelNews(array &$form, FormStateInterface $form_state) {
    $node = $form_state->get('node');
    $node->delete();
    \Drupal::messenger()->addMessage($this->t('You\'ve canceled your New News.'), 'status', TRUE);
    print"Cancelled";
    exit();
    //$url = Url::fromUserInput($this->getRedirectPath());
    //$form_state->setRedirectUrl($url);
  }

  /*public function getRedirectPath() {
    $current_user = \Drupal::currentUser();
    $roles = $current_user->getRoles();

    if (in_array('trader', $roles)) {
      return '/dashboard/seller/orders';
    }

    if (in_array('shipping_company_representor', $roles)) {
      return '/dashboard/company/orders/pickup';
    }

    return '/';
  }*/
}
