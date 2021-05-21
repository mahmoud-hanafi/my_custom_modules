<?php

namespace Drupal\fitness_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;


/**
 * Returns responses for Fitness API routes.
 */
class FitnessApiController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function traineeHome() {
    $response = [];
    $account = \Drupal::currentUser();
    $user_id = $account->id();

    // Get Items Categories.
    $view = Views::getView('api_homepage_category_types');
    $render_array = $view->buildRenderable('plan_items', [$user_id]);
    $rendered = \Drupal::service('renderer')->renderRoot($render_array);
    $response['categories'] = json_decode($rendered);

    // Get Trainee Profile.
    $view = Views::getView('api_user_profile');
    $render_array = $view->buildRenderable('trainee_profile', [$user_id]);
    $rendered = \Drupal::service('renderer')->renderRoot($render_array);
    $profile = json_decode($rendered);
    $profile[0]->answered_all_questions = $this->answeredRequiredQuestions($user_id);
    $response['profile'] = $profile;

    return new JsonResponse([$response]);
  }

  public function answeredRequiredQuestions($user_id) {
    $required_questions_ids = \Drupal::entityQuery('node')
    ->condition('status', 1)
    ->condition('type', 'registration_questions')
    ->condition('field_rq_required', 1)
    ->execute();

    $answered_questions_ids = \Drupal::entityQuery('user_preferences_entity')
    ->condition('field_user', $user_id)
    ->condition('field_question', $required_questions_ids, 'IN')
    ->execute();

    if (count($answered_questions_ids) >= count($required_questions_ids)) {
      return 1;
    }

    return 0;
  }

}
