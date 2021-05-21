<?php

namespace Drupal\my_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class page_delete extends ControllerBase{
    public function page_update(){
        global $base_url;
        $sql= "SELECT nid FROM node_field_data WHERE `type` = 'page' " ;
        $database = \Drupal::database();
        $result = $database->query($sql);
        $i =1;
        while($row_data = $result->fetchAssoc()){
            $page_nid = $row_data['nid'];
            $storage_handler = \Drupal::entityTypeManager()->getStorage("node");
            $node = $storage_handler->load($page_nid);
            if($node){
                $node->delete();
                print  $page_nid."----";
            } 
            $i++;
        }
        exit();
    }
}

?>