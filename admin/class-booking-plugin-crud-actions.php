<?php
/*
* This file contains the admin page
*/

class mpbp_crud{
	
	/*
	* stores the errors when user clicks submit.
	*
	* @since    1.0.0
	* @access   public
	* @var      array    error    This array stores errors.
    */	 
     public $mpbp_admin_error; 

	/*
    * stores the input names of admin update or add new form.
	*
	* @since    1.0.0
	* @access   public
	* @var      array    $mpbp_admin    This array stores input field name.
    */	 
	public $mpbp_admin;       		      
	  
	 
	/*
	* This array stores the names of the inputs in admin page
	*
	* @since    1.0.0
	* @access   public
	* @var      array    
	*/
	public $mpbp_admin_data;
	
	/*
	* This array stores the logic for validating every input
	*
	* @since    1.0.0
	* @access   public
	* @var      array    
	*/
	public $mpbp_admin_validation_logic;
	
	/*
	* This array fetches the data from database
	*
	* @since    1.0.0
	* @access   public
	* @var      array 
	*/
	public $mpbp_fetched_data_results;
	
	/*
	* To store element data in this form ['name', 'element', 'type', 'class' , 'placeholder', 'value', 'options']
	*
	* @since    1.0.0
	* @access   public
	* @var      array 
	*/
	public $mpbp_s_val;
/*
*******
* This function validates data for "update" action and "add_new" action
*
* @since    1.0.0
* @access   public
*******
*/
public function mpbp_validate_admin(){ 
	 
	/*
	* This if statement fires if user sets the second input in "$mpbp_admin" clicks submit
	* the for loop loops through the data submitted by user and validates the data
	* with the logic stored in "$mpbp_admin_validation_logic" array.
	* all the errors detected are assigned to the "$mpbp_admin_error" array for later use
	*/
	if(isset($_POST[$mpbp_admin[1]])){ 
	$mpbp_admin_error = null;
	for($logic = 0; $logic<sizeof($mpbp_admin_validation_logic); $logic++){
		if($mpbp_admin_validation_logic[$logic]){
			$mpbp_admin_data[$logic] = $_POST[$mpbp_admin[$logic]];
		}else{
			$mpbp_admin_error[$mpbp_admin[$logic]] = 'please check the '. $mpbp_admin[$logic];
		}
	}
	};
}

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
public function mpbp_admin_update($id, $type, $success, $error){
	     // fetch data for update
		 
		 //update admin data
		 global $wpdb; 
		 if($_GET['action'] == 'edit' && isset($_POST['name'])){
		 if($mpbp_admin_error == ''){
			$wpdb->query(
				$wpdb->prepare("
					 UPDATE wp_mpbpadmin2 SET name='%s', description='%s',
					 pictures = '%s', price= '%s', date_created = '%s',
					 category = '%s', available_times = '%s', quantity = '%d',
					 status = '%s', extra_info = '%s'
					 WHERE id= %d", $_POST['name'],
					 $_POST['description'], $_POST['pictures'], $_POST['price'],
					 $_POST['date_created'], $_POST['category'], $_POST['available_times'],
					 $_POST['quantity'], $_POST['status'], $_POST['extra_info'], $id
				)
			);
			
			/*
			* This is stores the success message
			* @since    1.0.0
	        * @access   public
	        * @var      array 
			*/
			return $success;
		}else{
			return $error;
			print_r($mpbp_admin_error);
		}
	 }
}

/*
*******
* fetch data from db(wp_mpbpadmin2), this data will be displayed on the "input" elements 
*******
*/
public function mpbp_display_admin_data($id, $dbTable){
		 global $wpdb;
		 $fetch_data;
		 if(isset($id)){
			$fetch_data = $wpdb->get_results("SELECT * FROM ". $dbTable ." WHERE id = ". $id ."");
			for($i = 0; $i < sizeof($fetch_data); $i++){
				$mpbp_fetched_data_results[$mpbp_admin[$i]] = $fetch_data->$mpbp_admin[$i];
			}
			}
}


/*
*******
* inserts new values to the database(wp_mpbpadmin2 )
*******
*/
public function mpbp_insert_to_db($success, $error){
	global $wpdb;
	if($_GET['action'] == 'add_new'){ 
		if($mpbp_admin_error == ''){
			/*
			* if(isset('name') is used to stop the query from happening if the user -
			* loads empty values
			* This SQL query inserts new value to database wp_mpbpadmin2
			*/
			if(isset($_POST['name'])){
			$wpdb->query(
				$wpdb->prepare("
					INSERT INTO wp_mpbpadmin2 (name, description, pictures, price, date_created, category, available_times, quantity, status, extra_info) values (%s, %s, %s, %d, %s, %s, %s, %d, %s, %s)",  $mpbp_admin_data[0], $mpbp_admin_data[1], $mpbp_admin_data[2], $mpbp_admin_data[3], $mpbp_admin_data[4], $mpbp_admin_data[5], $mpbp_admin_data[6], $mpbp_admin_data[7], $mpbp_admin_data[8], $mpbp_admin_data[9]
				)
			);
			}
			return $success;
		}else{
			return $error;
			print_r($mpbp_admin_error);
		}
	}
}

/*
********
* Deletes the selected row(s) in db(wp_mpbpadmin2)
*******
*
* since 1.0.0
* $section string to specify which page's data is deleted eg servies or orders
* $page string to specify the page we are in
*/
public function mpbp_delete_admin_data($dbTable, $section, $page, $success, $url){
	global $wpdb;
	/*
	* This is a conformation form which appears when user tries to delete data from his admin db
	*/
	if($_GET['action'] == 'delete' && $_GET['id'] != '' && isset($_POST[$section]) == ''){
		echo "<form method='POST' action=''><h3> Are you sure you want to delete ". $page ." #". $_GET['id'] ."</h3>
			  <label>YES:</lable><input type='radio' name='mpbp_verify_service_delete' value='Yes'/>
			  <label>NO:</label><input type='radio' name='mpbp_verify_service_delete' value='No'/>
			  <input type='submit' value='I CONFIRM THIS ACTION'/></form>";
	}  
	/*
	* When confrmation forms appears, if user clicks "yes" [radio input element] delete the row by -
	* extracting it id from $_GET['id'] method. Then print out a success message
	*/
	if(isset($_POST[$section])){
		if($_GET['action'] == 'delete' && $_GET['id'] != '' && $_POST[$section] == 'Yes'){		  
			$wpdb->query(
				$wpdb->prepare("
					DELETE FROM ". $dbTable ." WHERE id='%d'", $_GET['id']."
				")
			);
			return $success . $_GET['id'];
		}else if($_POST[$section] == 'No'){
			/*
			* if user chooses not to delete his data redirect him to all admin page
			*/
			header('Location:'. get_site_url() . $url);
			die();
		}
	}
}


//['name', 'element', 'type', 'class' , 'placeholder', 'value', 'options']
public function mpbp_printout_inputs($name, $element, $type, $class , $placeholder, $value, $options){
	switch($element){
		case "input":
			echo "<label>". $name ."</label><br><input type='". $type ."' name='". $name ."' id='mpbp_admin_". $name ."' class='". $class ."' 
				  placeholder='". $placeholder ."' value='". $value ."'/><br>";
			break;
		case "textarea":
			echo "<label>". $name ."</label><br><textarea type='". $type ."' name='". $name ."' id='mpbp_admin_". $name ."' class='". $class ."' 
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

}

$mpbp_new_crud = new mpbp_crud();

$mpbp_new_crud->mpbp_insert_to_db();
$mpbp_new_crud->mpbp_render_admin();
$mpbp_new_crud->mpbp_admin_update();
$mpbp_new_crud->mpbp_validate_admin();
$mpbp_new_crud->mpbp_display_admin_data();
$mpbp_new_crud->mpbp_delete_admin_data();
	