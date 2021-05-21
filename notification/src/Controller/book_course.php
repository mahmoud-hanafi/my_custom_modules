<?php
namespace Drupal\notification\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class book_course extends ControllerBase{
    public function booking_course(){
        $user = \Drupal::currentUser();
        $uid = \Drupal::currentUser()->id();
        $user_account = \Drupal\user\Entity\User::load("$uid"); 
        $applicant_name = $user_account->get('name')->value; 
        
        //$html_code = "<h3>".$applicant_name."</h3>";

        $course_id = $_GET['id'];
        $sql = "SELECT `title` FROM `node_field_data` WHERE `nid` = '$course_id' ";
        $database = \Drupal::database();
        $result = $database->query($sql);
        while ($row_data = $result->fetchAssoc()) {
            $course_name = $row_data['title'];
            //$html_code .= "<h3>".$course_name."</h3>";
        }

        $sql = "SELECT `field_course_instructor_target_id` as ins_uid FROM `node__field_course_instructor` WHERE `entity_id` = '$course_id' ";
        $database = \Drupal::database();
        $result = $database->query($sql);
        while ($row_data = $result->fetchAssoc()) {
            $intructor_uid =$row_data['ins_uid']; 
            $instructor_account = \Drupal\user\Entity\User::load("$intructor_uid"); 
            $instructor_name = $instructor_account->get('name')->value;
            //$html_code .= "<h3>".$instructor_name."</h3>";
            //print ($instructor_name);
        }
        //print ($html_code);
        $status="<a href='#'> yes </a> OR <a href='#'>No</a>";
        $notification_msg = $applicant_name." want to book ".$course_name.$status;
        db_insert('notification')
        ->fields(array(
        'uid' => $uid,
        'nid' => $course_id,
        'Course_name'=> $course_name,
        'applicant_name' => $applicant_name,
        'instructor_mail' => $instructor_name,
        'notification_message' => $notification_msg,
        'created' => time(),
       ))
        ->execute();
        $msg = "request send please wait Instructor response <a href='#'> yes </a> OR <a href='#'> NO </a>";
        print($notification_msg);
        exit();
    }    
}

?>