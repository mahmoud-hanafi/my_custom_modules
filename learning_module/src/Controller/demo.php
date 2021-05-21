<?php

namespace Drupal\learning_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class demo extends  ControllerBase{
    public function dummy_function() {
        print "dummy data";
        exit();
    }
}
?>