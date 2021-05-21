<?php

namespace Drupal\my_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


class ExampleForm extends FormBase {

    public function getFormId() {
        return 'searchForm';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['description'] = array(
        '#markup' => '<h3> Enter Student adder to find the age of student </h3>',
      );
      $form['std_name'] = array( 
        '#type' => 'textfield' ,
        '#title' => t('Enter Student name') ,
      );
      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('find age'),
        '#button_type' => 'primary',
      );
    return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
      if (strlen($form_state->getValue('std_name')) <= 2) {
        $form_state->setErrorByName('std_name', t('no student name exists has characters less than 2 '));
      }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $std_add = $form_state->getValue('std_name');
        $sql = "select field_age_value vage  from node__field_age	age inner join node__field_student_adder std_adder using(entity_id) where std_adder.field_student_adder_value= '$std_add' ";
        //print $sql;
        //exit();
        $database = \Drupal::database();
        $result = $database->query($sql);
        $html_code = "<h3> You are a failure.</h3>";
        while ($row_data = $result->fetchAssoc()) {
          $age = $row_data['vage'];
          $html_code .= "<h3>".$age."</h3>";
        }
        print $html_code;
      //$a = \Drupal::messenger()->addStatus(t('This is a successful message.'));
      //$b = \Drupal::messenger()->addWarning(t('This is a warning message.'));
      //print drupal_set_message(t("Don't panic!"), 'warning');
      //exit();
    }
}
?>