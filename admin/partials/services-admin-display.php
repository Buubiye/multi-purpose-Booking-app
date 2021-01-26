<?php
// This file contains the services page
 echo '<h1> Add New Services </h1>';
 //require_once plugin_dir_path(dirname( __FILE__ )  ) . 'admin\validators\service-form-validation.php';
?>

<form method='POST' action='' id='services_1'>
	<input type='text' id='name' name='name' placeholder='name'/><br>
	<input type='text' id='description' name='description' placeholder='description'/><br>
	<input type='text' id='pictures' name='pictures' placeholder='pictures'/><br>
	<input type='text' id='price' name='price' placeholder='price'/><br>
	<input type='text' id='date_created' name='date_created' placeholder='date_created'/><br>
	<input type='text' id='category' name='category' placeholder='category'/><br>
	<input type='text' id='available_times' name='available_times' placeholder='available_times'/><br>
	<input type='text' id='quantity' name='quantity' placeholder='quantity'/><br>
	<input type='text' id='status' name='status' placeholder='status'/><br>
	<input type='text' id='extra_info' name='extra_info' placeholder='extra_info'/><br>
	<input type='submit'/>
 </form>