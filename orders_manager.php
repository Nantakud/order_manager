<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              
 * @since             1.0.0
 * @package           orders_manager
 *
 * @wordpress-plugin
 * Plugin Name:       Orders Manager
 * Plugin URI:        
 * Description:       Allows FOH and BOH to better visualise and handle the orders
 * Version:           1.0.0
 * Author:            Francesco Vacca & team
 * Author URI:        
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       orders-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'orders_manager_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-orders-manager-activator.php
 */
function activate_orders_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-orders-manager-activator.php';
	orders_manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-orders-manager-deactivator.php
 */
function deactivate_orders_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-orders-manager-deactivator.php';
	orders_manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_orders_manager' );
register_deactivation_hook( __FILE__, 'deactivate_orders_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-orders-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_orders_manager() {

	$plugin = new orders_manager();
	$plugin->run();

}
run_orders_manager();
