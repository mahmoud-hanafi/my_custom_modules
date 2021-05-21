<?php

namespace Drupal\my_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;


class delete_events extends ControllerBase{
    public function delete_all_events(){
        global $base_url;
        $sql = "SELECT * from node_field_data where `type` = 'event' ";
        $database= \Drupal::database();
        $result= $database->query($sql);
        $i=1;
        while( $row_data = $result->fetchAssoc()){
           print $i."<br>";
           $event_nid = $row_data['nid'];
           $storage_handler = \Drupal::entityTypeManager()->getStorage("node");
           $node = $storage_handler->load($event_nid);
           if($node){
              $node->delete();
              print $event_nid."---------";
           }
           $i++;
        }
        exit();
    }
}


?>