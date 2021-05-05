<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This file executes user crud functionality
 *
 * This file is used to crud user data
 *
 * @link       Ahmed-Buubiye
 * @since      1.0.0
 *
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/admin/partials
 */
 global $user_id;
 global $error_string;
 
 /*
 * the name of the database for storing data
 *
 * @since    1.0.0
 * @access   public
 * @var      string
 */
 $mpbp_db_name = 'wp_mpbp_service_providers';
 /*
 * stores user fields in an array.
 */
 $user_data_raw = [
    'user_pass',            
    'user_login',            
    'user_nicename',        
    'user_url',              
    'user_email',            
    'display_name',         
    'nickname',            
    'first_name',           
    'last_name',             
    'description',           
    'user_registered',     
    'show_admin_bar_front',  
    'role',
    'pictures',
	'number',
	'type',
	'birthdate',
	'distance_moved',
	'total_distance_moved',
	'services'	
];

 if($_GET['action'] == 'add_new' || $_GET['action'] == 'edit'){
	 if(!empty($_POST['user_login'])){
 $userdata = array(
    'ID'                    => $_POST['user_id'],
    'user_pass'             => $_POST['user_pass'],   //(string) The plain-text user password.
    'user_login'            => $_POST['user_login'],   //(string) The user's login username.
    'user_nicename'         => $_POST['user_nicename'],   //(string) The URL-friendly user name.
    'user_url'              => $_POST['user_url'],   //(string) The user URL.
    'user_email'            => $_POST['user_email'],  //(string) The user email address.
    'display_name'          => $_POST['display_name'],  //(string) The user's display name. Default is the user's username.
    'nickname'              => $_POST['nickname'],   //(string) The user's nickname. Default is the user's username.
    'first_name'            => $_POST['first_name'],   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
    'last_name'             => $_POST['last_name'],   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
    'description'           => $_POST['description'],   //(string) The user's biographical description.
    'user_registered'       => $_POST['user_registered'],   //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
    'show_admin_bar_front'  => $_POST['show_admin_bar_front'],   //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
    'role'                  => $_POST['role']  //(string) User's role.
);
	
/*
* stores the id of the user
*
* @since    1.0.0
* @access   public
* @var      string    $plugin_name    The ID of the user.
*/ 
$user_id = wp_insert_user( $userdata ) ;
 
// On success.
if ( is_wp_error( $user_id ) ) {
    $error_string = $user_id->get_error_message();
    echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
}else{
	echo "User created : ". $user_id;
}
	 }
 }

/*
* requires for oop functionality
*
* @since    1.0.0
* @access   public
*/
 require_once plugin_dir_path(dirname(__FILE__) ).'class-booking-plugin-crud-actions.php';

/*
 * initializes the "mpbp_crud" class
 * @since    1.0.0
 * @access   public
 * @var      string    
 */
 $mpbp_crud_printer = new mpbp_crud();
 
 /*
  * The below array stores the names of the "inputs" which will be 
  * rendered by "mpbp_render_services" function.
  *
  * @since    1.0.0
  * @access   public
  * @type     array
 */
 $mpbp_crud_printer->mpbp_admin = [
	'pictures',
	'number',
	'type',
	'birthdate',
	'distance_moved',
	'total_distance_moved',
	'services'
];

/*
* stores the logic for input validation
*
* @since    1.0.0
* @access   public
*/
 $mpbp_crud_printer->mpbp_admin_validation_logic = [
	!empty($_POST['pictures']),
	!empty($_POST['number']),
	!empty($_POST['type']),
	!empty($_POST['birthdate']),
	!empty($_POST['distance_moved']),
	!empty($_POST['total_distance_moved']),
	!empty($_POST['services'])
	];
	
/*
* stores the data after it is validated
* This function validates data for "update" action and "add_new" action
*
* @since    1.0.0
* @access   public
*/
$mpbp_insert = $mpbp_crud_printer->mpbp_validate_admin();
print_r($mpbp_insert);

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
if(isset($_POST['type']) && $_GET['action'] == 'edit'){
	$mpbp_crud_printer->mpbp_admin_update(
	$mpbp_db_name,
	 array(
	  'pictures' => $_POST['pictures'],
	  'number' => $_POST['number'],
	  'type' => $_POST['type'],
	  'birthdate' => $_POST['birthdate'],
	  'distance_moved' => $_POST['distance_moved'],
	  'total_distance_moved' => $_POST['total_distance_moved'],
	  'services' => $_POST['services'],
	  ), 
	  array(
	  'id' => $_POST['id']
	  ), 
	$_GET['action'] == 'edit',
	'Successfully updated user #'.$_POST['id'], 
	'There is error! Please check check the values.'
	);
}

