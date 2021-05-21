<?php

namespace Drupal\my_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Component\Utility\SafeMarkup;
use Drupal\Component\Utility\Html;


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
      /*$user = \Drupal::currentUser();
      $uid = \Drupal::currentUser()->id();
      $Course_nid = $form_state->getValue('std_courses');
      $delete = "DELETE FROM `node__field_auidence` WHERE `entity_id` = $Course_nid and `field_auidence_target_id` = $uid";
      $delete = db_query("DELETE FROM `node__field_auidence` WHERE `entity_id` = :Course_nid and `field_auidence_target_id` =:uid ",array(":Course_nid" => $Course_nid , ":uid"=>$uid));*/
        //$database = \Drupal::database();
        //$result = $database->query($delete);
        
        //Send Mail
      $mailManager = \Drupal::service('plugin.manager.mail');
      $module = 'my_module';
      $key = 'course_deletion';
      $to = "mahmoud7elmy92@gmail.com";
      $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $params = array(
        'subject' => 'This is a reminder to Delete Course(s) you have selected',
        'message' => 'This is a reminder to Delete Course(s) you have selected',
        'title' => 'Course Deletion',
      );
      /*$params['message'] = "This is the message";
      $params['subject'] = "Message subject";
      $params['title'] = "Message subject";*/

      $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, TRUE);

      /*$mailManager = \Drupal::service('plugin.manager.mail');
      $module = 'my_module';
      $key = 'create_article';
      $to = \Drupal::currentUser()->getEmail();
      $params['message'] = $entity->get('body')->value;
      $params['node_title'] = $entity->label();
      $langcode = \Drupal::currentUser()->getPreferredLangcode();
      $send = true;

      $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);*/
      if ($result['result'] !== TRUE) {
        print "Problem";
      }
      else {
        print "Sent";
      }
      exit();
      
    }
}
?>