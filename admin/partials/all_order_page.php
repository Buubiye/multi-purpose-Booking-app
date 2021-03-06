<?php
/**
 * This file executes order list
 *
 * This file is used to display the list of orders
 *
 * @link       Ahmed-Buubiye
 * @since      1.0.0
 *
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/admin/partials
 */
 $x = ["id", "date"];
 echo implode(',', ["id", "date"]);
require_once plugin_dir_path(dirname(__FILE__)).'class-booking-plugin-listings.php';
/*
* variables needed to be added
* 1. Database table - $mpbp_db_table
* 2. number of rows to be displayed per page - $mpbp_services_results_per_page
* 3. page title - $mpbp_listing_title
* 4. header button name update/add_new - $mpbp_listing_button;
* 5. header button [add_new] url - $mpbp_listing_button_url;
* 6. page name - $mpbp_items
* 7. page name for get request e.g. $_GET['all_services'] - $mpbp_page_name;
* 8. short url when user click next or previous e.g. '/wp-admin/admin.php?page=all_services&order=' - $mpbp_listing_url;
* 9. Table header <th> name array - $mpbp_listing_th;
* 10. Table header <th> data array - $mpbp_listing_th_data;
* 10. Table data <td> array() - $mpbp_listing_td;
*/
$mpbp_service_listing = new mpbp_data_listing();
  $mpbp_service_listing->mpbp_db_table =  'wp_mpbp_orders';
  $mpbp_service_listing->mpbp_services_results_per_page = 5;
  $mpbp_service_listing->mpbp_listing_title = '<h1>Orders</h1>';
  $mpbp_service_listing->mpbp_listing_button = 'Add New';
  $mpbp_service_listing->mpbp_listing_button_url = '/wp-admin/admin.php?page=orders_crud';
  $mpbp_service_listing->mpbp_items = 'Orders';
  $mpbp_service_listing->mpbp_page_name = 'orders';
  $mpbp_service_listing->mpbp_listing_url = '/wp-admin/admin.php?page=orders&order=';
  $mpbp_service_listing->mpbp_listing_td = ["client_id", "client_location", "gps_coordinates", "price", "status"];
  $mpbp_service_listing->mpbp_listing_td_data;
  $mpbp_service_listing->mpbp_search_columns = ["id", "client_location"];
  /*
  *
  */
  $mpbp_service_listing->mpbp_listing_th = ["", "Client ID", "Client location", "GPS Coordinates", "Price", "Status"];
  $mpbp_service_listing->mpbp_listing_th_data = ['<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>'];
   
  $mpbp_service_listing->mpbp_render_listing(); 