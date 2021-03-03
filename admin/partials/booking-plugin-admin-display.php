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
 
 require_once plugin_dir_path(dirname(__FILE__) ).'class-booking-plugin-crud-actions.php';
 /*
 * initializes the "mpbp_crud" class
 */
 $mpbp_crud_printer = new mpbp_crud();
 /*
 *
 */
 $mpbp_crud_printer->mpbp_admin = [
	"name", 
	"description",
	"pictures",
	"price",
	"date_created",
	"category",
	"available_times",
	"quantity",
	"status",
	"extra_info" 
];

/*
* stores the logic for input validation
*/
 $mpbp_crud_printer->mpbp_admin_validation_logic = [
	!empty($_POST['name']),
	!empty($_POST['description']),
	!empty($_POST['pictures']),
	!empty($_POST['price']),
	!empty($_POST['date_created']),
	!empty($_POST['category']) || isset($_POST['category']) != 'Select Category',
	!empty($_POST['available_times']),
	!empty($_POST['quantity']),
	!empty($_POST['status']) || isset($_POST['status']) != 'Select Status',
	!empty($_POST['extra_info'])
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
	'wp_mpbpservices2',
	 array(
	  'name' => $_POST['name'],
	  'description' => $_POST['description'],
	  'pictures' => $_POST['pictures'],
	  "price" => $_POST['price'],
	  "category" => $_POST['category'],
	  "available_times" => $_POST['available_times'],
	  "quantity" => $_POST['quantity'],
	  "status" => $_POST['status'],
	  "extra_info" => $_POST['extra_info'] 
	  ), 
	  array(
	  'id' => $_POST['id']
	  ), 
	$_GET['action'] == 'edit',
	'Successfully updated service #'.$_POST['id'], 
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
	  'wp_mpbpservices2'
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
     "wp_mpbpservices2",
	 $_GET['id'], 
	 'mpbp_verify_service_delete', 
	 'service', 
	 'successfully deleted ', 
	 get_site_url() .'/wp-admin/admin.php?page=all_services'
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
 $mpbp_verify_if_data_exists = $wpdb->get_results("SELECT * FROM wp_mpbpservices2 WHERE  id = ". $_GET['id'] ."");
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
	 echo 'The user you inserted doesn\'t exist! <a href="'. get_site_url() .'/wp-admin/admin.php?page=all_services"><button> Search again </button></a>'; 
	 die();
 }

 echo $mpbp_crud_printer->mpbp_render_services(
 [
 ['id', 'input', 'number', 'mpbp_id', 'ID', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['name', 'input', 'text', "mpbp_name" , 'Name', $mpbp_print_data[0] , ''],
 ['description', 'textarea', 'text', 'mpbp_description', 'Description', $mpbp_print_data[1], ''],
 ['pictures', 'img', 'text', 'mpbp_pictures', 'Pictures', $mpbp_print_data[2], '' ],
 ["price", 'input', 'number', 'mpbp_price', 'Price', $mpbp_print_data[3], ''],
 ["date_created", "input", "text", "mpbp_s_date_created", "Date Created", $mpbp_print_data[4], ""],
 ["category", 'select', 'text', 'mpbp_category' , 'Category', 
 [($mpbp_print_data[5] != "" ) ? $mpbp_print_data[5] : "Select Category", 
  "Ride Sharing",  
  "Accomodation", 
  "Hotel", 
  "Flight", 
  "Other"], ''],
 ["available_times", 'input', 'text', 'mpbp_available_times' , 'Available Times', $mpbp_print_data[6], ''],
 ["quantity", 'input', 'number', 'mpbp_quantity' , 'Quantity', $mpbp_print_data[7], ''],
 ["status", 'select', 'text', 'mpbp_status' , 'Status', 
 [($mpbp_print_data[8] != '') ? $mpbp_print_data[8] : "Select Status",
 "Available",
 "Not Available"], ''],
 ["extra_info", 'input', 'text', 'mpbp_extra_info' , 'Extra Info', $mpbp_print_data[9], ''],
 ["", "input", "submit", "button", "", "Submit", ""]], 
  ($_GET['action'] == 'edit')? '/wp-admin/admin.php?page=Services&action=edit' : "", 
  '', 
  'Add New My G!', 
  'POST', 
  'mpbp_add_new', 
  ($_GET['action'] == 'edit')? 'Add New' : '');
  
  /*
  * The below function stores inserted 
  */
  if(!empty($_POST['name']) && $_GET['action'] == 'add_new'){
  $mpbp_crud_printer->mpbp_insert_to_db(
  'wp_mpbpservices2',
  array(
  'name' => $mpbp_insert[0],
  'description' => $mpbp_insert[1],
  'pictures' => $mpbp_insert[2],
  "price" => $mpbp_insert[3],
  "date_created" => $mpbp_insert[4],
  "category" => $mpbp_insert[5],
  "available_times" => $mpbp_insert[6],
  "quantity" => $mpbp_insert[7],
  "status" => $mpbp_insert[8],
  "extra_info" => $mpbp_insert[9] 
  ),
  array('%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d', '%s', '%s'),
  'name', 
  'Succes! inserted data.');
  }

?>

