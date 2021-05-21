<?php

namespace Drupal\my_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class fun_handling_page extends ControllerBase{
    public function test(){
        return array(
            '#title' => 'Hello World!',
            '#markup' => 'Here is some content dddd.',
        );
    }
}

?>