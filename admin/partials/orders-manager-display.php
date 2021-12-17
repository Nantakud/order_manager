<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    orders_manager
 * @subpackage orders_manager/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h1 class="cnc-title">List of Orders</h1>

<?php
    $current_user = wp_get_current_user(  );
    $roles = $current_user->roles;
    if(in_array('boh',$roles,true)){
        do_action( 'cnc_display_orders_boh' );
    } else {
        do_action( 'cnc_display_orders_foh' );
    }
   
?>
