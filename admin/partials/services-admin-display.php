<?php
/*
* This file contains the services page
*/

/*
*******
* This function validates data for "update" action and "add_new" action
*******
*/
 function mpbp_validate_services(){
	 
	 /*
	 * The below four global variable do the following stuff respectively
	 * stores the data after it is validated
	 * stores the errors when user clicks submit
	 * stores the input names of services update or add new form
	 * Stores the logic for validating inputs
	 */
	 global $mpbp_services_data;  		       
	 global $mpbp_services_error; 		      
	 global $mpbp_services;       		      
	 global $mpbp_services_validation_logic;  
	 
	/*
	* This array stores the names of the inputs in service page
	*/
	$mpbp_services = [
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
	* This array stores the logic for validating every input
	*/
	$mpbp_services_validation_logic = [
	!empty($_POST['name']),
	!empty($_POST['description']),
	!empty($_POST['pictures']),
    !empty($_POST['price']),
	!empty($_POST['date_created']),
	!empty($_POST['category']) | $_POST['category'] != 'Select Category',
	!empty($_POST['available_times']),
	!empty($_POST['quantity']),
	!empty($_POST['status']) | $_POST['status'] != 'Select Status',
	!empty($_POST['extra_info']) 
	];
	
	/*
	* This if statement fires if user sets the name value and clicks submit
	* the for loop loops through the data submitted by user and validates the data
	* with the logic stored in "$mpbp_services_validation_logic" array.
	* all the errors detected are assigned to the "$mpbp_services_error" array for later use
	*/
	if(isset($_POST['name'])){ 
	$mpbp_services_error = null;
	for($logic = 0; $logic<sizeof($mpbp_services_validation_logic); $logic++){
		if($mpbp_services_validation_logic[$logic]){
			$mpbp_services_data[$logic] = $_POST[$mpbp_services[$logic]];
		}else{
			$mpbp_services_error[$mpbp_services[$logic]] = 'please check the '. $mpbp_services[$logic];
		}
	}
	};
	
	/*
	* Fires to insert data to the db
	*/
	  mpbp_insert_to_db();
}

/*
*******
* update data the selected row from db(wp_mpbpservices2 )
*******
*/
function mpbp_services_update(){
	// fetch data for update
		 global $mpbp_service_id;
		 if(isset($_POST['name'])){
		 $mpbp_service_id = $_POST['mpbp_services_id']; 
		 }
		 global $mpbp_services_error;
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

/*
*******
* fetch data from db(wp_mpbpservices2), this data will be displayed on the "input" elements 
*******
*/
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

/*
*******
* inserts new values to the database(wp_mpbpservices2 )
*******
*/
function mpbp_insert_to_db(){
	global $wpdb;
	global $mpbp_services_data;
	global $mpbp_services_error;
	echo $mpbp_services_data[0];
	if($_GET['action'] == 'add_new'){ 
		if($mpbp_services_error == ''){
			/*
			* if(isset('name') is used to stop the query from happening if the user -
			* loads empty values
			* This SQL query inserts new value to database wp_mpbpservices2
			*/
			if(isset($_POST['name'])){
			$wpdb->query(
				$wpdb->prepare("
					INSERT INTO wp_mpbpservices2 (name, description, pictures, price, date_created, category, available_times, quantity, status, extra_info) values (%s, %s, %s, %d, %s, %s, %s, %d, %s, %s)",  $mpbp_services_data[0], $mpbp_services_data[1], $mpbp_services_data[2], $mpbp_services_data[3], $mpbp_services_data[4], $mpbp_services_data[5], $mpbp_services_data[6], $mpbp_services_data[7], $mpbp_services_data[8], $mpbp_services_data[9]
				)
			);
			}
		}else{
			print_r($mpbp_services_error);
		}
	}
}

/*
********
* Deletes the selected row(s) in db(wp_mpbpservices2)
*******
*/
function mpbp_delete_services_data(){
	global $wpdb;
	/*
	* This is a conformation form which appears when user tries to delete data from his services db
	*/
	if($_GET['action'] == 'delete' && $_GET['id'] != '' && $_POST['mpbp_verify_service_delete'] == ''){
		echo "<form method='POST' action=''><h3> Are you sure you want to delete service #". $_GET['id'] ."</h3>
			  <label>YES:</lable><input type='radio' name='mpbp_verify_service_delete' value='Yes'/>
			  <label>NO:</label><input type='radio' name='mpbp_verify_service_delete' value='No'/>
			  <input type='submit' value='I CONFIRM THIS ACTION'/></form>";
	}  
	/*
	* When confrmation forms appears, if user clicks "yes" [radio input element] delete the row by -
	* extracting it id from $_GET['id'] method. Then print out a success message
	*/
	if($_GET['action'] == 'delete' && $_GET['id'] != '' && $_POST['mpbp_verify_service_delete'] == 'Yes'){		  
		$wpdb->query(
			$wpdb->prepare("
				DELETE FROM wp_mpbpservices2 WHERE id='%d'", $_GET['id']."
			")
		);
		echo "succesfully deleted Service #". $_GET['id'];
	}else if($_POST['mpbp_verify_service_delete'] == 'No'){
		/*
		* if user chooses not to delete his data redirect him to all services page
		*/
		header('Location:'. get_site_url() .'/wp-admin/admin.php?page=all_services');
		die();
	}
}

mpbp_services_update();
mpbp_validate_services();
mpbp_display_services_data();
mpbp_delete_services_data();

//['name', 'element', 'type', 'class' , 'placeholder', 'value', 'options']
function mpbp_printout_inputs($name, $element, $type, $class , $placeholder, $value, $options){
	switch($element){
		case "input":
			echo "<label>". $name ."</label><br><input type='". $type ."' name='". $name ."' id='mpbp_services_". $name ."' class='". $class ."' 
				  placeholder='". $placeholder ."' value='". $value ."'/><br>";
			break;
		case "textarea":
			echo "<label>". $name ."</label><br><textarea type='". $type ."' name='". $name ."' id='mpbp_services_". $name ."' class='". $class ."' 
				  placeholder='". $placeholder ."'> ". $value ."</textarea><br>";
			break;
		case "img":
			echo "<input type='". $type ."' id='". $name ."' name='". $name ."' placeholder='". $placeholder ."' value='". $value ."'/>
					<div class='image-preview-wrapper'>
                    <img id='image-preview' src='' width='200'/>
					</div>
					<input id='upload_image_button' type='button' class='button' value='". __( 'Upload image' ) ."' /></br>
					<button type='button' id='mpbp_hidden_image_form_btn' value=''>insert to Form</button><br>";
					break;
		case "select":
			echo "<label>". $name ."</label><br><select type='". $type ."' id='". $name ."' name='". $name ."' placeholder='". $placeholder ."'>";
			for($i=0; $i<sizeof($value); $i++){
				echo "<option id='mpbp_". $value[$i] ."' value='". $value[$i]."'> ". $value[$i]." </option>";
			}
			echo "</select><br>";
			break;
	}
}

function mpbp_render_services(){
	/*
	* Prints out new inputs
	* Below array shows how the data is organized
	* ['name', 'element', 'type', 'class' , 'placeholder', 'value', 'options']
	*/
	global $mpbp_fetched_data_results;
	$mpbp_s_val = [
	    ["id", "input", "number", "mpbp_service_id", "ID", $_GET['id'], ""],
		["name", "input", "text", "mpbp_service_name", "Name", 
		($_GET['action'] == 'add_new')? $_POST['name'] : $mpbp_fetched_data_results['name'], ""],
		["description", "textarea", "text", "mpbp_service_description", "Description", 
		($_GET['action'] == 'add_new')? $_POST['description'] : $mpbp_fetched_data_results['description'], ""],
		["pictures", "img", "text", "mpbp_service_pictures", "Pictures", 
		($_GET['action'] == 'add_new') ? $_POST['pictures'] : $mpbp_fetched_data_results['pictures'], ""],
		["price", "input", "number", "mpbp_s_price", "Price", 
		($_GET['action'] == 'add_new') ? $_POST['price'] : $mpbp_fetched_data_results['price'], ""],
		["date_created", "input", "text", "mpbp_s_date_created", "Date Created", 
		($_GET['action'] == 'add_new') ? $_POST['date_created'] : $mpbp_fetched_data_results['date_created'], ""],
		["category", "select", "text", "mpbp_s_category", "Category", 
			[($_GET['action'] == 'add_new' && $_POST['category'] != '') ? $_POST['category'] : (($mpbp_fetched_data_results['category'] != '') ? $mpbp_fetched_data_results['category'] : "Select Category"), 
			"Ride Sharing",  
			"Accomodation", 
			"Hotel", 
			"Flight", 
			"Other"] , ""],
		["available_times", "input", "text", "mpbp_s_available_time", "Avaiable Times", 
		($_GET['action'] == 'add_new') ? $_POST['available_times'] : $mpbp_fetched_data_results['available_times'] , ""],
		["quantity", "input", "number", "mpbp_s_quantity", "Quantity", 
		($_GET['action'] == 'add_new') ? $_POST['quantity'] : $mpbp_fetched_data_results['quantity'], ""],
		["status", "select", "text", "mpbp_s_status", "Status", 
			[($_GET['action'] == 'add_new') ? $_POST['status'] : (($mpbp_fetched_data_results['status'] != '')? $mpbp_fetched_data_results['status'] : "Select Status"),
			"Available",
			"Not Available"], ""],
		["extra_info", "input", "text", "mpbp_s_extra_info", "Extra Info", 
		($_GET['action'] == 'add_new') ? $_POST['extra_info'] : $mpbp_fetched_data_results['extra_info'], ""],
		["", "input", "submit", "button", "", "Submit", ""]
	];
	
	/*
	* Loops through the above array and print out values
	*/
	echo '<form method="POST" enctype="multipart/form-data" action="" id="mpbp_services_1">';
	echo '<h1 id="h11" class="wp-heading-inline"> Add New Services </h1>
    <a href="'. get_site_url() .'/wp-admin/admin.php?page=Services&action=add_new" class="page-title-action">Add New</a><br>';
	for($i = 0; $i < sizeof($mpbp_s_val); $i++){
		mpbp_printout_inputs($mpbp_s_val[$i][0], $mpbp_s_val[$i][1], $mpbp_s_val[$i][2], $mpbp_s_val[$i][3] , $mpbp_s_val[$i][4], $mpbp_s_val[$i][5], $mpbp_s_val[$i][6]);
	}
	echo '</form>';
}
		
mpbp_render_services();
?>


 
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
	