<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    orders_manager
 * @subpackage orders_manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    orders_manager
 * @subpackage orders_manager/public
 * @author     Your Name <email@example.com>
 */
class orders_manager_Public {

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
	 * @param      string    $orders_manager       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $orders_manager, $version ) {

		$this->orders_manager = $orders_manager;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->orders_manager, plugin_dir_url( __FILE__ ) . 'css/orders-manager-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->orders_manager, plugin_dir_url( __FILE__ ) . 'js/orders-manager-public.js', array( 'jquery' ), $this->version, false );

	}

	public function receive_complain(){
		if($_POST['note']){
			$order = wc_get_order($_POST['id']);
			$order -> add_order_note($_POST['note'], false, true);
			$new_url = add_query_arg('success',1,$_SERVER['REQUEST_URI']);
			echo '<script> location.replace("'.$new_url.'"); </script>';  // to avoid resubmission during page refresh
		}

		if($_GET['complain']){
		$current_url = $_SERVER['REQUEST_URI'];
			$url = substr($current_url,0,stripos($current_url,'?')); //return the URL without GET attibutes
			echo '<form id="complain_form" action="'.$url.'" method="POST" style="margin:30px 0px 30px 0px">';
			echo 	'<textarea placeholder="Have your say..." row="5" cols="50" name="note"></textarea>';
			echo 	'<input type="hidden" name="id" value="'.$_GET['order'].'">';
			echo 	'<input type="submit" value="Send">'; 
			echo '</form>';
			unset($_GET['complain']);
			unset($_GET['order']);
		} else if($_GET['success']){
			echo '<p style="text-align: center">Thanks for contacting us! We will be in touch asap</p>';
		}
	}


	function add_my_account_my_orders_note_button( $actions, $order ) {
    $action_slug = 'complain';
	
	$new_url = add_query_arg( array(
		'complain' => '1',
		'order' => $order->get_id(),
	), $order->get_view_order_url() );

    $actions[$action_slug] = array(
		'url' => $new_url,
        'name' => 'Send a Note',
    );
    return $actions;
}
}
