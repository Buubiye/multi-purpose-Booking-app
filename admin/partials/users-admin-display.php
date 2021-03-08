<?php
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
 if(isset($_POST['user_login'])){
 $userdata = array(
    'user_pass'             => '',   //(string) The plain-text user password.
    'user_login'            => '',   //(string) The user's login username.
    'user_nicename'         => '',   //(string) The URL-friendly user name.
    'user_url'              => '',   //(string) The user URL.
    'user_email'            => '',   //(string) The user email address.
    'display_name'          => '',   //(string) The user's display name. Default is the user's username.
    'nickname'              => '',   //(string) The user's nickname. Default is the user's username.
    'first_name'            => '',   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
    'last_name'             => '',   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
    'description'           => '',   //(string) The user's biographical description.
    'user_registered'       => '',   //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
    'show_admin_bar_front'  => '',   //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
    'role'                  => '',   //(string) User's role.
 
);
 $website = "http://example.com";
$userdata = array(
    'user_login' =>  'login_name',
    'user_url'   =>  $website,
    'user_pass'  =>  NULL // When creating an user, `user_pass` is expected.
);
 
$user_id = wp_insert_user( $userdata ) ;
 
// On success.
if ( ! is_wp_error( $user_id ) ) {
    echo "User created : ". $user_id;
}

 }


 require_once plugin_dir_path(dirname(__FILE__) ).'class-booking-plugin-crud-actions.php';

/*
 * initializes the "mpbp_crud" class
 */
 $mpbp_crud_printer = new mpbp_crud();
 /*
 *
 */
 $mpbp_crud_printer->mpbp_admin = [
	'user_id',
	'pictures',
	'type',
	'date_created',
	'number',
	'birthdate'
];

/*
* stores the logic for input validation
*/
 $mpbp_crud_printer->mpbp_admin_validation_logic = [
	!empty($_POST['user_id']),
	!empty($_POST['pictures']),
	!empty($_POST['type']),
	!empty($_POST['date_created']),
	!empty($_POST['number']),
	!empty($_POST['birthdate'])
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
if(isset($_POST['user_id'])){
	$mpbp_crud_printer->mpbp_admin_update(
	'wp_mpbp_users',
	 array(
	  'User_id' => $_POST['User_id'],
	  'pictures' => $_POST['pictures'],
	  'type' => $_POST['type'],
	  'date_created' => $_POST['date_created'],
	  'number' => $_POST['number'],
	  'birthdate' => $_POST['birthdate']
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
* fetch data from db(wp_mpbpadmin2), this data will be displayed on the "input" elements 
*******
*/
 if($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
	  $mpbp_crud_printer->mpbp_display_admin_data(
	  "id",
	  $_GET['id'], 
	  'wp_mpbp_users'
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
     "wp_mpbp_users",
	 $_GET['id'], 
	 'mpbp_verify_service_delete', 
	 'user', 
	 'successfully deleted ', 
	 get_site_url() .'/wp-admin/admin.php?page=users',
	 '/wp-admin/admin.php?page=users'
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
 $mpbp_verify_if_data_exists = $wpdb->get_results("SELECT * FROM wp_mpbp_users WHERE  id = ". $_GET['id'] ."");
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
	 echo 'The user you inserted doesn\'t exist! <a href="'. get_site_url() .'/wp-admin/admin.php?page=users"><button> Search again </button></a>'; 
	 die();
 }

 echo $mpbp_crud_printer->mpbp_render_services(
 [ 
 ['user_pass', 'input', 'text', 'user_pass', 'User Password', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['user_login', 'input', 'text', 'user_login', 'User Login', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['user_nicename', 'input', 'text', 'user_nicename', 'User Nicename', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['user_url', 'input', 'text', 'user_url', 'User Url', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['user_email', 'input', 'email', 'user_email', 'User Email', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['display_name', 'input', 'text', 'display_name', 'Display Name', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['nickname', 'input', 'text', 'nickname', 'Nickname', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['first_name', 'input', 'text', 'first_name', 'First Name', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['last_name', 'input', 'text', 'last_name', 'Last Name', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['description', 'input', 'text', 'description', 'Description', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['user_registered', 'input', 'text', 'user_registered', 'User Registered', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['show_admin_bar_front', 'input', 'text', 'show_admin-bar_front', 'Show Admin Bar Front', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['role', 'input', 'text', 'role', 'Role', (isset($_GET['id']))? $_GET['id'] : '', ''], 
 
 ['user_id', 'input', 'number', 'mpbp_user_id', 'User ID', (isset($_GET['id']))? $_GET['id'] : '', ''],
 ['pictures', 'img', 'text', "mpbp_pictures" , 'Pictures', $mpbp_print_data[0] , ''],
 ['type', 'input', 'text', 'mpbp_type', 'Type', $mpbp_print_data[1], ''],
 ['date_created', 'input', 'text', 'mpbp_date_created', 'Date Created', $mpbp_print_data[2], '' ],
 ["number", 'input', 'text', 'mpbp_number', 'Number', $mpbp_print_data[3], ''],
 ["birthdate", "input", "text", "mpbp_birthdate", "Birth Date", $mpbp_print_data[4], ""],
 ["", "input", "submit", "button", "", "Submit", ""]
 ], 
  ($_GET['action'] == 'edit')? '/wp-admin/admin.php?page=users&action=edit' : "", 
  '', 
  'Add New User!', 
  'POST', 
  'mpbp_add_new', 
  ($_GET['action'] == 'edit')? 'Add New' : '');
  
  /*
  * The below function stores inserted 
  */
  if(!empty($_POST['date']) && $_GET['action'] == 'add_new'){
  $mpbp_crud_printer->mpbp_insert_to_db(
  'wp_mpbp_users', 
  array(
    'user_id' => $mpbp_insert[0],
	'pictures' => $mpbp_insert[1],
	'type' => $mpbp_insert[2],
	'date_created' => $mpbp_insert[3],
	'number' => $mpbp_insert[4],
	'birthdate' => $mpbp_insert[5]
  ),
  array('%d', '%s', '%s', '%s', '%s', '%s'),
  'pictures', 
  'Succes! inserted data.',
  '/wp-admin/admin.php?page=orders_crud');
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

			$table_name = $wpdb->prefix . 'mpbp_users';
			
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE $table_name (
				id int(11) NOT NULL AUTO_INCREMENT,
							user_id varchar (255),
							pictures varchar (255),
							type varchar (255),
							date_created varchar (255),
							number varchar (1000),
							birthdate varchar (255),
							PRIMARY KEY (id)					
							) $charset_collate; ";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( 'mpbp_service_db_version', $mpbp_service_db_version );
		}
		
		create_mpbp_services_db_table();
		*/


?>