<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webdesksolution.com/
 * @since      1.0.0
 *
 * @package    My Online Fashion Store
 * @subpackage my-online-fashion-store/MYOFS_Admin
 */
class MYOFS_Admin {

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		//wp_enqueue_style( MYOFS_CODE.'myofs-font-awesome-ui', MYOFS_PUBLIC_CSS_PATH.'font-awesome/css/font-awesome.min.css', array(), MYOFS_VERSION, 'all' );
		
		wp_enqueue_style( MYOFS_CODE.'-font-awesomeui','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), MYOFS_VERSION, 'all' );
		
		wp_enqueue_style( MYOFS_CODE.'-select2-ui', MYOFS_PUBLIC_SELECT2_CSS_PATH.'/select2.min.css', array(), MYOFS_VERSION, 'all' );

		wp_enqueue_style( MYOFS_CODE.'-boostrap-select2-ui', MYOFS_PUBLIC_SELECT2_CSS_PATH.'/select2-bootstrap.min.css', array(), MYOFS_VERSION, 'all' );
		
		wp_enqueue_style( MYOFS_CODE.'-slick-ui', MYOFS_ASSETS_URL.'slick/slick.css', array(), MYOFS_VERSION, 'all' );

		wp_enqueue_style( MYOFS_CODE.'-styles-ui', MYOFS_CSS_PATH.'myofs-styles.css', array(), MYOFS_VERSION, 'all' );

		wp_enqueue_style( MYOFS_CODE.'-responsive-styles-ui', MYOFS_CSS_PATH.'myofs-responsive-styles.css', array(), MYOFS_VERSION, 'all' );
		
		wp_enqueue_style( MYOFS_CODE.'-admin-ui', MYOFS_CSS_PATH.'myofs-admin.css', array(), MYOFS_VERSION, 'all' );
		
		wp_enqueue_style( MYOFS_CODE.'-all-inventory-ui', MYOFS_CSS_PATH.'myofs-all-inventory.css', array(), MYOFS_VERSION, 'all' );

		wp_enqueue_style( MYOFS_CODE.'-sidebar-ui', MYOFS_CSS_PATH.'myofs-sidebar.css', array(), MYOFS_VERSION, 'all' );

		wp_enqueue_style( MYOFS_CODE.'-custom-ui', MYOFS_PUBLIC_CSS_PATH.'myofs-custom.css', array(), MYOFS_VERSION, 'all' );

	}
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		//slick js
        wp_enqueue_script(MYOFS_CODE.'-js-slick', MYOFS_ASSETS_URL.'slick/slick.js', array( 'jquery' ), MYOFS_VERSION, false);

        wp_enqueue_script(MYOFS_CODE.'-js-select2', MYOFS_PUBLIC_SELECT2_JS_PATH.'/select2.full.min.js', array( 'jquery' ), MYOFS_VERSION, false);
        
        wp_enqueue_script(MYOFS_CODE.'-jquery-validate-js', MYOFS_PUBLIC_JS_PATH.'jquery.validate.js', array( 'jquery' ), MYOFS_VERSION, false);
        wp_enqueue_script(MYOFS_CODE.'-jquery-validate-min-js', MYOFS_PUBLIC_JS_PATH.'jquery.validate.min.js', array( 'jquery' ), MYOFS_VERSION, false);
        
        wp_enqueue_script(MYOFS_CODE.'-admin-js', MYOFS_JS_PATH.'myofs-admin.js', array( 'jquery' ), MYOFS_VERSION, false);
        
        wp_enqueue_script(MYOFS_CODE.'-all-inventory-js', MYOFS_JS_PATH.'myofs-all-inventory.js', array( 'jquery' ), false, true );
        
