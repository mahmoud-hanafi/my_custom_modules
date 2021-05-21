<?php
namespace Drupal\my_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class record_course extends ControllerBase{
    public function apply_course(){
        $user = \Drupal::currentUser();
        $uid = \Drupal::currentUser()->id();
        $user_account = \Drupal\user\Entity\User::load("$uid"); 
        $applicant_name = $user_account->get('name')->value; 
        //print ($applicant_name)."<br>";
        $html_code = "<h3>".$applicant_name."</h3>";
        //$course_id = $_GET['id'];
        //$storage_handler = \Drupal::entityTypeManager()->getStorage("node");
        //$course = $storage_handler->load($course_id);
        //$course_instructor = $course['field_course_instructor']->targe;
       $sql = "SELECT `field_course_instructor_target_id` as ins_uid FROM `node__field_course_instructor` WHERE `entity_id` = 4 ";
        $database = \Drupal::database();
        $result = $database->query($sql);
        while ($row_data = $result->fetchAssoc()) {
            $intructor_uid =$row_data['ins_uid']; 
            $instructor_account = \Drupal\user\Entity\User::load("$intructor_uid"); 
            $instructor_name = $instructor_account->get('name')->value;
            $html_code .= "<h3>".$instructor_name."</h3>";
            print ($html_code);
            //print ($instructor_name);
        }
        exit();
    }    
}

?>