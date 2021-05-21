<?php

namespace Drupal\learning_module\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\Exception;
use Drupal\Core\Controller\ControllerBase;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\Plugin\rest\resource\EntityResource;
use Drupal\node\Entity\Node;

class printJsonController extends ControllerBase{
    
    public function printJsonObject(Request $request) {
        
        return new JsonResponse([
            'data' => $this->getWorks(),
            'method' => 'GET',
        ]);
    }

    public function getWorks() {
        $storage = \Drupal::entityManager()->getStorage('node');
        $nids = \Drupal::entityQuery('node')
        ->condition('type', 'works')
        ->execute();
        $works = $storage->loadMultiple($nids);
        
        foreach ($works as $work) {
            $id = $work->nid->value;
            $title = $work->title->value;
            $year = $work->field_work_period->value;
            $description = $work->body->value;

            $field_category = $work->field_work_type;
            $category = $field_category->getFieldDefinition()->getFieldStorageDefinition()->getOptionsProvider('value', $field_category->getEntity())
            ->getPossibleOptions()[$field_category->value];

            $user = \Drupal\user\Entity\User::load($work->field_responsible_user->target_id);
            $user_name = $user->name->value;

            $uri = $work->get('field_work_image')->entity->uri->value;
            $img_url = file_create_url($uri);
            
            $data = array('Node Id' => $id ,'Node Title' => $title , 'Image Url' => $img_url , 'Responsible User' => $user_name , 'Year' => $year ,
            'Category' => $category , 'Description' => $description);

            echo json_encode($data);
        }
        exit();
    }
}
?>