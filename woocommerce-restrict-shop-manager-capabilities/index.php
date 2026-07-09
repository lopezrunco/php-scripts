<?php

/**
 * Woocommerce restrict shop manager capabilities
 *  
 * WooCommerce grants Shop Manager role unintended access to theme 
 * settings by default. This snippet removes that access.
 * 
 * Removes: edit_theme_options, switch_themes
 * Reason: Client account uses Shop Manager role — should only 
 * access product/order management, not theme configuration.
 * 
 * Deployed via: Code Snippets plugin
 */


// Wordpress fires user_has_cap every time it checks whether a user has permission to do something. By hooking it, the script intercepts and modifies the result.
// $caps: Array of capabilities the user currently has (This is the parameter to modify).
// $cap: The specific capability being check at this moment (ex: edit_posts).
// $args: Additional context (object ID being accessed, etc).
// $user: The user object being checked.

add_filter('user_has_cap', function ($caps, $_cap, $_args, $user) {
  if (in_array('shop_manager', $user->roles ?? [])) { // Check if shop_manager is in the user's role array. ??[] is a null safety fallback.
    $caps['edit_theme_options'] = false;
    $caps['switch_themes'] = false;
  }
  return $caps;
}, 10, 4); // 10: Normal priority. 4: This functions accepts 4 parameters, required because default filter ony pass 1 parameter, and we need all 4.
