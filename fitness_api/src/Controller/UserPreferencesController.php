<?php

namespace Drupal\fitness_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Drupal\fitness_entities\Entity\UserPreferencesEntity;
use Drupal\Component\Serialization\Json;
use Drupal\rest\ModifiedResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserPreferencesController.
 */
class UserPreferencesController extends ControllerBase {

  /**
   * Updatepreferences.
   *
   * @return string
   *   Return Hello string.
   */
  public function updatePreferences(Request $request) {
    $request_content = Json::decode(\Drupal::request()->getContent());
    $account = \Drupal::currentUser();

    // Check if User ID not exist.
    if (empty($account->id())) {
      return new ModifiedResourceResponse([
        'message' => 'Invalied user ID for Trainee.',
      ], 400);
    }

    // If empty arrays sent.
    if (empty($request_content) || !is_array($request_content)) {
      return new ModifiedResourceResponse([
        'message' => 'Request is empty.',
      ], 400);
    }

    foreach ($request_content as $preference_item) {
      if (empty($preference_item['id']) || empty($preference_item['value'])) {
        continue;
      }

      $preference_question_id = $preference_item['id'];
      $preference_value = $preference_item['value'];

      $question_object = $this->getQuestion($preference_question_id);
      // If question not found.
      if (empty($question_object)) {
        return new ModifiedResourceResponse([
          'message' => 'Incorrect Question ID.',
        ], 400);
      }

      // If the passed value is not string with text_answer.
      if ($question_object['type'] === 'text_answer' && !is_string($preference_value)) {
        return new ModifiedResourceResponse([
          'message' => 'You must pass a string value for question: ' . $preference_question_id,
        ], 400);
      }

      // Generate Error if answer is not exist in the options
      if ($question_object['type'] !== 'text_answer' && !(count(array_intersect($preference_value, $question_object['options'])) === count($preference_value))) {
        return new ModifiedResourceResponse([
          'message' => 'Incorrect value passed.',
        ], 400);
      }

      if ($question_object['type'] === 'single_answer' && count($preference_value) > 1) {
        return new ModifiedResourceResponse([
        'message' => 'You must pass single value for this question.',
        ], 400);
      }

      $preference_node = $this->getPreferenceItem($preference_question_id, $account->id());

      if ($question_object['type'] === 'text_answer') {
        $preference_node->field_value_text = $preference_value;
      } else {
        $preference_node->field_value_terms = $preference_value;
      }

      $preference_node->save();
    }

    return new JsonResponse([
      'message' => 'Successfully updated the trainee preferences',
    ]);
  }

  /**
   * Load question data Node ID.
   */
  public function getQuestion($id) {
    $question_node = Node::load($id);
    $question_data = [];

    if (empty($question_node) || $question_node->getType() !== 'registration_questions') {
      return false;
    }

    $question_data['id'] = $id;
    $question_data['type'] = $question_node->get('field_rq_type')->value;
    $question_data['required'] = !empty($question_node->get('field_rq_required')->value) ? true : false;
    $question_data['options'] = [];

    if (!empty($question_node->get('field_rq_answers'))) {
      foreach ($question_node->field_rq_answers as $option_item) {

        foreach ($option_item->entity->field_answer_value as $option_term_field) {
          if (!empty($option_term_field->getValue()['target_id'])) {
            $question_data['options'][] = $option_term_field->getValue()['target_id'];
          }
        }
      }
    }

    return $question_data;
  }

  /**
   * Is person exist.
   */
  public function getPreferenceItem($question_id, $user_id) {
    $ids = \Drupal::entityQuery('user_preferences_entity')
      ->condition('field_user', $user_id)
      ->condition('field_question', $question_id)
      ->execute();

    if (count($ids) > 0) {
      $contents = UserPreferencesEntity::loadMultiple($ids);
      $content = array_pop($contents);
      return $content;
    }

    $content = UserPreferencesEntity::create([
      'type' => 'user_preferences_entity',
      'name' => 'User: ' . $user_id . ' Question: ' . $question_id,
      'uid' => $user_id,
      'field_user' => $user_id,
      'field_question' => $question_id
    ]);

    return $content;
  }

}
