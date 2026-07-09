<?php

/**
 * WooCommerce Catalog Mode
 * 
 * Converts WooCommerce from transactional to showcase-only mode.
 * Removes: prices, Add to Cart, cart/checkout access, stock display, order emails and redirects myaccount page for non-loggedin visitors.
 * Replaces with: WhatsApp price inquiry button (see whatsapp-price-query.php)
 * 
 * Deployed via: Code Snippets plugin
 */

// Hide prices from all visitors
add_filter('woocommerce_get_price_html', '__return_empty_string');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

// Remove Add to Cart buttons everywhere
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

// Redirect cart and checkout to homepage
add_action('template_redirect', function () {
  if (is_cart() || is_checkout()) {
    wp_redirect(home_url());
    exit;
  }
});

// Disable all WooCommerce emails
add_filter('woocommerce_email_enabled_new_order', '__return_false');
add_filter('woocommerce_email_enabled_customer_processing_order', '__return_false');
add_filter('woocommerce_email_enabled_customer_completed_order', '__return_false');
add_filter('woocommerce_email_enabled_customer_invoice', '__return_false');

// Remove stock display
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_filter('woocommerce_get_availability', '__return_empty_array');

// Redirect My Account page to homepage for non-logged-in visitors
add_action('template_redirect', function () {
  if (is_account_page() && !is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
  }
});
