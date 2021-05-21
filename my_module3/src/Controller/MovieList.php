<?php
namespace Drupal\my_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Component\Serialization\Json;

class MovieList extends  ControllerBase{
  public function overview(){

  
	$content['overlay_link'] = array(
		'#type' => 'link',
		'#title' => $this->t('Add movie'),
		'#url' => Url::fromRoute('node.add', ['node_type' => 'course']),
		'#attributes' => [
			'class' => ['use-ajax'],
			'data-dialog-type' => 'modal',
			'data-dialog-options' => Json::encode([
				'width' => 700,
			]),
		],
	);

	return $content;
}
}

