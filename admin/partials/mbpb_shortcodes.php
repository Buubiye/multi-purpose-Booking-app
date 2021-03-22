<?php 
/*
*--------------------------------------------------------------------
* this section works on shortcodes and it will be exported to a different file
*/
   function mpbp_orders_func(){
	   require_once('admin\partials\orders-admin-display.php');
        return 'hello world, this is my first shortcode';
   }  
   
   //add a service shortcode
   function mpbp_services_shortcode( $atts = [], $content = null, $tags = '' ){
	   $s = shortcode_atts(array(
	   'id' => '',
	   'number'=> '',
	   'category' => ''
	   ), $atts );
	   
	  /* //extract the ids from the services from dbtable
	   global $wpdb;
	   $ids = 'WHERE id IN ('. trim(json_encode($s['id']), '[]') .')' | "";
	   $get_data = $wpdb->get_results('SELECT * FROM wp_mpbpservices2'. $ids;
	   
	   //create a loop which prints out the services in a gallery form
	   $mpbp_number_of_products = sizeof($get_data) | 10;
	   for($i = 0; $i < $mpbp_number_of_products; $i++){
		   echo '<div style="float: left">
		         
		   ';
		   
	   }*/
	   require_once plugin_dir_path(dirname(__FILE__)).'multi-purpose-Booking-app\admin\class-booking-plugin-listings.php';
$mpbp_service_listing = new mpbp_data_listing();
  $mpbp_service_listing->mpbp_db_table =  'wp_mpbpservices2';
  $mpbp_service_listing->mpbp_services_results_per_page = 5;
  $mpbp_service_listing->mpbp_listing_title = '<h1>Services</h1>';
  $mpbp_service_listing->mpbp_listing_button = 'Add New';
  $mpbp_service_listing->mpbp_listing_button_url = '/index.php/services/?';
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
   
  return $mpbp_service_listing->mpbp_render_listing(); 

   }
   
   function mpbp_service_page(){
	   return require_once plugin_dir_path(dirname(__FILE__)).'multi-purpose-Booking-app\admin\partials\booking-plugin-admin-display.php';
   }
   /* register shortcodes */
   function add_mpbp_shorcodes(){
	    add_shortcode( 'services', 'mpbp_services_shortcode' );
		add_shortcode( 'service_page', 'mpbp_service_page' );
		add_shortcode( 'mpbp_orders', 'mpbp_orders_func' );
   }
   add_action('init', 'add_mpbp_shorcodes');