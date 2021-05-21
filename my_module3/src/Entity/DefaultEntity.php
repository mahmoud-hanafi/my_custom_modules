<?php

namespace Drupal\my_module\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Notifications entity.
 *
 * @ingroup my_module
 *
 * @ContentEntityType(
 *   id = "notification",
 *   label = @Translation("Notifications"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\my_module\DefaultEntityListBuilder",
 *     "views_data" = "Drupal\my_module\Entity\DefaultEntityViewsData",
 *     "translation" = "Drupal\my_module\DefaultEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\my_module\Form\DefaultEntityForm",
 *       "add" = "Drupal\my_module\Form\DefaultEntityForm",
 *       "edit" = "Drupal\my_module\Form\DefaultEntityForm",
 *       "delete" = "Drupal\my_module\Form\DefaultEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\my_module\DefaultEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\my_module\DefaultEntityAccessControlHandler",
 *   },
 *   base_table = "notification",
 *   data_table = "notification_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer notifications entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/notification/{notification}",
 *     "add-form" = "/admin/structure/notification/add",
 *     "edit-form" = "/admin/structure/notification/{notification}/edit",
 *     "delete-form" = "/admin/structure/notification/{notification}/delete",
 *     "collection" = "/admin/structure/notification",
 *   },
 *   field_ui_base_route = "notification.settings"
 * )
 */
class DefaultEntity extends ContentEntityBase implements DefaultEntityInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Notifications entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status']->setDescription(t('A boolean indicating whether the Notifications is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
