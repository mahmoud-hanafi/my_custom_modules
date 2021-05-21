<?php


/**
* @file
* Contains \Drupal\mymodule\Plugin\Field\FieldWidget\RealNameDefaultWidget
*/


namespace Drupal\my_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;



class RealNameDefaultWidget extends WidgetBase {

    public function formElement(FieldItemListInterface $items,$delta, array $element, array &$form, FormStateInterface $form_state) {

        $element['first_name'] = array(
            '#type' => 'textfield',
            '#title' => t('First name'),
            '#default_value' => '',
            '#size' => 25,
            '#required' => $element['#required'],
        );

        $element['last_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Last name'),
            '#default_value' => '',
            '#size' => 25,
            '#required' => $element['#required'],
        );

        return $element;

    }

}


?>