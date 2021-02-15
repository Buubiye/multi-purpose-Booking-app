<?php
// This file contains the services page
 function mpbp_validate_services(){
	 global $mpbp_services_new_name;
	 global $mpbp_services_data;
	 global $mpbp_services_error;
	 	 
	 // validate the name
	 if(isset($_POST['name'])){ // just to not excute this code if page is refreshed
	if(!empty($_POST['name']))
	 {
		 $mpbp_services_new_name = $_POST['name'];
		 $mpbp_services_data[0] = $_POST['name'];
	 }else{
		 $mpbp_services_error["name_error"] = "Please check the name";
	 }
	 // validate the description
	 if(!empty($_POST['description'])){
		 $mpbp_services_data[1] = $_POST['description'];
	 }else{
		 $mpbp_services_error["Description_error"] = "Please check the Description";
	 }
	 //validate price
	  if(!empty($_POST['pictures'])){
		 $mpbp_services_data[2] = $_POST['pictures'];
	  }else{
		  $mpbp_services_error["Picture_error"] = "Please check the pictures";
	  }
	  if(!empty($_POST['price'])){
		 $mpbp_services_data[3] = $_POST['price'];
	  }else{
		  $mpbp_services_error["Price_error"] = "Please check the price";
	  }
	  if(!empty($_POST['date_created'])){
		 $mpbp_services_data[4] = $_POST['date_created'];
	  }else{
		  $mpbp_services_error["Date_created_error"] = "Please check the date_created";
	  }
	  if(!empty($_POST['category'])){
		 $mpbp_services_data[5] = $_POST['category'];
	  }else{
		  $mpbp_services_error["category_error"] = "Please check the category";
	  }
	  if(!empty($_POST['available_times'])){
		 $mpbp_services_data[6] = $_POST['available_times'];
	  }else{
		  $mpbp_services_error["available_times_error"] = "Please check the available_times";
	  }
	  if(!empty($_POST['quantity'])){
		 $mpbp_services_data[7] = $_POST['quantity'];
	  }else{
		  $mpbp_services_error["Quantity_error"] = "Please check the quantity";
	  }
	  if(!empty($_POST['status'])){
		 $mpbp_services_data[8] = $_POST['status'];
	  }else{
		  $mpbp_services_error["status_error"] = "Please check the status";
	  }
	  if(!empty($_POST['extra_info'])){
		 $mpbp_services_data[9] = $_POST['extra_info'];
	  }else{
		  $mpbp_services_error["extra_info_error"] = "Please check the extra_info";
	  }
	 }
	  mpbp_insert_to_db();
}

function mpbp_services_update(){
		
	// fetch data for update
		 global $mpbp_service_id;
		 $mpbp_service_id = $_POST['mpbp_services_id']; 
		 
		 //update services data
		 global $wpdb; 
		 if($_GET['action'] == 'edit'){
		 if($mpbp_services_error == ''){
			$wpdb->query(
				$wpdb->prepare("
					 UPDATE wp_mpbpservices2 SET name='%s', description='%s',
					 pictures = '%s', price= '%s', date_created = '%s',
					 category = '%s', available_times = '%s', quantity = '%d',
					 status = '%s', extra_info = '%s'
					 WHERE id= %d", $_POST['name'],
					 $_POST['description'], $_POST['pictures'], $_POST['price'],
					 $_POST['date_created'], $_POST['category'], $_POST['available_times'],
					 $_POST['quantity'], $_POST['status'], $_POST['extra_info'], $mpbp_service_id
				)
			);
		}else{
			print_r($mpbp_services_error);
		}
	 }
}

// display data on inputs
function mpbp_display_services_data(){
	// get the ID input value
	     global $mpbp_service_id;
		 $mpbp_service_id = $_GET['id']; 
		 global $wpdb;
		 global $mpbp_fetched_data_results;
		 $fetch_data;
		 if(isset($mpbp_service_id)){
			$fetch_data = $wpdb->get_results("SELECT * FROM wp_mpbpservices2 WHERE id = ". $mpbp_service_id ."");
		 foreach($fetch_data as $results){
			 $mpbp_fetched_data_results['name'] = $results->name;
			 $mpbp_fetched_data_results['description'] = $results->description;
			 $mpbp_fetched_data_results['pictures'] = $results->pictures;
			 $mpbp_fetched_data_results['price'] = $results->price;
			 $mpbp_fetched_data_results['date_created'] = $results->date_created;
			 $mpbp_fetched_data_results['category'] = $results->category;
			 $mpbp_fetched_data_results['available_times'] = $results->available_times;
			 $mpbp_fetched_data_results['quantity'] = $results->quantity;
			 $mpbp_fetched_data_results['status'] = $results->status;
			 $mpbp_fetched_data_results['extra_info'] = $results->extra_info;
		 }
		 }
}

