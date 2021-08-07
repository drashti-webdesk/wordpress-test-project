<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    my-online-fashion-store
 * @subpackage my-online-fashion-store/includes
 * @author     WebDesk Solution <sales@webdesksolution.com>
 */
class MYOFS_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;	
		$table_name = $wpdb->prefix .MYOFS_DB_TABLE;
		$create_table = "CREATE TABLE IF NOT EXISTS `".$table_name."` (
				`id` INT( 20 ) NOT NULL AUTO_INCREMENT,
				`wc_product_id` INT( 20 ),			
				`status` INT( 20 ),
				 PRIMARY KEY ( `id` )
			) ENGINE = MYISAM";
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($create_table);
		}
		$charset_collate = $wpdb->get_charset_collate();

		update_option( 'myofs_db_version', MYOFS_VERSION );
		update_option( 'myofs_db_installed', 1);
		update_option( 'myofs_activation_redirect', wp_get_current_user()->ID );
		$activate_key_array = array(
			'license_email' => 'test@gmail.com',
			'license_key'   => 'as3ds3fdf'
		);
		$activate_serialize = maybe_serialize($activate_key_array);
		update_option( 'myofs_activation_keys', $activate_serialize );
		
		// Don't do redirects when multiple plugins are bulk activated
		if ( ( isset( $_REQUEST['action'] ) && 'activate-selected' === $_REQUEST['action'] ) &&
			( isset( $_POST['checked'] ) && count( $_POST['checked'] ) > 1 ) ) 
		{
			return;
		}
	}
}