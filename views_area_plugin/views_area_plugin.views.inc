<?php

/**
* Implements hook_views_data().
*/
function views_area_plugin_views_data() {
$data['views']['my_plugin'] = [
    'title' => t('Views Area Custom Plugin'),
    'help' => t('My plugin description.'),
    'area' => ['id' => 'my_plugin'],
  ];

  return $data;
}
