<?php
/**
 * My Online Fashion Store
 *
 * @package       	My Online Fashion Store
 * @author        	webdesk solution
 * @copyright     	2021 webdesk solution
 * @license       	GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:   	My Online Fashion Store
 * Plugin URI:    	https://webdesksolution.com/
 * Description:   	Online fashion store addon helps you product store in woocommerce. 
 * Version:       	1.0.0
 * Requires at least: 5.2
 * Requires PHP:  	7.2
 * Author:        	webdesk solution
 * Author URI:    	https://webdesksolution.com/
 * Text Domain:   	my-online-fashion-store
 * License:       	GPL v2 or later
 * License URI:   	http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:     /languages
 */

// If this file is called directly, abort.
if(!defined( 'ABSPATH' )) exit;
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	$getpluginopt = maybe_unserialize(get_option('_site_transient_update_plugins'));
	$version = $getpluginopt->checked['woocommerce/woocommerce.php'];
    if ( version_compare( $version, '5.3.0', '<' ) ) {
       function admin_version_notice_error() {
		    $class   = 'notice notice-error';
		    $message = 'WooCommerce version not comfortable with My Online Fashion Store plugin please install/update  woocommerce plugin upto 5.3.0 version';
		 
		    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
		}
		add_action( 'admin_notices', 'admin_version_notice_error' );
    } else {
        if (!function_exists('is_woocommerce_active')){
			function is_woocommerce_active(){
			    $active_plugins = (array) get_option('active_plugins', array());
			    if(is_multisite()){
				   $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
			    }
			    return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins) || class_exists('WooCommerce');
			}
		}
		if(is_woocommerce_active()) {
			/*
			* config.php file load all the define plugin constants 
			*/
			require_once(plugin_dir_path( __FILE__ ) . 'config.php');

			/**
			* The code that runs during plugin activation.
			* This action is documented in includes/class-myofs-activator.php
			*/
			require_once MYOFS_PLUGIN_INCLUDE_PATH . 'class-myofs-activator.php';
			register_activation_hook( __FILE__, array( 'MYOFS_Activator', 'activate' ) );

			/**
			* The code that runs during plugin deactivation.
			* This action is documented in includes/class-myofs-deactivator.php
			*/
			require_once MYOFS_PLUGIN_INCLUDE_PATH . 'class-myofs-deactivator.php';
			register_deactivation_hook( __FILE__, array('MYOFS_Deactivator','deactivate') );
			/*
			* Redirects the user after plugin activation
			*/
			add_action( 'admin_init', 'MYOFS_after_activation_redirect');
			function MYOFS_after_activation_redirect() {		
				if (is_user_logged_in() &&  intval( get_option( 'myofs_activation_redirect', false ) ) === wp_get_current_user()->ID ) {
					delete_option( 'myofs_activation_redirect' );
					wp_safe_redirect( admin_url( MYOFS_PLUGIN_URL ) );
					exit;
				}
			}	
			
			/**
			 * The core plugin class that is used to define internationalization,
			 * admin-specific hooks, and public-facing site hooks.
			 */
			require MYOFS_PLUGIN_INCLUDE_PATH . 'class-myofs-core-functions.php';

			/**
			 * Begins execution of the plugin.
			 *
			 * Since everything within the plugin is registered via hooks,
			 * then kicking off the plugin from this point in the file does
			 * not affect the page life cycle.
			 *
			 * @since    1.0.0
			 */
			function run_my_online_fashion_store() {

				$plugin = new my_online_fashion_store();
				$plugin->run();

			}
			run_my_online_fashion_store();
		}else{
			add_action( 'admin_notices', 'admin_notice__error' );
		} 
   	}
}else{
	add_action( 'admin_notices', 'admin_notice__error' );
}
function admin_notice__error() {
    $class = 'notice notice-error';
    $message = 'woocommerce plugin is required for my online fashion store plugin.so please install/active WooCommerce plugin';
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}
?>