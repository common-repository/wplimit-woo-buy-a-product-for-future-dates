<?php 	
/*
Plugin Name: WPLimit Woo Buy a Product for Future Dates
Plugin URL: https://wplimit.com/woo-buy-a-product-for-future-dates
Description: Woo Buy a Product for Future Dates is the strongest plugin to buy a product for future dates
Author: WPLimit
Version: 0.1
Author URI: https://wplimit.com/
Text Domain: wplimit
*/

/**
 * is_plugin_active Handler
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Checking whether woocomerce plugin active or not.
 * Our Plugin will not be activated without this plugin.
 */
if (is_plugin_active('woocommerce/woocommerce.php')) {

	// Set plugin default url.
	define("WPLIMIT_PLUG_URL", plugins_url('/', __FILE__));
	define("WPLIMIT_PLUG_PATH", plugin_dir_path( __FILE__ ));

	require_once( WPLIMIT_PLUG_PATH . 'inc/wplimit-woo-bpfd-main.php');

} else {
	/**
	 * Notice if woocmerce is not activited and force to deactive plugin.
	 */
	 add_action( 'admin_notices', 'wplimit_already_exist_notice' );
	 deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * Callback functions 
 */
function wplimit_already_exist_notice(){
    echo '<div class="error"><p>' . sprintf( __( 'Woo Buy a Product for Future Dates - says "There must be active install of %s to take a flight!.', 'wplimit' ), '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">' . __( 'WooCommerce', 'wplimit' ) . '</a>' ) . '</p></div>';

        if ( isset( $_GET['activate'] ) )
             unset( $_GET['activate'] );  
}