<?php

if (!defined('ABSPATH')) { // If Wordpress didn't load this file, don't run it (Prevents accessing this file via direct URL.).
  exit;
}

add_filter('woocommerce_currency_symbol', 'change_dollar_symbol', 10, 2);

function change_dollar_symbol($currency_symbol, $currency)
{
  if ($currency == 'USD') {
    $currency_symbol = sanitize_text_field('U$'); // Prevent possible dynamic field in the future.
  }
  return esc_html($currency_symbol);
}
