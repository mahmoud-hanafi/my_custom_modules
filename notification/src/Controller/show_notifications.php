<?php
namespace Drupal\notification\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class show_notifications extends ControllerBase{
    public function show(){
        $user = \Drupal::currentUser();
        $uid = \Drupal::currentUser()->id();
        $user_account = \Drupal\user\Entity\User::load("$uid"); 
        $instructor_name = $user_account->get('name')->value;
        //print($instructor_name);
        $sql = "SELECT `notification_message`  FROM `notification` WHERE `instructor_mail`= '$instructor_name' ";
        $html_code="";
        $database = \Drupal::database();
        $result = $database->query($sql);
        while ($row_data = $result->fetchAssoc()) {
            $html_code .= $row_data['notification_message'];
        }
        //prit(5);
        print($html_code);
        exit();
    }
}  
?>