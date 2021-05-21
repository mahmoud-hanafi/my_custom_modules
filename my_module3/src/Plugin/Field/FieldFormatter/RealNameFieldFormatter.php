<?php

namespace Drupal\my_module\Plugin\Field\FieldFormatter;


use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;


class RealNameFieldFormatter extends FormatterBase {

    public function viewElements(FieldItemListInterface $items,$langcode) {
        $element = [];
        foreach ($items as $delta => $item) {
            $element[$delta] = array(
            '#markup' => $this->t('@first @last', array(
            '@first' => $item->first_name,
            '@last' => $item->last_name,)
            ),
            );
            }
        
            return $element;}
}

?>