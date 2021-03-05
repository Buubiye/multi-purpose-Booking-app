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
 
 require_once plugin_dir_path(dirname(__FILE__) ).'class-booking-plugin-crud-actions.php';

/*
 * initializes the "mpbp_crud" class
 */
 $mpbp_crud_printer = new mpbp_crud();
 /*
 *
 */
 $mpbp_crud_printer->mpbp_admin = [
    "date",
	"client_id",
	"service_provider_id",
	"duration",
	"client_location",
	"gps_coordinates",
	"price",
	"rating",
	"status",
	"extra_info"
];

/*
* stores the logic for input validation
*/
 $mpbp_crud_printer->mpbp_admin_validation_logic = [
	!empty($_POST["date"]),
	!empty($_POST["client_id"]),
	!empty($_POST["service_provider_id"]),
	!empty($_POST["duration"]),
	!empty($_POST["client_location"]),
	!empty($_POST["gps_coordinates"]),
	!empty($_POST["price"]),
	!empty($_POST["rating"]),
	!empty($_POST["status"]),
	!empty($_POST["extra_info"])
	];
	
/*
* stores the data after it is validated
*/
$mpbp_insert = $mpbp_crud_printer->mpbp_validate_admin();
print_r($mpbp_insert);
/*
*******
* This function validates data for "update" action and "add_new" action
*
* @since    1.0.0
* @access   public
*******
*/
//print_r($mpbp_crud_printer->mpbp_validate_admin());

/*
*******
* update data the selected row from db(wp_mpbpadmin2 )
*
* @since    1.0.0
* @access   public 
* $d string fetch id
* $type array stores the value types of the data eg. %s, %d e.t.c
* $success string to print out the success message
* $error string to print out error messages
*******
*/
if(isset($_POST['name'])){
	$mpbp_crud_printer->mpbp_admin_update(
	'wp_mpbp_orders',
	 array(
	  "date" => $_POST['date'],
	  "client_id" => $_POST['client_id'],
	  "service_provider_id" => $_POST['service_provider_id'],
	  "duration" => $_POST['duration'],
	  "client_location" => $_POST['client_location'],
	  "gps_coordinates" => $_POST['gps_coordinates'],
	  "price" => $_POST['price'],
	  "rating" => $_POST['rating'],
	  "status" => $_POST['status'],
	  "extra_info" => $_POST['extra_info']
	  ), 
	  array(
	  'id' => $_POST['id']
	  ), 
	$_GET['action'] == 'edit',
	'Successfully updated order #'.$_POST['id'], 
	'There is error! Please check check the values.'
	);
}

/*
*******
* fetch data from db(wp_mpbpadmin2), this data will be displayed on the "input" elements 
*******
*/
 if($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
	  $mpbp_crud_printer->mpbp_display_admin_data(
	  "id",
	  $_GET['id'], 
	  'wp_mpbp_orders'
	  ); 
 }

$array_fetch = $mpbp_crud_printer->mpbp_fetched_data_results;
print_r($array_fetch);

/*
*******
* inserts new values to the database(wp_mpbpadmin2 )
*******
*/
//mpbp_insert_to_db($sql, $isset, $success);

/*
********
* Deletes the selected row(s) in db(wp_mpbpadmin2)
*******
*
* since 1.0.0
* $section string to specify which page's data is deleted eg servies or orders
* $page string to specify the page we are in
*/
if($_GET['action'] == 'delete'){
$mpbp_crud_printer->mpbp_delete_admin_data(
     "wp_mpbp_orders",
	 $_GET['id'], 
	 'mpbp_verify_service_delete', 
	 'order', 
	 'successfully deleted ', 
	 get_site_url() .'/wp-admin/admin.php?page=orders'
	 );
}

//['name', 'element', 'type', 'class' , 'placeholder', 'value', 'options']
//mpbp_printout_inputs($name, $element, $type, $class , $placeholder, $value, $options);

