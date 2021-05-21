<?php

namespace Drupal\works_api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Controller\ControllerBase;


/**
 * Implementing our example JSON api.
 */
class JsonApiController {

  /**
   * Callback for the API.
   */
  public function renderApi(Request $request) {
    $x = $_POST['x'];
    print $x;exit();
    //$response['data'] = 'Some test data to return';
    //$response['method'] = 'POST';
    //return JsonResponse( "test" );
    //return "test";
    /*return new JsonResponse([
      'data' => $this->getResults(),
      'method' => 'GET',
    ]);*/
     
  }

  /*public function testApi() {
    return "testing api is here";
  }*/

  /**
   * A helper function returning results.
   */
  public function getResults() {
    $sql = "SELECT `nid` , `title` from `node_field_data` WHERE `type` = 'works' ";
    $category_type = array ( '0' => 'flat' , '1' => 'Full house' , '2' => 'Company' , '3' => 'Wedding Hall' , '4' => 'Photo Sessions Area');
    $database = \Drupal::database();
    $result = $database->query($sql);
    while ($row_data = $result->fetchAssoc()) {
      $id = $row_data['nid'];
      $title = $row_data['title'];
      $year = db_query("SELECT `field_work_period_value` FROM `node__field_work_period` WHERE entity_id = :id limit 1",array(":id" => $id))->fetchField();
      $category_num = db_query("SELECT `field_work_type_value` FROM `node__field_work_type` WHERE entity_id = :id limit 1",array(":id" => $id))->fetchField();
      $description = db_query("SELECT `body_value` FROM `node__body` WHERE entity_id = :id limit 1",array(":id" => $id))->fetchField();
      $category = $category_type[$category_num];
      $data = array('nid' => $id ,'title' => $title , 'year' => $year , 'category' => $category , 'description' => $description);
      echo json_encode($data);
      //return $data;
    }
    exit();
    /*return [
      [
        "name" => "The Shawshank Redemption",
        "year" => 1994,
        "duration" => 142,
      ],
      [
        "name" => "The Godfather",
        "year" => 1972,
        "duration" => '',
      ],
      [
        "name" => "The Dark Knight",
        "year" => 2008,
        "duration" => 175,
      ],
      [
        "name" => "The Godfather: Part II",
        "year" => 1974,
        "duration" => '',
      ],
      [
        "name" => "Pulp Fiction",
        "year" => 1994,
        "duration" => '',
      ],
      [
        "name" => "The Lord of the Rings: The Return of the King",
        "year" => 2003,
        "duration" => '',
      ],
    ];*/
  }

}