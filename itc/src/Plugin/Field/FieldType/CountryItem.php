<?php

namespace Drupal\itc\Plugin\Field\FieldType;


use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;


/**
 * @FieldType(
 *     id = "country",
 *     label = @Translation("Country"),
 *     default_formatter = "country_default",
 *     default_widget = "country_default"
 * )
 */
class CountryItem extends FieldItemBase {

    /**
     * Defines field item properties.
     *
     * Properties that are required to constitute a valid, non-empty item should
     * be denoted with \Drupal\Core\TypedData\DataDefinition::setRequired().
     *
     * @return \Drupal\Core\TypedData\DataDefinitionInterface[]
     *   An array of property definitions of contained properties, keyed by
     *   property name.
     *
     * @see \Drupal\Core\Field\BaseFieldDefinition
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
    {
        $properties['value'] = DataDefinition::create('string')
            ->setLabel(t('Country'));
        return $properties;
    }

    /**
     * Returns the schema for the field.
     *
     * This method is static because the field schema information is needed on
     * creation of the field. FieldItemInterface objects instantiated at that
     * time are not reliable as field settings might be missing.
     *
     * Computed fields having no schema should return an empty array.
     *
     * @param \Drupal\Core\Field\FieldStorageDefinitionInterface $field_definition
     *   The field definition.
     *
     * @return array
     *   An empty array if there is no schema, or an associative array with the
     *   following key/value pairs:
     *   - columns: An array of Schema API column specifications, keyed by column
     *     name. The columns need to be a subset of the properties defined in
     *     propertyDefinitions(). The 'not null' property is ignored if present,
     *     as it is determined automatically by the storage controller depending
     *     on the table layout and the property definitions. It is recommended to
     *     avoid having the column definitions depend on field settings when
     *     possible. No assumptions should be made on how storage engines
     *     internally use the original column name to structure their storage.
     *   - unique keys: (optional) An array of Schema API unique key definitions.
     *     Only columns that appear in the 'columns' array are allowed.
     *   - indexes: (optional) An array of Schema API index definitions. Only
     *     columns that appear in the 'columns' array are allowed. Those indexes
     *     will be used as default indexes. Field definitions can specify
     *     additional indexes or, at their own risk, modify the default indexes
     *     specified by the field-type module. Some storage engines might not
     *     support indexes.
     *   - foreign keys: (optional) An array of Schema API foreign key
     *     definitions. Note, however, that the field data is not necessarily
     *     stored in SQL. Also, the possible usage is limited, as you cannot
     *     specify another field as related, only existing SQL tables,
     *     such as {taxonomy_term_data}.
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition)
    {
        return [
            'columns' => [
                'value' => [
                    'type' => 'varchar',
                    'description' => t('Country'),
                    'length' => 2,
                    'not null' => FALSE,
                ],
            ],
            'indexes' => [
                'value' => ['value'],
            ]
        ];
    }
}
