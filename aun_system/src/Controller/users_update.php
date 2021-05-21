<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use \Drupal\user\Entity\User;

class users_update extends  ControllerBase{
  public function handle_users_update(){
	global $base_url; // LIMIT 0,3
	//$sql = "SELECT * FROM `member` WHERE `Faculty_Code` = 02 and M_ID =656" ;
	$sql = "SELECT uid FROM `users` WHERE `uid` > 1475  " ;
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
    while ($row_data = $result->fetchAssoc()) {
	 /* print $i." s- ";
	  $uid     	        =  $row_data['uid'];
	  print $uid;
	  print $uid;
	  $user_account = \Drupal\user\Entity\User::load("$uid"); // pass your uid
	  $user_account->delete();
    $i++;*/
	  kint($user);
    }
	exit();
  }
}

