<?php

namespace Drupal\my_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


class addStudent extends FormBase {

    public function getFormId() {
        return 'addStudent';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['description'] = array(
        '#markup' => '<h3> Create New Student.</h3>',
      );
      $form['std_name'] = array( 
        '#type' => 'textfield' ,
        '#title' => t('Enter Student name') ,
      );
      $form['std_age'] = array( 
        '#type' => 'textfield' ,
        '#title' => t('Enter Student age') ,
      );
      $form['std_address'] = array( 
        '#type' => 'textfield' ,
        '#title' => t('Enter Student address') ,
      );
      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Store'),
        '#button_type' => 'primary',
      );
    return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
      if(empty($form_state->getValue('std_name'))){
        $form_state->setErrorByName('std_name', t('Student name is required'));
      }
      if (strlen($form_state->getValue('std_name')) <= 2) {
        $form_state->setErrorByName('std_name', t('no student name exists has characters less than 2 '));
      }
      if($form_state->getValue('std_age') < 18){
        $form_state->setErrorByName('std_age', t('This university website the student age must be larger than 18 years '));
      }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $user = \Drupal::currentUser();
        $uid = \Drupal::currentUser()->id();
        $user_account = \Drupal\user\Entity\User::load("$uid"); 
        $student_adder = $user_account->get('name')->value; 
        $student_name= $form_state->getValue('std_name');
        $studetn_age= $form_state->getValue('std_age');
        $student_address= $form_state->getValue('std_address');
      //exit();
    }
}
?>