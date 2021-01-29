<?php

namespace Drupal\month_views_filter\Plugin\views\filter;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\FilterPluginBase;

/**
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("FILTER_ID")
 */
class MonthFilter extends FilterPluginBase {

  public function adminSummary() {
    $output = $this->t('Filter by Month');
    return $output;
  }

  protected function valueForm(&$form, FormStateInterface $form_state) {
    $form['value']['#tree'] = TRUE;

    if ($exposed = $form_state->get('exposed')) {
      $identifier = $this->options['expose']['identifier'];
    }

    $user_input = $form_state->getUserInput();

    $form['value']['filter_month'] = [
      '#type' => 'textfield',
      '#attributes' => [
        'placeholder' => 'mm-yyyy',
        'data-toggle' => 'datepicker'
      ],
    ];

    if ($exposed && !isset($user_input[$identifier]['filter_month'])) {
      $user_input[$identifier]['filter_month'] = $this->value['filter_month'];
    }
  }

  public function buildExposedForm(&$form, FormStateInterface $form_state) {
    if (empty($this->options['exposed'])) {
      return;
    }
    parent::buildExposedForm($form, $form_state);
  }

  public function acceptExposedInput($input) {
    if (empty($this->options['exposed'])) {
      return TRUE;
    }
    $value = &$input[$this->options['expose']['identifier']];
    $rc = parent::acceptExposedInput($input);
    if (!empty($value['filter_month'])) {
      $rc = TRUE;
    }
    return $rc;
  }

  public function query() {
    $this->ensureMyTable();

    if ($this->value['filter_month']) {
      $user_date = $this->value['filter_month'];
      $pre_format_date = explode('-', $user_date);
      $post_format_date = $pre_format_date[1].'-'.$pre_format_date[0];

      if (strtotime($post_format_date)) {
        $start = new DrupalDateTime($post_format_date);
        $end = clone $start;
        $end->add(new \DateInterval('P1M'));
        // Build correct time format for db
        $start_value = $start->format('Y-m-d\TH:i:s');
        $end_value = $end->format('Y-m-d\TH:i:s');
        // Build query to db
        $condition = <<<WHERE
        "field_date_value" < '$end_value'
        AND
        "field_date_end_value" >= '$start_value'
WHERE;

        $this->query->addWhereExpression($this->options['group'], $condition);
      }
    }
  }
}
