<?php
/*
Plugin Name: WPHobby WooCommerce Mini Cart
Plugin URI: https://wphobby.com/downloads/wphobby-woocommerce-mini-cart/
Description: Add Mini Cart on your Woocommerce Website.
Version: 1.0.0
Author: wphobby
Author URI: http://wphobby.com
*/

if ( ! defined( 'ABSPATH' ) ) {
   exit;
} // Exit if accessed directly

// Load plugin text domian
load_plugin_textdomain( 'wphobby-woo-mini-cart', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// Set constants
define('WHMC_DIR', plugin_dir_path(__FILE__));
define('WHMC_URL', plugin_dir_url(__FILE__));
define('WHMC_OPTIONS', 'whmc_general_data');
define('WHMC_VERSION', '1.0.0');

if( ! function_exists( 'whmc_install_woocommerce_admin_notice' ) ) {
   /**
    * Display an admin notice if woocommerce is deactivated
    *
    * @since 1.0.0
    * @return void
    * @use admin_notices hooks
    */
   function whmc_install_woocommerce_admin_notice() { ?>
      <div class="error">
         <p><?php _e( 'WPHobby WooCommerce Mini Cart is enabled but not effective. It requires WooCommerce in order to work.', 'wphobby-woo-mini-cart' ); ?></p>
      </div>
      <?php
   }
}

if( ! function_exists( 'whmc_install' ) ){
   function whmc_install() {

      if ( ! function_exists( 'WC' ) ) {
         add_action( 'admin_notices', 'whmc_install_woocommerce_admin_notice' );
      }else{
         // Include files
         require_once('includes/whmc_init.php');
         require_once('includes/whmc_tools.php');
         require_once('includes/whmc_admin.php');

         // Initalize this plugin
         $WHMC = new WHMC();
         // When admin active this plugin
         register_activation_hook(__FILE__, array(&$WHMC, 'activate'));
         // When admin deactive this plugin
         register_deactivation_hook(__FILE__, array(&$WHMC, 'deactivate'));

         // Run the plugins initialization method
         add_action('init', array(&$WHMC, 'initialize'));

      }
   }
}

add_action( 'plugins_loaded', 'whmc_install', 11 );
?>