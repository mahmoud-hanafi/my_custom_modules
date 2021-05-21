<?php

namespace Drupal\fitness_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\node\Entity\Node;
use Drupal\Core\Entity\Exception;
use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class UserProfileController.
 */
class UserProfileController extends ControllerBase {

  /**
   * Updateprofile.
   *
   * @return string
   *   Return Hello string.
   */
  public function updateProfile(Request $request) {
    $request_content = Json::decode(\Drupal::request()->getContent());
    $account = \Drupal::currentUser();
    $profileNode = $this->getProfileItem($account);
    $supported_fields = [
      'field_user_profile_arms',
      'field_user_profile_calves',
      'field_user_profile_chest',
      'field_user_profile_height',
      'field_user_profile_hips',
      'field_user_profile_neck',
      'field_user_profile_target_weight',
      'field_user_profile_thighs',
      'field_user_profile_age',
      'field_user_profile_waist',
      'field_user_profile_weight'
    ];

    // Check if User ID not exist.
    if (empty($account->id())) {
      return new ModifiedResourceResponse([
        'message' => 'Invalied user ID for Trainee.',
      ], 400);
    }
    // If Request is not an array.
    if (!is_array($request_content)) {
      return new ModifiedResourceResponse([
        'message' => 'Invalied Request Structure.',
      ], 400);
    }

    if (!(count(array_intersect(array_keys($request_content), $supported_fields)) === count($request_content))) {
      return new ModifiedResourceResponse([
        'message' => 'Invalied Request Structure.',
      ], 400);
    }

    foreach ($request_content as $field_name => $field_value) {
      $profileNode->{$field_name} = $field_value;
    }

    try {
      $profileNode->setNewRevision(TRUE);
      $profileNode->revision_log = 'Updated from the Mobile App.';
      $profileNode->save();
    } catch (Exception $e) {
      \Drupal::logger('fitness_api')->error($e->getMessage());

      return new ModifiedResourceResponse([
        'message' => 'Invalied fields value: ' . $e->getMessage(),
      ], 400);
    }

    return new JsonResponse([
      'message' => 'Successfully updated the trainee profile.',
    ]);
  }

  public function getProfileItem($user) {
    $ids = \Drupal::entityQuery('node')
    ->condition('type', 'user_profile')
    ->condition('field_user', $user->id())
    ->execute();

    if (count($ids) > 0) {
      $contents = Node::loadMultiple($ids);
      $content = array_pop($contents);
      return $content;
    }

    $content = Node::create([
      'type' => 'user_profile',
      'name' => $user->getAccountName() . ' profile',
      'uid' => $user->id(),
      'field_user' => $user->id()
    ]);

    return $content;
  }

}
