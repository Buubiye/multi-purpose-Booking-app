<?php
/**
 * This file executes orders crud functionality
 *
 * This file is used to allow users to insert, update, delete and search orders data.
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
  *
  * @since    1.0.0
  * @access   public
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
    "date",
	"client_id",
	"service_id",
	"service_provider_id",
	"duration",
	"client_location",
	"gps_coordinates",
	"price",
	"rating",
	"status",
	"extra_info",
	"quantity",
	"coupon"
];

/*
* stores the logic for input validation
*
* @since    1.0.0
* @access   public
*/
 $mpbp_crud_printer->mpbp_admin_validation_logic = [
	!empty($_POST["date"]),
	!empty($_POST["client_id"]),
	!empty($_POST["service_id"]),
	!empty($_POST["service_provider_id"]),
	!empty($_POST["duration"]),
	!empty($_POST["client_location"]),
	!empty($_POST["gps_coordinates"]),
	!empty($_POST["price"]),
	!empty($_POST["rating"]),
	!empty($_POST["status"]),
	!empty($_POST["extra_info"]),
	!empty($_POST["quantity"]),
	!empty($_POST["coupon"])
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
if(isset($_POST['name'])){
	$mpbp_crud_printer->mpbp_admin_update(
	'wp_mpbp_orders',
	 array(
	  "date" => $_POST['date'],
	  "client_id" => $_POST['client_id'],
	  "service_id" => $_POST['service_id'],
	  "service_provider_id" => $_POST['service_provider_id'],
	  "duration" => $_POST['duration'],
	  "client_location" => $_POST['client_location'],
	  "gps_coordinates" => $_POST['gps_coordinates'],
	  "price" => $_POST['price'],
	  "rating" => $_POST['rating'],
	  "status" => $_POST['status'],
	  "extra_info" => $_POST['extra_info'],
	  "quantity" => $_POST['quantity'],
	  "coupon" => $_POST['coupon']
	  ), 
	  array(
	  'id' => $_POST['id']
	  ), 
	$_GET['action'] == 'edit' & $_GET['process'] != 'order',
	'Successfully updated order #'.$_POST['id'], 
	'There is error! Please check check the values.'
	);
}

/*
*******
* fetch data from db(wp_mpbpadmin2), this data will be displayed on the "input" elements 
*
* @since    1.0.0
* @access   public
*******
*/
 if($_GET['action'] == 'edit' && $_GET['process'] != 'order' | $_GET['action'] == 'delete'){
	  $mpbp_crud_printer->mpbp_display_admin_data(
	  "id",
	  $_GET['id'], 
	  'wp_mpbp_orders'
	  ); 
 }

$array_fetch = $mpbp_crud_printer->mpbp_fetched_data_results;
print_r($array_fetch);

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
	 get_site_url() .'/wp-admin/admin.php?page=orders_crud',
	 '/wp-admin/admin.php?page=orders'
	 );
}

 /*
 * This function renders the form
 * mpbp_render_services($data, $url, $action, $h1Text, $method, $id, $buttonName)
 */
 global $wpdb;
 if($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
 $mpbp_verify_if_data_exists = $wpdb->get_results("SELECT * FROM wp_mpbp_orders WHERE  id = ". $_GET['id'] ."");
 }
 $mpbp_print_data;

 if($wpdb->num_rows > 0 || $_GET['action'] == 'add_new' | $_GET['process'] == 'order'){
	 for($x = 0; $x < sizeof($mpbp_crud_printer->mpbp_admin); $x++){
	 //user exists
	 if($_GET['action'] == 'add_new' | $_GET['process'] == 'order' && isset($_POST[$mpbp_crud_printer->mpbp_admin[$x]]) != ''){
		 $mpbp_print_data[$x] = $_POST[$mpbp_crud_printer->mpbp_admin[$x]];
	 } elseif($_GET['action'] == 'add_new' | $_GET['process'] == 'order' && isset($_POST[$mpbp_crud_printer->mpbp_admin[$x]]) == ''){
		 $mpbp_print_data[$x] = '';
	 } elseif($_GET['action'] == 'edit' || $_GET['action'] == 'delete'){
		 $mpbp_print_data[$x] = $array_fetch[$mpbp_crud_printer->mpbp_admin[$x]];
	}
	}
 }else{
	 echo 'The order you inserted doesn\'t exist! <a href="'. get_site_url() .'/wp-admin/admin.php?page=orders"><button> Search again </button></a>'; 
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
 ['date', 'input', 'text', "mpbp_date" , 'Date', $mpbp_print_data[0] , ''],
 ['client_id', 'input', 'text', 'mpbp_client_id', 'Client ID', $mpbp_print_data[1], ''],
 ['service_id', 'input', 'text', 'mpbp_service_id', 'Service ID', $mpbp_print_data[2], ''],
 ['service_provider_id', 'input', 'number', 'mpbp_service_provider_id', 'service_provider_id', $mpbp_print_data[3], '' ],
 ["duration", 'input', 'text', 'mpbp_duration', 'duration', $mpbp_print_data[4], ''],
 ["client_location", "input", "text", "mpbp_s_client_location", "client_location", $mpbp_print_data[5], ""],
 ["gps_coordinates", 'input', 'text', 'mpbp_gps_coordinates' , 'gps_coordinates', $mpbp_print_data[6], ''],
 ["price", 'input', 'text', 'mpbp_price' , 'price', $mpbp_print_data[7], ''],
 ["rating", 'input', 'text', 'mpbp_rating' , 'rating', $mpbp_print_data[8], ''],
 ["status", 'input', 'text', 'mpbp_status' , 'Status', $mpbp_print_data[9], ''],
 ["extra_info", 'input', 'text', 'mpbp_extra_info' , 'Extra Info', $mpbp_print_data[10], ''],
 ["quantity", 'input', 'number', 'mpbp_quantity' , 'quantity', $mpbp_print_data[11], ''],
 ["coupon", 'input', 'text', 'mpbp_coupon' , 'coupon', $mpbp_print_data[12], ''],
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
  *
  * @since    1.0.0
  * @access   public
  */
  if(!empty($_POST['date']) && $_GET['action'] == 'add_new' | $_GET['process'] == 'order'){
  $mpbp_crud_printer->mpbp_insert_to_db(
  'wp_mpbp_orders', 
  array(
    "date" => $mpbp_insert[0],
	"client_id" => $mpbp_insert[1],
	"service_id" => $mpbp_insert[2],
	"service_provider_id" => $mpbp_insert[3],
	"duration" => $mpbp_insert[4],
	"client_location" => $mpbp_insert[5],
	"gps_coordinates" => $mpbp_insert[6],
	"price" => $mpbp_insert[7],
	"rating" => $mpbp_insert[8],
	"status" => $mpbp_insert[9],
	"extra_info" => $mpbp_insert[10],
    "quantity" => $mpbp_insert[11], 
    "coupon" => $mpbp_insert[12] 	
  ),
  array('%s', '%d', '%s', '%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s'),
  'date', 
  'Succes! inserted data.',
  '/wp-admin/admin.php?page=orders_crud');
  }


//------------ !!!!!!!!!!!!!!!!!!!!!!!!!!!!
/*$mpbp_order_values = $_COOKIE['order_values'];
$mpbp_cookie_trimed = trim($mpbp_order_values, 'expires=Fri, 31 Dec 9999 23:59:59 GMT');
$mpbp_cookie_trimed2 = stripslashes($mpbp_cookie_trimed);
$mpbp_cookie_trimed3 = explode(',', $mpbp_cookie_trimed2);
print_r($mpbp_cookie_trimed3[0][1]);
*/
$cookie = $_COOKIE['order_values'];
$cookie = trim($cookie, 'expires=Fri, 31 Dec 9999 23:59:59 GMT');
$cookie = stripslashes($cookie);
//$cookie = rtrim($cookie, "\0");
//$savedCardArray = json_decode($cookie);

//$_POST['service_id'] = $savedCardArray->date;


echo '<p onload="mpbp_create_cookies()" id="json_data">';
print_r($cookie);
echo '</p>';
if($_GET['purchase'] == 'yes'){
 if(isset($_POST['date'])){
		   //cookie array - orders data
			$cookie_value = array(
			   "date" => $_POST['date'],
	           "client_id" => $_POST['client_id'],
	           "service_id" => $_POST['service_id'],
	           "service_provider_id" => $_POST['service_provider_id'],
	           "duration" => $_POST['duration'],
	           "client_location" => $_POST['client_location'],
	           "gps_coordinates" =>$_POST['gps_coordinates'],
	           "price" => $_POST['price'],
	           "rating" => $_POST['rating'],
	           "status" => $_POST['status'],
	           "extra_info" => $_POST['extra_info'],
	           "quantity" => $_POST['quantity'],
	           "coupon" => $_POST['coupon']
			);
			$json = json_encode($cookie_value,JSON_UNESCAPED_SLASHES);
	?>
	<script>
	    // stores cookies of the service ordered
	    document.cookie = 'order_values=' + <?php echo json_encode($json,JSON_UNESCAPED_SLASHES); ?> +'expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/';
		alert('GG my G');
	</script>
	<?php
 }
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
							service_id varchar (255),
							service_provider_id varchar (255),
							quantity varchar (255),
							duration varchar (255),
							coupon varchar (255),
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