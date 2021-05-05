<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

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
  $mpbp_service_listing->mpbp_db_table =  'wp_mpbpservices2';
  $mpbp_service_listing->mpbp_services_results_per_page = 5;
  $mpbp_service_listing->mpbp_listing_title = '<h1>Services</h1>';
  $mpbp_service_listing->mpbp_listing_button = 'Add New';
  $mpbp_service_listing->mpbp_listing_button_url = '/wp-admin/admin.php?page=Services&';
  $mpbp_service_listing->mpbp_items = 'Services';
  $mpbp_service_listing->mpbp_page_name = 'all_services';
  $mpbp_service_listing->mpbp_listing_url = '/wp-admin/admin.php?page=all_services&order=';
  $mpbp_service_listing->mpbp_listing_td = ["pictures", "name", "category", "quantity", "status"];
  $mpbp_service_listing->mpbp_listing_td_data;
  $mpbp_service_listing->mpbp_search_columns = ["id", "name"];
  /*
  *
  */
  $mpbp_service_listing->mpbp_listing_th = ["", "Pictures", "Name", "Category", "Quantity", "Status"];
  $mpbp_service_listing->mpbp_listing_th_data = ['<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>'];
   
  $mpbp_service_listing->mpbp_render_listing(); 