/*
*******
* fetch data from db $mpbp_db_name, this data will be displayed on the "input" elements 
*
* @since    1.0.0
* @access   public
*******
*/
 if($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
	  $mpbp_crud_printer->mpbp_display_admin_data(
	  "id",
	  $_GET['id'], 
	  $mpbp_db_name
	  ); 
 }

$array_fetch = $mpbp_crud_printer->mpbp_fetched_data_results;
print_r($array_fetch);
/*
********
* Deletes the selected row(s) in db ($mpbp_db_name)
*******
*
* since 1.0.0
* $section string to specify which page's data is deleted eg servies or orders
* $page string to specify the page we are in
*/
if($_GET['action'] == 'delete'){
$mpbp_crud_printer->mpbp_delete_admin_data(
     $mpbp_db_name,
	 $_GET['id'], 
	 'mpbp_verify_service_delete', 
	 'user', 
	 'successfully deleted ', 
	 get_site_url() .'/wp-admin/admin.php?page=all_service_provider',
	 '/wp-admin/admin.php?page=all_service_provider'
	 );
}

 /*
 * This function renders the form
 * mpbp_render_services($data, $url, $action, $h1Text, $method, $id, $buttonName)
 * @since    1.0.0
 * @access   public
 */
 global $wpdb;
 if($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
 $mpbp_verify_if_data_exists = $wpdb->get_results("SELECT * FROM ". $mpbp_db_name ." WHERE  id = ". $_GET['id'] ."");
 }
 $mpbp_print_data;
 
$user_info; 
$extracted_id;

