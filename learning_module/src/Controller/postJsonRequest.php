<?php

namespace Drupal\learning_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;
use Drupal\Core\Entity\Exception;
use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class postJsonRequest extends ControllerBase{
    //Create Node Programmitcally through Post Request
    public function addArticle(Request $request) {
        $request_content = Json::decode(\Drupal::request()->getContent());
        $account = \Drupal::currentUser();
        $uid = $account->id();

        foreach ($request_content as $item) {
            $title = $item['title'];
            $body_text = $item['body'];

            $node = Node::create([
                'type' => 'article',
                'uid' => $uid,
                'title' => "$title",
		        'body' => [
			        'value' => "$body_text",
		        ],
            ]);

            $save = $node->save();

            if ($save) {
                $response = [
                    'status' => 200 ,
                    'message' => 'Nodes Added Successfully'
                ];
            }
            else {
                $response = [
                  'status' => 500 ,
                  'message' => 'could not be created'
                ];
            }
        }
        return new JsonResponse($response);
    }
}

?>