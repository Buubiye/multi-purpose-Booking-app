<?php
// This file contains the services page
 function mpbp_validate_services(){
	 global $mpbp_services_new_name;
	 global $mpbp_services_data;
	 /*array[
	   "time" => [],
	   "name" => [],
	   "text" => [],
	   "url" => []
	 ];*/
	 if(isset($_POST['name']))
	 {
		 $mpbp_services_new_name = $_POST['name'];
		 $mpbp_services_data[0] = $_POST['name'];
	 }
	 mpbp_insert_to_db();
}

function mpbp_insert_to_db(){
	global $wpdb;
	global $mpbp_services_data;
	//global $mpbp_services_data
	echo $mpbp_services_data[0];
	$wpdb->query(
		$wpdb->prepare("
		    INSERT INTO wp_mpbpservices (time, name, text, url) values (%d, %s, %s, %s)", '209922', $mpbp_services_data[0], "hello", "world"
		)
	);
}

mpbp_validate_services();

?>
<h1> Add New Services </h1>
<form method='POST' action='' id='services_1'>
	<input type='text' id='name' name='name' placeholder='name'/><br>
	<input type='text' id='description' name='description' placeholder='description'/><br>
	<input type='text' id='pictures' name='pictures' placeholder='pictures'/><br>
	<input type='text' id='price' name='price' placeholder='price'/><br>
	<input type='text' id='date_created' name='date_created' placeholder='date_created'/><br>
	<input type='text' id='category' name='category' placeholder='category'/><br>
	<input type='text' id='available_times' name='available_times' placeholder='available_times'/><br>
	<textarea type='text' id='quantity' name='quantity' placeholder='quantity'> </textarea><br>
	<input type='text' id='status' name='status' placeholder='status'/><br>
	<input type='text' id='extra_info' name='extra_info' placeholder='extra_info'/><br>
	<input type='submit'/>
 </form>