<?php

/**
* @file
* Contains \Drupal\my_module\Plugin\Field\FieldType\RealName.
*/
namespace Drupal\my_module\Plugin\Field\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

class RealName extends FieldItemBase
{
    public static function propertyDefinitions(\Drupal\Core\Field\FieldStorageDefinitionInterface $field_definition){

        $properties['first_name'] = DataDefinition::create('string')->setLabel(t('first_name'));
        $properties['last_name'] = DataDefinition::create('string')->setLabel(t('last_name'));
        return $properties;

    }



    public static function schema(\Drupal\Core\Field\FieldStorageDefinitionInterface $field_definition){

        return array( 

            'columns' => array(
                'first_name' => array(
                    'description' => t('First Name'),
                    'type' => 'varchar',
                    'length' => '255',
                    'not null' => TRUE,
                    'default' => '',
                ),
                'last_name' => array(
                    'description' => t('Last Name'),
                    'type' => 'varchar',
                    'length' => '255',
                    'not null' => TRUE,
                    'default' => '',
                ),
            ),
            'indexes' => array(
                'first_name' => array('first_name');
                'last_name' => array('last_name');
            ), 

        );
    }
}


?>