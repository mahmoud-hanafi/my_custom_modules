<?php

namespace Drupal\my_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use \Drupal\user\Entity\User;

class event_integration extends ControllerBase{
    public function transfer_integration(){
        global $base_url;

        $sql = " SELECT * from `local_conf` where `CON_Faculty` = 16 "; 
        $database = \Drupal::database();
        $result = $database->query($sql);
        $i=1;
        while($row_data = $result->fetchAssoc()){
            print  $i."<br>";  
            $event_en = $row_data['CON_eTitle'];
            $event_start =$row_data['CONF_Start'];
            $event_end = $row_data['CONF_End'];
            $event_address= 'Assiut university';
            $event_time = "9Am - 2PM"; 

            $node=array();
            $node=Node::create([
                'type' => 'event_' ,
                'langcode' => 'en' ,
                'creates' => \Drupal::time()->getRequestTime(),
                'changed' => \Drupal::time()->getRequestTime(),
                'uid' => 1 ,
                'status' => 1 ,
                'title'  => "$event_en" ,
                'field_event_start_' => [ 'value'=>"$event_start" ],
                'field_event_time' => [ 'value' => "$event_time"],
                'field_my_event_address' => [ 'value' => "$event_address" ],
                'field_my_event_end_' =>[ 'value' => "$event_end" ],
            ]);

            $node->save();
        }

        exit();
 
    }
}

?>