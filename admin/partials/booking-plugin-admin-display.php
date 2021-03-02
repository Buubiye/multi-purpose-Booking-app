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
 if($_GET['action'] == 'edit'){
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
$mpbp_crud_printer->mpbp_delete_admin_data(
     "wp_mpbpservices2",
	 $_GET['id'], 
	 'mpbp_verify_service_delete', 
	 'service', 
	 'successfully deleted ', 
	 get_site_url() .'/wp-admin/admin.php?page=all_services'
	 );


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
 echo $mpbp_crud_printer->mpbp_render_services(
 [
 ['id', 'input', 'number', 'mpbp_id', 'ID', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['name', 'input', 'text', "mpbp_name" , 'Name', 
 ($_GET['action'] == 'edit') ? $array_fetch['name'] : ((isset($_POST['name']))? $_POST['name'] : ""), ''],
 ['description', 'textarea', 'text', 'mpbp_description', 'Description', 
 ($_GET['action'] == 'edit') ? $array_fetch['description'] : ((isset($_POST['description']))? $_POST['description'] : ""), ''],
 ['pictures', 'img', 'text', 'mpbp_pictures', 'Pictures', 
 ($_GET['action'] == 'edit') ? $array_fetch['pictures'] : ((isset($_POST['pictures']))? $_POST['pictures'] : ""), '' ],
 ["price", 'input', 'number', 'mpbp_price', 'Price', 
 ($_GET['action'] == 'edit') ? $array_fetch['price'] : ((isset($_POST['price']))? $_POST['price'] : ""), ''],
 ["date_created", "input", "text", "mpbp_s_date_created", "Date Created", 
 ($_GET['action'] == 'edit') ? $array_fetch['date_created'] : ((isset($_POST['date_created']))? $_POST['date_created'] : ""), ""],
 ["category", 'select', 'text', 'mpbp_category' , 'Category', 
 [($_GET['action'] == 'edit') ? $array_fetch['category'] : ((isset($_POST['category']))? $_POST['category'] : "Select Category"), 
  "Ride Sharing",  
  "Accomodation", 
  "Hotel", 
  "Flight", 
  "Other"], ''],
 ["available_times", 'input', 'text', 'mpbp_available_times' , 'Available Times', 
 ($_GET['action'] == 'edit') ? $array_fetch['available_times'] : ((isset($_POST['available_times']))? $_POST['available_times'] : ""), ''],
 ["quantity", 'input', 'number', 'mpbp_quantity' , 'Quantity', 
 ($_GET['action'] == 'edit') ? $array_fetch['quantity'] : ((isset($_POST['quantity']))? $_POST['quantity'] : ""), ''],
 ["status", 'select', 'text', 'mpbp_status' , 'Status', 
 [($_GET['action'] == 'edit') ? $array_fetch['status'] : ((isset($_POST['status']))? $_POST['status'] : "Select Status"),
 "Available",
 "Not Available"], ''],
 ["extra_info", 'input', 'text', 'mpbp_extra_info' , 'Extra Info', 
 ($_GET['action'] == 'edit') ? $array_fetch['extra_info'] : ((isset($_POST['extra_info']))? $_POST['extra_info'] : ""), ''],
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

