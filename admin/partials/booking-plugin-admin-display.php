<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       Ahmed-Buubiye
 * @since      1.0.0
 *
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/admin/partials
 */
 
 echo '<h1> Dashboard </h1>';
 
 // get all orders
 
 global $wpdb;
 $get_all_orders = $wpdb->get_results('SELECT * FROM wp_mpbp_orders');
 echo 'The Total Number of Orders are '. sizeof($get_all_orders) . ' Orders.';
 
?>
