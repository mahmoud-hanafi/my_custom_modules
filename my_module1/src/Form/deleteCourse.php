<?php

namespace Drupal\my_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


class deleteCourse extends FormBase {

    public function getFormId() {
      return 'deleteCourse';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        
        
    $form['description'] = array(
        '#markup' => '<h3> DELETE CORUSE THAT YOU ARE REGISTERED.</h3>',
      );
        $user = \Drupal::currentUser();
        $uid = \Drupal::currentUser()->id();
        $courses = array();
        $sql = "SELECT `entity_id` FROM `node__field_auidence` WHERE `field_auidence_target_id`= $uid";
        $database = \Drupal::database();
        $result = $database->query($sql);
        while ($row_data = $result->fetchAssoc()) {
            $nid = $row_data['entity_id'];
            $course_title = db_query("SELECT `title` FROM `node_field_data` WHERE nid = :nid limit 1",array(":nid" => $nid))->fetchField();
            //array_push($courses, "$nid" => "$course_title");
            $courses += ["$nid" => "$course_title"];
        }
      $form['std_courses'] = array( 
        '#type' => 'select' ,
        '#title' => t('choose course that you want to delete') ,
        '#options' => $courses,
      );
      /*$form['std_age'] = array( 
        '#type' => 'textfield' ,
        '#title' => t('Enter Student age') ,
      );
      $form['std_address'] = array( 
        '#type' => 'textfield' ,
        '#title' => t('Enter Student address') ,
      );*/
      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('DELETE'),
        '#button_type' => 'Danger',
      );
    return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
      
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $user = \Drupal::currentUser();
        $uid = \Drupal::currentUser()->id();
        $Course_nid = $form_state->getValue('std_courses');
        $delete = "DELETE FROM `node__field_auidence` WHERE `entity_id` = $Course_nid and `field_auidence_target_id` = $uid";
        $delete = db_query("DELETE FROM `node__field_auidence` WHERE `entity_id` = :Course_nid and `field_auidence_target_id` =:uid ",array(":Course_nid" => $Course_nid , ":uid"=>$uid));
        //$database = \Drupal::database();
        //$result = $database->query($delete);
        //header('Location: http://localhost/drupal8/delete/course');
        drupal_set_message(t('COURSE has been Deleted Successfully.'), 'status');
    }
}
?>