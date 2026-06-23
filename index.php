<?php

add_action('woocommerce_single_product_summary', 'add_wapp_btn_to_single_product_page', 99);
function add_wapp_btn_to_single_product_page() {
    render_wapp_price_link('margin: 2rem 0');
}

add_action('woocommerce_after_shop_loop_item', 'add_wapp_btn_to_catalog_pages', 20);
function add_wapp_btn_to_catalog_pages() {
    render_wapp_price_link('margin: 1rem 0; justify-content: center;');
}

function render_wapp_price_link($custom_styles = '') {
    global $product;                                                // Pull the current active global instance array from Woocommerce. contains raw pricing data, naming, identifiers, etc.

    if (!$product) { $product = wc_get_product(get_the_ID()); }     // Safety fallback logic.
    if (!$product) { return; }                                      // If the page loading is not a product record, rececution safely stops.

    $phone_number    = '917042039154';
    $product_name    = $product->get_name();
    $product_url     = get_permalink($product->get_id());
    $message         = sprintf("Hola. Quisiera consultar el precio de %s (%s)", $product_name, $product_url);
    $encoded_message = rawurlencode($message);
    $wapp_url        = "https://wa.me/{$phone_number}?text={$encoded_message}";
    ?>

    <div class="whatsapp-price-query" style="clear: both; display: flex; width: 100%; <?php echo esc_attr($custom_styles); ?>">
        <a href="<?php echo esc_url($wapp_url); ?>" target="_blank" rel="nofollow" style="display: inline-flex; align-items: center; gap: .5rem; text-decoration: none; color: #25d366; font-weight: 700;">
            <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i>    
            <span>Consultar precio</span>
        </a>
    </div>

    <?php
}