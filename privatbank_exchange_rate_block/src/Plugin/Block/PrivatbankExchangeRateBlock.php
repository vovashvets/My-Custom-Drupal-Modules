<?php

namespace Drupal\privatbank_exchange_rate_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal;

/**
 * Provides a 'Privatbank exchange rate' block.
 *
 * @Block(
 *   id = "privatbank_exchange_rate_block",
 *   admin_label = @Translation("Privatbank exchange rate")
 * )
 */
class PrivatbankExchangeRateBlock extends BlockBase {

  public function build() {
    /*
     * Cash exchange rate
     */
    $response_cash = file_get_contents("https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5");
    $response_cash = json_decode($response_cash, true);
    unset($response_cash[3]);

    foreach($response_cash as $key => $value) {
      unset($response_cash[$key]['base_ccy']);
    }

    /*
     * Non-cash exchange rate
     */
    $response_not_cash = file_get_contents("https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11");
    $response_not_cash = json_decode($response_not_cash, true);
    unset($response_not_cash[3]);

    foreach($response_not_cash as $key => $value) {
      unset($response_not_cash[$key]['base_ccy']);
    }

    /*
     * Render array
     * Max-age = 3h.
     */
    return array(
      '#title' => $this->t('Privatbank exchange rate'),
      '#theme' =>  'custom_template',
      '#response_cash' => $response_cash,
      '#response_not_cash' => $response_not_cash,
      '#attached' => [
        'library' => [
          'privatbank_exchange_rate_block/privatbank_exchange_rate_block_lib',
        ],
      ],
      '#cache' => [
        'max-age' => 10800,
      ]
    );
  }
}

