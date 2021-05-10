<?php

namespace Drupal\notes_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Plugin\Field\FieldFormatter\BasicStringFormatter;

/**
 * @FieldFormatter(
 *   id = "notes_formatter",
 *   label = @Translation("Notes formatter"),
 *   field_types = {
 *     "notes"
 *   },
 *   quickedit = {
 *     "editor" = "plain_text"
 *   }
 * )
 */
class NotesFormatter extends BasicStringFormatter {

}
