<?php
namespace Drupal\learning_module\Controller;



use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class printCustomBlock extends ControllerBase{

  public function displayBlock() {
    //$block = \Drupal::entityManager()->getStorage('block')->load('demo_block');
    $block = \Drupal\block\Entity\Block::load('demoblock');
    $variables['block_output'] = \Drupal::entityTypeManager()
    ->getViewBuilder('block')
    ->view($block);

    return [
      '#theme' => 'my_template',
      '#demo_blok' => $variables['block_output'],
    ];
  }
}

?>