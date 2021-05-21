<?php

/**
 * @file
 * Contains notification.page.inc.
 *
 * Page callback for Notifications entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Notifications templates.
 *
 * Default template: notification.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_notification(array &$variables) {
  // Fetch DefaultEntity Entity Object.
  $notification = $variables['elements']['#notification'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
