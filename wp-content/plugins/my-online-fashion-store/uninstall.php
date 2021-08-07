<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the woocommerce product add ; however, this is the
 * general skeleton and outline for how the file should work.
 *
 *
 * @link       http://webdesksolution.com
 * @since      1.0.0
 *
 * @package    my online fashion store
 */

// If uninstall not called from WordPress, then exit.
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
    global $wpdb;
    
    $table_name = $wpdb->prefix .MYOFS_DB_TABLE;
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
    
    delete_option( 'myofs_db_version' );
    delete_option( 'myofs_activation_redirect' );
    delete_option( 'myofs_activation_keys' );
    delete_option( 'myofs_opt_data' );
	update_option( 'myofs_db_installed', 0 );
