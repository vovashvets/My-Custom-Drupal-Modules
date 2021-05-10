<?php

namespace Drupal\notes_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\StringLongItem;
use Drupal\Core\TypedData\DataDefinition;

/**
 * @FieldType(
 *   id = "notes",
 *   label = @Translation("Notes (plain, long)"),
 *   description = @Translation("A field containing a long string value with user id and creation time."),
 *   category = @Translation("Text"),
 *   default_widget = "notes_widget",
 *   default_formatter = "notes_formatter"
 * )
 */
class Notes extends StringLongItem {
  /*
 * This method returns a column with the fields to be saved.
 */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        // List of values that the field will save.
        'value' => [
          'type' => $field_definition->getSetting('case_sensitive') ? 'blob' : 'text',
          'size' => 'big',
          'description' => t('Notes body'),
          'not null' => FALSE,
        ],
        'uid' => [
          'type' => 'int',
          'description' => t('User id'),
          'not null' => FALSE,
        ],
        'created' => [
          'type' => 'int',
          'description' => t('Created at'),
          'not null' => FALSE,
        ]
      ],
      'indexes' => [
        'uid' => ['uid'],
      ]
    ];

  }

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Notes body'));
    $properties['uid'] = DataDefinition::create('integer')
      ->setLabel(t('Created by'));
    $properties['created'] = DataDefinition::create('timestamp')
      ->setLabel(t('Created at'));

    return $properties;
  }

  /*
   *  This method passes the values to the fields
   *  before saving them to the database
   */
  public function preSave() {
    parent::preSave();
    if(!$this->uid) {
      $this->uid = \Drupal::currentUser()->id();
    }
    if(!$this->created) {
      $this->created = \Drupal::time()->getRequestTime();
    }
  }
}

