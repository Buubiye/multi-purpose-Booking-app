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
 
 $mpbp_crud_printer = new mpbp_crud();
 
 /*
 * This function renders the form
 * mpbp_render_services($data, $url, $action, $h1Text, $method, $id, $buttonName)
 */
 echo $mpbp_crud_printer->mpbp_render_services(
 [['name', 'input', 'text', "mpbp_name" , 'Name', '', '']], 
  '/wp-admin/admin.php?page=Services&action=add_new', 
  '', 
  'Add New My G!', 
  'POST', 
  'mpbp_add_new', 
  'Update');
  $mpbp_crud_printer->mpbp_insert_to_db(
  '[INSERT INTO wp_mpbpservices2 (name, description, pictures,) values (%s, %s, %s),'. $mpbp_services_data[0], $mpbp_services_data[1], $mpbp_services_data[2]],
  $_{POST['name'], 
  'Succes! inserted data.');
 
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1> Insertion</h1>
	<form method='post' action=''/>
	  Name: <input type="text" name='Name' placeholder='Name'/>
	  location: <input type='number' name='location' placeholder='Location'/>
	  <button type="Submit"> Submit </button>
	</form>