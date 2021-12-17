<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    orders_manager
 * @subpackage orders_manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    orders_manager
 * @subpackage orders_manager/admin
 * @author     Your Name <email@example.com>
 */
class orders_manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $orders_manager    The ID of this plugin.
	 */
	private $orders_manager;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $orders_manager       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $orders_manager, $version ) {

		$this->orders_manager = $orders_manager;
		$this->version = $version;

	}

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
		 * defined in orders_manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The orders_manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->orders_manager, plugin_dir_url( __FILE__ ) . 'css/orders-manager-admin.css', array(), $this->version, 'all' );

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
		 * defined in orders_manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The orders_manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->orders_manager, plugin_dir_url( __FILE__ ) . 'js/orders-manager-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function display_admin_page(){
		add_menu_page( 'Orders Manager', 'Orders Manager', 'manage_options', 'orders-manager', 'dashicons-carrot', 4.0 );
	}

}
