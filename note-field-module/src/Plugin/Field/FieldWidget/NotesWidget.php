<?php

namespace Drupal\notes_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextareaWidget;

/**
 * @FieldWidget(
 *   id = "notes_widget",
 *   label = @Translation("Notes textarea"),
 *   field_types = {
 *     "notes"
 *   }
 * )
 */
class NotesWidget extends StringTextareaWidget {

}
