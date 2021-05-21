<?php

/**
* @file
* Contains \Drupal\my_module\Form\ExampleForm.
**/
namespace Drupal\my_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


class searchForm extends FormBase {

    public function getFormId() {
        return 'ExampleForm';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['company_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Company name'),
            );
            $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            );
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        // Validation covered in later recipe, required to satisfy interface
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Validation covered in later recipe, required to satisfyinterface
    }
}
?>