function mpbp_insert_to_db(){
	global $wpdb;
	global $mpbp_services_data;
	global $mpbp_services_error;
	echo $mpbp_services_data[0];
	if($_GET['action'] == 'add_new'){ 
		if($mpbp_services_error == ''){
			$wpdb->query(
				$wpdb->prepare("
					INSERT INTO wp_mpbpservices2 (name, description, pictures, price, date_created, category, available_times, quantity, status, extra_info) values (%s, %s, %s, %d, %s, %s, %s, %d, %s, %s)",  $mpbp_services_data[0], $mpbp_services_data[1], $mpbp_services_data[2], $mpbp_services_data[3], $mpbp_services_data[4], $mpbp_services_data[5], $mpbp_services_data[6], $mpbp_services_data[7], $mpbp_services_data[8], $mpbp_services_data[9]
				)
			);
		}else{
			print_r($mpbp_services_error);
		}
	}
}
mpbp_services_update();
mpbp_validate_services();
mpbp_display_services_data();

?>
<h1 id="h11" class="wp-heading-inline"> Add New Services </h1>
<a href="<?php echo get_site_url(). '/wp-admin/admin.php?page=Services&action=add_new';?>" class="page-title-action">Add New</a>
<form method='POST' enctype="multipart/form-data" action='' id='mpbp_services_1'>
    <input type='text' id="mpbp_services_id" name="mpbp_services_id" placeholder="Search ID" value="<?php echo $_GET['id'];/*$_POST['mpbp_services_id'];*/ ?>"/><br>
	<input type='text' id='name' name='name' placeholder='name' value="<?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['name'];?>"/><br>
	<textarea type='text' id='description' name='description' placeholder='description'><?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['description'];?></textarea><br>
	<input type='text' id='pictures' name='pictures' placeholder='pictures' value="<?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['pictures'];?>"/>
	<div class='image-preview-wrapper'>
            <img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' width='200'>
        </div>
        <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
        <input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
		
	<button type="button" id="mpbp_hidden_image_form_btn" value="">insert to Form</button><br>
	<input type='text' id='price' name='price' placeholder='price' value="<?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['price'];?>"/><br>
	<input type='text' id='date_created' name='date_created' placeholder='date_created' value="<?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['date_created']; ?>"/><br>
	<select type='text' id='category' name='category' placeholder='category' value="">
		<option id="mpbp_category_select"> <?php global $mpbp_fetched_data_results; echo (!empty($mpbp_fetched_data_results['category'])) ? $mpbp_fetched_data_results['category'] : 'Select Category'; ?></option>
		<option id="mpbp_services_taxi"> Ride Sharing </option>
		<option id="mpbp_services_hotel"> Hotel </option>
		<option id="mpbp_services_accomodation"> Accomodation </option>
		<option id="mpbp_services_flight"> Flight </option>
		<option id="mpbp_services_other"> Other </option>
	</select><br>
	<label> The available time should be written like this [00:00 am - 00:00 pm], [00:00 am - 00:00 pm] .... <br>
			 [] = the brackets mean the different opening and closing times throught the day</label> <br>
	<input type='text' id='available_times' name='available_times' placeholder='available_times' value="<?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['available_times']; ?>"/>
	<p id="mpbp_available_times_tester"></p><br>
	<input type='number' id='quantity' name='quantity' placeholder='quantity' value="<?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['quantity'];?>"/><br>
	<select type='text' id='status' name='status' placeholder='status' value="">
	    <option id="mpbp_services_status"> <?php global $mpbp_fetched_data_results; echo (!empty($mpbp_fetched_data_results['status'])) ? $mpbp_fetched_data_results['status'] : 'Select Status' ;?> </option>
	    <option id="mpbp_services_available"> Available </option>
		<option id="mpbp_services_not_available"> Not Available </option>
	</select><br>
	<input type='text' id='extra_info' name='extra_info' placeholder='extra_info' value="<?php global $mpbp_fetched_data_results; echo $mpbp_fetched_data_results['extra_info'];?>"/><br>
	<input placeholder='service providers IDs'/>
	<input placeholder="last updated by"/>
	<input class="button" type='submit'/>
 </form>
 
<?php
if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
        update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
    endif;
    wp_enqueue_media();
	wp_enqueue_script( array("jquery", "jquery-ui-core", "interface", "jquery-ui-sortable", "wp-lists", "jquery-ui-sortable") );
    ?>
	
<?php
$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
    ?>
	