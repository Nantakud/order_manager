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

	//add the new plugin link to the side bar
	public function display_admin_page(){
		add_menu_page( 'Orders Manager', 'Orders Manager', 'user_cnc_orders_manager', 'orders-manager',array($this, 'show_admin_Page'), 'dashicons-carrot', 4.0 );
	}

	//link to the html file
	public function show_admin_Page(){
		require_once 'partials/orders-manager-display.php';
	}


	//filter orders according wiht status and print them
	public function display_orders_page_foh(){
		if(isset($_POST['order_id'])){
			$order = wc_get_order($_POST['order_id']);

			if($_POST['delivered']){
				$order->update_status('completed');
			} else if($_POST['edit']){
				$order->update_status('on-hold');
				$url = $order->get_edit_order_url();
 				echo '<script> 
				 		editOrder("'.$url.'");
				</script>';	
			} else if($_POST['hold']){
			    $order->update_status('processing');
			}
		}

		//retrieve from db only orders with the following status
		$statuses = ['arrived','processing','cooking','ready-to-pickup', 'on-hold'];

		foreach($statuses as $status){
			$orders = wc_get_orders( array(
				'post_status'=> $status,
			));
			$this->print_orders_as_table($orders, $status,'foh');
		}
		
	}

	public function display_orders_page_boh(){
		if(isset($_POST['order_id'])){
			$order = wc_get_order($_POST['order_id']);

			if($_POST['started']){
				$order->update_status('cooking');
			} else if($_POST['cooked']){
			    $order->update_status('ready-to-pickup');
			}
		}

		//retrieve from db only orders with the following status
		$statuses = ['processing','cooking','ready-to-pickup', 'on-hold'];

		foreach($statuses as $status){
			$orders = wc_get_orders( array(
				'post_status'=> $status,
			));
			$this->print_orders_as_table($orders, $status, 'boh');
		}
	}

	function print_orders_as_table($orders, $status, $role){
		
		if(! empty($orders)){
			echo '<h3>'.ucwords($status).' Orders </h3>';
			echo '<table class="cnc-table">';
			echo '<tr>
					<th>ID</th>
					<th>Customer</th>
					<th>Items</th>
					<th>Total</th>
					<th>Status</th>
					<th>Action</th>
				</tr>';
			

			foreach($orders as $order){
				$info = [];
				$info['id']  = $order->get_id();
				$user = $order->get_user();
				if($user){
					$info['username'] =	$user->get('user_nicename');
				} else {
					$info['username'] = 'guest';
				}
				$info['items'] = $order->get_items();
				$info['total'] = $order->get_total();
				$status = $order->get_status();
				$info['status'] = $status;
				$this->print_order_as_row($info, $role);
			}
			echo '</table>';
		} 
	}


	function print_order_as_row($info, $role){
		echo '<tr class="'.$info["status"].'">';

		//print order info
		echo '<td>' . $info['id'] . '</td>';
		echo '<td>' . $info['username'] . '</td>';

		echo '<td>';
		foreach($info['items']as $item){
				$quantity = $item->get_quantity();
				$name = $item->get_name();
				echo  $quantity . ' ' .$name. "<br>" ;
				$meta = $item->get_meta('_special_note');
				if(($meta!='')&&($role == 'boh')){
					echo '<span class="cnc-note">'. $meta . '</span>';
				}
			}
		echo  '</td>';
		
		echo '<td>' . $info['total'] . '</td>';
		echo '<td>' . $info['status'] . '</td>';

		//print buttons for actions.
		if($role === 'foh'){
			switch ($info['status'] ){
				case 'arrived':
				$this->print_action($info['id'],'delivered','Delivered');
				break;
			case 'processing':
				$this->print_action($info['id'],'edit','Edit');
				break;
			case 'on-hold':
				$this->print_action($info['id'],'hold','Editing completed');
				break;
			default:
				echo '<td></td>';
			}	
		} else {
			switch ($info['status'] ){
			case 'processing':
				$this->print_action($info['id'],'started','Start Cooking');
				break;
			case 'cooking':
				$this->print_action($info['id'],'cooked','Cooking completed');
				break;
			default:
				echo '<td></td>';
			}
		}
		echo '</tr>';
	}

	function print_action($id,$name_attribute, $button_value ){
		echo'<td class="cnc-action">
						<form action="" method="POST">
							<input type="hidden" 
								name="'.$name_attribute.'" 
								value="1" >
							<input type="hidden" 
								name="order_id" 
								value= '. $id . '>	
							<input type="submit" 
								name="submit" 
								value="'.$button_value.'">
						</form>
					</td>';
	}

}


