<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    my-online-fashion-store
 * @subpackage my-online-fashion-store/includes
 * @author     webdesksolution <sale@webdesksolution.com>
 */
class my_online_fashion_store{
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	*/
	public function __construct() {
		$this->load_dependencies();
		$this->define_admin_hooks();
	}
	/**
	 * Load the required dependencies for this plugin.
	 * 
	 * Include the following files that make up the plugin:
	 *
	 * - my_online_fashion_store_Loader. Orchestrates the hooks of the plugin.
	 * - my_online_fashion_store_i18n. Defines internationalization functionality.
	 * - my_online_fashion_store_Admin. Defines all hooks for the admin area.
	 * - my_online_fashion_store_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-api.php';
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-admin-dashboard.php';
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-activation-key.php';
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-all-inventory.php';
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-my-order.php';
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-my-account.php';
		require_once MYOFS_PLUGIN_INCLUDE_PATH.'admin/class-myofs-free-return.php';

		$this->loader = new MYOFS_Loader();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new MYOFS_Admin( $this->get_my_online_fashion_store(), $this->get_version() );

		$this->loader->add_action( 'admin_print_styles', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'myofs_admin_menu' );

		$active_key = new MYOFS_Activation_Key( $this->get_my_online_fashion_store(), $this->get_version() );
		$this->loader->add_action( 'wp_ajax_myofs_activate_keys', $active_key, 'myofs_activate_keys' );
		//$this->loader->add_action( 'wp_ajax_myofs_remove_keys', $active_key, 'myofs_remove_keys' );
		
		$all_inventory = new MYOFS_All_Inventory( $this->get_my_online_fashion_store(), $this->get_version() );
		
		$this->loader->add_action( 'wp_ajax_productdisplay', $all_inventory, 'GetSingleProductData' );
		$this->loader->add_action( 'wp_ajax_gettagcategories', $all_inventory, 'GetTagCatgoryForAddPopup' );
		$this->loader->add_action( 'wp_ajax_productaddtowcstore', $all_inventory, 'addProducTowcStore' );
		$this->loader->add_action( 'wp_ajax_productremovetowcstore', $all_inventory, 'removeProductTowcStore' );
		$this->loader->add_action( 'wp_ajax_checkcombineproduct', $all_inventory, 'checkCombineProducts' );
		//$this->loader->add_action( 'wp_ajax_get_myinventoryproducts', $all_inventory, 'GetMyInventoryProducts' );

		$my_order = new MYOFS_My_Order( $this->get_my_online_fashion_store(), $this->get_version() );
	    $this->loader->add_action( 'wp_ajax_getordersearchdata', $my_order, 'getMyOrderSearchData' );

	    $return_page = new MYOFS_Free_Return( $this->get_my_online_fashion_store(), $this->get_version() );
	    $this->loader->add_action( 'wp_ajax_submitformreturndata', $return_page, 'submitFormReturnData' );

	    $account_page = new MYOFS_My_Account( $this->get_my_online_fashion_store(), $this->get_version() );


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_my_online_fashion_store() {
		return MYOFS_PLUGIN_NAME;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    my_online_fashion_store_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return MYOFS_VERSION;
	}

}

?>