/* 
* renders the inputs in respective order 
*/
//mpbp_render_services($data, $url, $action, $h1Text, $method, $id, $buttonName)
 /*
 * This function renders the form
 * mpbp_render_services($data, $url, $action, $h1Text, $method, $id, $buttonName)
 */
 global $wpdb;
 if($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
 $mpbp_verify_if_data_exists = $wpdb->get_results("SELECT * FROM wp_mpbp_orders WHERE  id = ". $_GET['id'] ."");
 }
 $mpbp_print_data;

 if($wpdb->num_rows > 0 || $_GET['action'] == 'add_new'){
	 for($x = 0; $x < sizeof($mpbp_crud_printer->mpbp_admin); $x++){
	 //user exists
	 if($_GET['action'] == 'add_new' && isset($_POST[$mpbp_crud_printer->mpbp_admin[$x]]) != ''){
		 $mpbp_print_data[$x] = $_POST[$mpbp_crud_printer->mpbp_admin[$x]];
	 } elseif($_GET['action'] == 'add_new' && isset($_POST[$mpbp_crud_printer->mpbp_admin[$x]]) == ''){
		 $mpbp_print_data[$x] = '';
	 } elseif($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
		 $mpbp_print_data[$x] = $array_fetch[$mpbp_crud_printer->mpbp_admin[$x]];
	}
	}
 }else{
	 echo 'The order you inserted doesn\'t exist! <a href="'. get_site_url() .'/wp-admin/admin.php?page=orders"><button> Search again </button></a>'; 
	 die();
 }

 echo $mpbp_crud_printer->mpbp_render_services(
 [
 ['id', 'input', 'number', 'mpbp_id', 'ID', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['date', 'input', 'text', "mpbp_date" , 'Date', $mpbp_print_data[0] , ''],
 ['client_id', 'input', 'text', 'mpbp_client_id', 'Client ID', $mpbp_print_data[1], ''],
 ['service_provider_id', 'input', 'number', 'mpbp_service_provider_id', 'service_provider_id', $mpbp_print_data[2], '' ],
 ["duration", 'input', 'text', 'mpbp_duration', 'duration', $mpbp_print_data[3], ''],
 ["client_location", "input", "text", "mpbp_s_client_location", "client_location", $mpbp_print_data[4], ""],
 ["gps_coordinates", 'input', 'text', 'mpbp_gps_coordinates' , 'gps_coordinates', '', ''],
 ["price", 'input', 'text', 'mpbp_price' , 'price', $mpbp_print_data[6], ''],
 ["rating", 'input', 'text', 'mpbp_rating' , 'rating', $mpbp_print_data[7], ''],
 ["status", 'input', 'text', 'mpbp_status' , 'Status', '', ''],
 ["extra_info", 'input', 'text', 'mpbp_extra_info' , 'Extra Info', $mpbp_print_data[9], ''],
 ["", "input", "submit", "button", "", "Submit", ""]
 ], 
  ($_GET['action'] == 'edit')? '/wp-admin/admin.php?page=Services&action=edit' : "", 
  '', 
  'Add New Order!', 
  'POST', 
  'mpbp_add_new', 
  ($_GET['action'] == 'edit')? 'Add New' : '');
  
  /*
  * The below function stores inserted 
  */
  if(!empty($_POST['name']) && $_GET['action'] == 'add_new'){
  $mpbp_crud_printer->mpbp_insert_to_db(
  'wp_mpbp_orders',
  array(
    "date" => $mpbp_insert[0],
	"client_id" => $mpbp_insert[1],
	"service_provider_id" => $mpbp_insert[2],
	"duration" => $mpbp_insert[3],
	"client_location" => $mpbp_insert[4],
	"gps_coordinates" => $mpbp_insert[5],
	"price" => $mpbp_insert[6],
	"rating" => $mpbp_insert[7],
	"status" => $mpbp_insert[8],
	"extra_info" => $mpbp_insert[9] 
  ),
  array('%s', '%d', '%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s'),
  'date', 
  'Succes! inserted data.');
  }


/*
* 
* this is the db function, it will be stored in the plugin activation file
*
*/
/*global $mpbp_service_db_version;
		$mpbp_service_db_version = '1.0';
function create_mpbp_services_db_table() {
			global $wpdb;
			global $mpbp_service_db_version;

			$table_name = $wpdb->prefix . 'mpbp_orders';
			
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
				id int(11) NOT NULL AUTO_INCREMENT,
				            date varchar (255),
							client_id varchar (255),
							service_provider_id varchar (255),
							duration varchar (255),
							client_location varchar (255),
							gps_coordinates varchar (1000),
							price varchar (255),
							rating varchar (255),
							status varchar (255),
							extra_info varchar (255),
							PRIMARY KEY (id)					
							) $charset_collate; ";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( 'mpbp_service_db_version', $mpbp_service_db_version );
		}
		
		create_mpbp_services_db_table();
*/