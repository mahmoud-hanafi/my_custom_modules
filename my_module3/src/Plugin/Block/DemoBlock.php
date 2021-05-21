<?php

namespace Drupal\my_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * Provides an demo block.
 *
 * @Block(
 *   id = "demo_block",
 *   admin_label = @Translation("Demo Block"),
 *   category = @Translation("My first custom block programmatically")
 * )
 */
class DemoBlock extends BlockBase{
    
    /**
     * {@inheritdoc}
     */
    public function build() {
        $block['content'] = [
            "#markup" => $this->t('It is My First cutom block through custom module!'),
        ];
        return $block;
    }
}  

?>