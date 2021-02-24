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
 
 class Fruit {
  public $name;
  public function go(){
  for($i = 0; $i<5; $i++){
    $this->name[$i] = "hello". $i;
  }
   if($this->name != '') {return $this->name;}
  }
}
$apple = new Fruit();
 //$h = $apple->name; 
 //echo $h[0];
 
 require_once plugin_dir_path(dirname(__FILE__) ).'class-booking-plugin-crud-actions.php';
 
 $mpbp_crud_printer = new mpbp_crud();
 //print_r($mpbp_crud_printer->mpbp_admin_data);
 $mpbp_crud_printer->mpbp_admin = [
	"name", 
	"description",
	"pictures"
];
 $mpbp_crud_printer->mpbp_admin_validation_logic = [
	!empty($_POST['name']),
	!empty($_POST['description']),
	!empty($_POST['pictures'])
	];
$mpbp_insert = $mpbp_crud_printer->mpbp_validate_admin();
 $sql = ['"INSERT INTO wp_mpbpservices2 (name, description, pictures) values (%s, %s, %s)"', '"'. $mpbp_insert[0]. '","'. $mpbp_insert[1]. '","'. $mpbp_insert[2]. '"'];
 echo implode(',', $sql);
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
//mpbp_admin_update($id, $sql, $logic, $success, $error);

/*
*******
* fetch data from db(wp_mpbpadmin2), this data will be displayed on the "input" elements 
*******
*/
//mpbp_display_admin_data($id, $dbTable);


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
//mpbp_delete_admin_data($sql, $section, $page, $success, $url);


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
 [['name', 'input', 'text', "mpbp_name" , 'Name', '', ''],
 ['description', 'textarea', 'text', 'mpbp_description', 'Description', '', ''],
 ['pictures', 'img', 'text', 'mpbp_pictures', '', '', '' ],
 ['', 'input', 'submit', 'mpbp_submit', 'Submit', 'Submit', '']], 
  '/wp-admin/admin.php?page=Services&action=add_new', 
  '', 
  'Add New My G!', 
  'POST', 
  'mpbp_add_new', 
  'Update');
  global $wpdb;
  $mpbp_crud_printer->mpbp_insert_to_db(
  implode(',', $sql),
  'name', 
  'Succes! inserted data.');
 
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1> Insertion</h1>
	<form method='post' action=''/>
	  Name: <input type="text" name='Name' placeholder='Name'/>
	  location: <input type='number' name='location' placeholder='Location'/>
	  <button type="Submit"> Submit </button>
	</form>