<?php

namespace Drupal\views_area_plugin\Plugin\views\area;

use Drupal\views\Annotation\ViewsArea;
use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Provides two links to the same view
 * on the different pages.
 *
 * Class MyArea
 * @package Drupal\views_area_plugin\Plugin\views\area
 *
 * @ViewsArea("my_plugin")
 */
class MyArea extends AreaPluginBase {

  public function render($empty = FALSE) {

    $current_path = \Drupal::service('path.current')->getPath();
    
    $nid = 0;
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
    }


    return [
      '#theme' => 'input_range_template',
      '#test_var' => $current_path,
      '#test_new' => $nid,
      '#attached' => [
        'library' => [
          'views_area_plugin/views_area_plugin_library',
        ],
      ]
    ];
  }
}
