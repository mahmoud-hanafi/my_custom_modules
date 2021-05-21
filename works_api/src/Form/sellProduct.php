<?php

namespace Drupal\works_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


class sellProduct extends FormBase {

    public function getFormId() {
      return 'sellProduct';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        
        
    $form['description'] = array(
        '#markup' => '<h3> قم بإختيار المنتج والكمية المراد بيعها</h3>',
    ); 
        $products = array();
        $sql = "SELECT nid , title FROM `node_field_data` WHERE `type` = 'product' ";
        $database = \Drupal::database();
        $result = $database->query($sql);
        while ($row_data = $result->fetchAssoc()) {
            $nid = $row_data['nid'];
            $prod_name = $row_data['title'];
            $products += ["$nid" => "$prod_name"];
        }
    $form['prod_id'] = array( 
        '#type' => 'select' ,
        '#title' => t('قم بتحديد اسم النتج المراد بيعه') ,
        '#options' =>$products,
        '#required' => TRUE,
    );
    $form['prod_count'] = array( 
        '#type' => 'number' ,
        '#title' => t('الكمية المراد بيعها') ,
        '#required' => TRUE,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('إجراء عملية البيع'),
        '#button_type' => 'Danger',
    );
    return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
      
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $product_nid = $form_state->getValue('prod_id');
        $product_count = $form_state->getValue('prod_count');
        $product_solo_price =  db_query("SELECT `field_price_value`  FROM `node__field_price` WHERE `entity_id` = :product_nid  LIMIT 1 ",array(":product_nid" => $product_nid))->fetchField();
        $product_quantity = db_query("SELECT `field_quantity_value` FROM `node__field_quantity` WHERE `entity_id` = :product_nid  LIMIT 1 ",array(":product_nid" => $product_nid))->fetchField();
        $product_sold = db_query("SELECT `field_sold_value` FROM `node__field_sold` WHERE `entity_id` = :product_nid  LIMIT 1 ",array(":product_nid" => $product_nid))->fetchField();
        $product_rest = db_query("SELECT `field_rest_value` FROM `node__field_rest` WHERE `entity_id` = :product_nid  LIMIT 1 ",array(":product_nid" => $product_nid))->fetchField();
        $node = \Drupal::entityManager()->getStorage('node')->load($product_nid);
        $product_rest_number = $product_rest - $product_count;
        $product_sold_number = $product_sold + $product_count;
        $node->field_sold->value = $product_sold_number;
        $node->field_rest->value = $product_rest_number;
        $node->field_rest_price->value = $product_rest_number * $product_solo_price;
        $node->field_rest_sold->value = $product_sold_number * $product_solo_price;
        $node->field_quantity->value = $product_quantity - $product_count;
        $node->save();
        $operation_price = $product_count * $product_solo_price;
        drupal_set_message(t("تمت العملية البيع بنجاح , إجمالي عملية البيع'$operation_price' "), 'status');
    }
}
?>