if($_GET['action'] == 'add_new'){
	$user_info = get_userdata($user_id);
}else if($_GET['action'] == 'edit' || 'delete'){
	$extracted_id = $wpdb->get_results('SELECT user_id FROM '. $mpbp_db_name . ' WHERE id = '. $_GET["id"] .'');
	$user_info = get_userdata($extracted_id[0]->user_id);
}  

 if($wpdb->num_rows > 0 || $_GET['action'] == 'add_new'){
	 for($x = 0; $x < sizeof($user_data_raw); $x++){
	 //user exists
	 /*
	 * if user is inserted the below if statement will print out user data with different fields
	 */
	 if($_GET['action'] == 'add_new' && isset($user_id) != 0 && $x < sizeof($user_data_raw) - sizeof($mpbp_crud_printer->mpbp_admin)){
	     $userdata_row_index = $user_data_raw[$x];
		 $mpbp_print_data[$x] = $user_info->$userdata_row_index;
	 }else if($_GET['action'] == 'edit' | $_GET['action'] == 'delete' && $x < sizeof($user_data_raw) - sizeof($mpbp_crud_printer->mpbp_admin)){
		 $userdata_row_index = $user_data_raw[$x];
		 $mpbp_print_data[$x]= $user_info->$userdata_row_index;
	 }else if($_GET['action'] == 'add_new' && isset($_POST[$mpbp_crud_printer->mpbp_admin[$x]]) != ''){
		 $mpbp_print_data[$x] = $_POST[$mpbp_crud_printer->mpbp_admin[$x]];
	 } elseif($_GET['action'] == 'add_new' && isset($_POST[$mpbp_crud_printer->mpbp_admin[$x]]) == ''){
		 $mpbp_print_data[$x] = '';
	 } elseif($_GET['action'] == 'edit' | $_GET['action'] == 'delete'){
		 $n = $user_data_raw[$x];
		 $mpbp_print_data[$x] = $array_fetch[$n];
	}
	}
 }else{
	 echo 'The user you inserted doesn\'t exist! <a href="'. get_site_url() .'/wp-admin/admin.php?page=all_service_provider"><button> Search again </button></a>'; 
	 die();
 }
 
 /*
  * The below function rendders the input for submitting data to database
  *
  * @since    1.0.0
  * @access   public
  */
 echo $mpbp_crud_printer->mpbp_render_services(
 [ 
 ['id', 'input', 'number', 'mpbp_id', 'ID', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['user_pass', 'input', 'text', 'user_pass', 'User Password', $mpbp_print_data[0], ''],
 ['user_login', 'input', 'text', 'user_login', 'User Login', $mpbp_print_data[1], ''],
 ['user_nicename', 'input', 'text', 'user_nicename', $mpbp_print_data[2], ''],
 ['user_url', 'input', 'text', 'user_url', 'User Url', $mpbp_print_data[3], ''],
 ['user_email', 'input', 'email', 'user_email', 'User Email', $mpbp_print_data[4], ''],
 ['display_name', 'input', 'text', 'display_name', 'Display Name', $mpbp_print_data[5], ''],
 ['nickname', 'input', 'text', 'nickname', 'Nickname', $mpbp_print_data[6], ''],
 ['first_name', 'input', 'text', 'first_name', 'First Name', $mpbp_print_data[7], ''],
 ['last_name', 'input', 'text', 'last_name', 'Last Name', $mpbp_print_data[8], ''],
 ['description', 'input', 'text', 'description', 'Description', $mpbp_print_data[9], ''],
 ['user_registered', 'input', 'text', 'user_registered', 'User Registered', $mpbp_print_data[10], ''],
 ['show_admin_bar_front', 'input', 'text', 'show_admin-bar_front', 'Show Admin Bar Front', $mpbp_print_data[11], ''],
 ['role', 'input', 'text', 'role', 'Role', $mpbp_print_data[12], ''], 
 ['user_id', 'input', 'number', 'mpbp_user_id', 'User ID', $extracted_id[0]->user_id, ''],
 ['pictures', 'img', 'text', "mpbp_pictures" , 'Pictures', $mpbp_print_data[13] , ''],
 ['type', 'input', 'text', 'mpbp_type', 'Type', $mpbp_print_data[14], ''],
 ["number", 'input', 'text', 'mpbp_number', 'Number', $mpbp_print_data[15], ''],
 ["birthdate", "input", "text", "mpbp_birthdate", "Birth Date", $mpbp_print_data[16], ""],
 ["distance_moved", "input", "text", "mpbp_distance_moved", "Distance Moved", $mpbp_print_data[17], ""],
 ["total_distance_moved", "input", "text", "mpbp_total_distance_moved", "Total Distance Moved", $mpbp_print_data[18], ""],
 ["services", "input", "text", "mpbp_services", "Services", $mpbp_print_data[19], ""],
 ["", "input", "submit", "button", "", "Submit", ""]
 ], 
  ($_GET['action'] == 'edit')? '/wp-admin/admin.php?page=users&action=edit' : "", 
  '', 
  'Add New Service Provider!', 
  'POST', 
  'mpbp_add_new', 
  ($_GET['action'] == 'edit')? 'Add New' : '');
  
  /*
  * The below function stores inserted 
  *
  * @since    1.0.0
  * @access   public
  */
  global $error_string;
  if(!empty($_POST['type']) && $_GET['action'] == 'add_new' && $error_string == ''){
	  global $user_id;
  $mpbp_crud_printer->mpbp_insert_to_db(
  $mpbp_db_name, 
  array(
	'pictures' => $mpbp_insert[1],
	'type' => $mpbp_insert[2],
	'number' => $mpbp_insert[3],
	'birthdate' => $mpbp_insert[4],
	'distance_moved' => $mpbp_insert[5],
	'total_distance_moved' => $mpbp_insert[6],
	'services' => $mpbp_insert[7],
  ),
  array('%s', '%s', '%s', '%s', '%s', '%s', '%s'),
  'pictures', 
  'Succes! inserted data.',
  '/wp-admin/admin.php?page=service_provider');
  }else{
	  echo $error_string;
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

			$table_name = $wpdb->prefix . 'mpbp_service_providers';
			
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE $table_name (
				id int(11) NOT NULL AUTO_INCREMENT,
							user_id varchar (255),
							pictures varchar (255),
							type varchar (255),
							date_created varchar (255),
							number varchar (1000),
							birthdate varchar (255),
							distance_moved varchar (255),
							total_distance_moved varchar (1000),
							services varchar (250),
							PRIMARY KEY (id)					
							) $charset_collate; ";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( 'mpbp_service_db_version', $mpbp_service_db_version );
		}
		
		create_mpbp_services_db_table();
		
*/

?>
