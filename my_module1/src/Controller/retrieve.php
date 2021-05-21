<?php
namespace Drupal\my_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class retrieve extends  ControllerBase{
    public function retrieve_age(){
   // print"ss";exit();
      //$content_type = \Drupal::request()->request->get('id');
      $std_add = $_GET['id'];
      //print $content_type;exit();
      //$sql = "SELECT nid , title  FROM node_field_data node WHERE node.type ='$content_type'";
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
      exit();
    }
  }
?>