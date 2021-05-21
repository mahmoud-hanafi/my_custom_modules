<?php

namespace Drupal\shipub_shipping_company\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DrupalDateTime;


/**
 * Class QuickOrderController.
 */
class QuickOrderController extends ControllerBase {

  /**
   * Quickorderform.
   *
   * @return string
   *   Return Hello string.
   */
  public function quickOrderForm() {
    $type = node_type_load("orders"); // replace this with the node type in which we need to display the form for
    $node = $this->entityManager()->getStorage('node')->create(array(
      'type' => $type->id(),
    ));

    // OPTIONAL - Set default values for node fields
    $node_create_form = $this->entityFormBuilder()->getForm($node, 'order_quick_mode');
    $node_create_form['#theme'] = 'shipub_shipping_company';
    $node_create_form['#attached']['library'][] = 'shipub_shipping_company/quick-order-create';

    return array(
      '#type' => 'markup',
      '#markup' => render($node_create_form)
    );
  }

}