        wp_enqueue_script(MYOFS_CODE.'-my-order-js', MYOFS_JS_PATH.'myofs-my-order.js', array( 'jquery' ), false, true );
		
	}
	/**
	 * Register a custom menu page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public static function myofs_admin_menu(){

		add_menu_page(
	        __( 'My Online Fashion Store', 'my-online-fashion-store' ),
	        __( 'My Online Fashion Store', 'my-online-fashion-store' ),	   
	        'manage_options',     
	        'myofs-all-inventory',
	        array( $this, 'productListPage' ),
			'dashicons-products',
	        10
	    );
	    $get_optdata = get_option('myofs_opt_data');
		if (isset($get_optdata) && !empty($get_optdata)) {
	        add_submenu_page( 
		    	'myofs-all-inventory',
		    	'All Inventory',
		    	'All Inventory',
		    	'manage_options',
		    	'myofs-all-inventory'		    	
		    );
		    add_submenu_page( 
		    	'myofs-all-inventory',
		    	'My Inventory',
		    	'My Inventory',
		    	'manage_options',
		    	'my-inventory',
	        	array( $this, 'menusQueryStringUrl' )     
		    	
		    );
		    add_submenu_page( 
		    	'myofs-all-inventory',
		    	'My Orders',
		    	'My Orders',
		    	'manage_options',
		    	'my-orders',
		        array( $this, 'menusQueryStringUrl' )
		    	
		    );
		    add_submenu_page( 
		    	'myofs-all-inventory',
		    	'Marketing Material',
		    	'Marketing Material',
		    	'manage_options',
		    	'marketing-marterial',
		        array( $this, 'menusQueryStringUrl' )
		    	
		    );
		    add_submenu_page( 
		    	'myofs-all-inventory',
		    	'My Account',
		    	'My Account',
		    	'manage_options',
		    	'my-account',
		        array( $this, 'menusQueryStringUrl' )
		    	
		    );
		     add_submenu_page( 
		    	'myofs-all-inventory',
		    	'Help',
		    	'Help',
		    	'manage_options',
		    	'help',
		        array( $this, 'menusQueryStringUrl' )
		    	
		    );
			add_submenu_page( 
		    	'myofs-all-inventory',
		    	'Returns',
		    	'Returns',
		    	'manage_options',
		    	'returns',
		        array( $this, 'menusQueryStringUrl' )
		    	
		    );
			add_submenu_page( 
		    	'myofs-all-inventory',
		    	'Upgrade & Save',
		    	'Upgrade & Save',
		    	'manage_options',
		    	'upgrade-save',
		        array( $this, 'menusQueryStringUrl' )
		    	
		    );
		    /*add_submenu_page( 
		    	'myofs-all-inventory',
		    	'Activation key',
		    	'Activation key', 
		    	'manage_options',
		    	'myofs-activationkey',
		        array( $this, 'activationKeyPage' )
		    	
		    );*/
		}
	}
	/**
	 * Register a plugin menus urls for the admin area.
	 *
	 * @since    1.0.0
	 */
	public static function menusQueryStringUrl() {
		$page = $_GET['page'];
		switch($page) :      
			case 'my-inventory':
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory&tab=my-inventory' ), admin_url() ) );
				break;
			case 'my-orders':
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory&tab=my-orders' ), admin_url() ) );
				break;
			case 'marketing-marterial':
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory&tab=marketing-marterial' ), admin_url() ) );
				break;
			case 'my-account':
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory&tab=my-account' ), admin_url() ) );
				break;
			case 'help':
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory&tab=help' ), admin_url() ) );
				break;
			case 'returns':
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory&tab=returns' ), admin_url() ) );
				break;
			case 'upgrade-save':
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory&tab=upgrade-save' ), admin_url() ) );
				break;
		  	default:
				wp_safe_redirect( add_query_arg( array( 'page' => 'myofs-all-inventory' ), admin_url() ) );				
			break;
		endswitch;
	}
	/*
	* Set sidebar pages and Activation key for the admin area.
	*/
	public static function productListPage() {
		$get_optdata = get_option('myofs_opt_data');
		if ( isset( $get_optdata ) && !empty( $get_optdata ) ) {
	       	if ( is_file(  MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-menus-page.php' ) )
	       	{
	        	include_once  MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-menus-page.php';            
	        }			
		}else{			
	        if ( is_file(  MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-activation-key-page.php' ) ) {
	        	include_once  MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-activation-key-page.php';      
	        }
		}
		
    }
	/**
	 * Set activation key page for the plugin area.
	 *
	 * @since    1.0.0
	 */
    public static function activationKeyPage() {
        if ( is_file(  MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-activation-key-page.php' ) ) {
        	include_once  MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-activation-key-page.php';      
        }
    }    

}
?>