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
 
 // get the average stars for all services 
 
 $get_all_ratings = $wpdb->get_results('SELECT sum(rating) AS totalsum FROM wp_mpbp_orders');
 foreach($get_all_ratings as $result){
	 $get_avarage_ratings = $result->totalsum / sizeof($get_all_orders);
	 echo '<br> The average rating number is '. $get_avarage_ratings;
 }
 
 
 

?>
