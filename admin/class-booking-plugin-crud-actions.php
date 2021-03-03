<?php
/*
* This file contains the admin page
*/
ob_start();
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
*
*/
public function mpbp_admin_initializer($mpbp_admin_error, $mpbp_admin_validation_logic, $mpbp_admin_data, $mpbp_fetched_data_results, $mpbp_admin){
	$this->mpbp_admin_error = $mpbp_admin_error;
	$this->mpbp_admin_validation_logic = $mpbp_admin_validation_logic;
	$this->mpbp_admin_data = $mpbp_admin_data; 
	$this->mpbp_fetched_data_results = $mpbp_fetched_data_results;
	$this->mpbp_admin = $mpbp_admin;
}
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
	
	if(isset($_POST[$this->mpbp_admin[1]])){ 
	$this->mpbp_admin_error = null;
	for($logic = 0; $logic<sizeof($this->mpbp_admin_validation_logic); $logic++){
		if($this->mpbp_admin_validation_logic[$logic]){
			$this->mpbp_admin_data[$logic] = $_POST[$this->mpbp_admin[$logic]];
		}else{
			$this->mpbp_admin_error[$this->mpbp_admin[$logic]] = 'please check the '. $this->mpbp_admin[$logic];
		}
	}
	/*
	* return the values of the validated data or if the there is error with the input
	* print out the errors 
	*/
	if($this->mpbp_admin_error == ''){
		return $this->mpbp_admin_data;
	}else{
		return $this->mpbp_admin_error;
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
public function mpbp_admin_update($dbTable, $data, $dataFormat, $logic, $success, $error){
	     // fetch data for update
		 
		 //update admin data
		 global $wpdb; 
		 if($logic){
		 if($this->mpbp_admin_error == ''){
				$wpdb->update($dbTable, $data, $dataFormat);
			
			/*
			* This is stores the success message
			* @since    1.0.0
	        * @access   public
	        * @var      array 
			*/
			return $success;
		}else{
			 $errorMessage= json_encode($this->mpbp_admin_error);
			 return $error . $errorMessage;
		}
	 }
}

/*
*******
* fetch data from db(wp_mpbpadmin2), this data will be displayed on the "input" elements 
*******
*/
public function mpbp_display_admin_data($type, $id, $dbTable){
		 
		 global $wpdb;
		 $fetch_data;
		 if(isset($id)){
			$fetch_data = $wpdb->get_results("SELECT * FROM ". $dbTable ." WHERE ". $type ." = ". $id ."");
			// stores the mpbp_admin data
			$array_data = $this->mpbp_admin;
			for($i = 0; $i < sizeof($array_data); $i++){
				$x = $array_data[$i];;
				$this->mpbp_fetched_data_results[$array_data[$i]] = $fetch_data[0]->$x;
			}
			}
}


/*
*******
* inserts new values to the database(wp_mpbpadmin2 )
*******
*/
public function mpbp_insert_to_db($tableName, $data, $dataFormat, $isset, $success){
	global $wpdb;
	if($_GET['action'] == 'add_new'){ 
		if($this->mpbp_admin_error == ''){
			/*
			* if(isset('name') is used to stop the query from happening if the user -
			* loads empty values
			* This SQL query inserts new value to database wp_mpbpadmin2
			*/
			if(isset($_POST[$isset])){
			$wpdb->insert($tableName, $data, $dataFormat);
			$lastid = $wpdb->insert_id;
			?>
			<script type="text/javascript">
				window.location = <?php echo "'". get_site_url(). '/wp-admin/admin.php?page=my_table2&action=edit&id='. $lastid . "';";?>
			</script>
             <?php
			return $success;
		}else{
			echo "<br>Error!". json_encode($this->mpbp_admin_error) .'<br>';
		}
	}
}
}
/*
********
* Deletes the selected row(s) in db(wp_mpbpadmin2)
*******
*
* since 1.0.0
* $dbTable string stores the name of the datable table which the deletion will occur.
* $id integer stores the id of the row which will be deleted.
* $section string to specify which page's data is deleted eg servies or orders.
* $page string to specify the page we are in.
* $url string stores the url which we redirected to after the deletion occurs.
*/
public function mpbp_delete_admin_data($dbTable, $id, $section, $page, $success, $url){
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
			$wpdb->delete($dbTable, array('id' => $id ));
			echo $success . $_GET['id'];
			?>
			     <script type="text/javascript">
			     window.location = <?php echo "'". get_site_url(). '/wp-admin/admin.php?page=all_services'. "';";?>
			     </script>
             <?php
		}else if($_POST[$section] == 'No'){
			/*
			* if user chooses not to delete his data redirect him to all admin page
			*/
			//return header('Location:'. get_site_url() . $url);
		}
	}
}


//['name', 'element', 'type', 'class' , 'placeholder', 'value', 'options']
public function mpbp_printout_inputs($name, $element, $type, $class , $placeholder, $value, $options){
	switch($element){
		case "input":
			return "<label>". $name ."</label><br><input type='". $type ."' name='". $name ."' id='mpbp_admin_". $name ."' class='". $class ."' 
				  placeholder='". $placeholder ."' value='". $value ."'/><br>";
			break;
		case "textarea":
			return "<label>". $name ."</label><br><textarea type='". $type ."' name='". $name ."' id='mpbp_admin_". $name ."' class='". $class ."' 
				  placeholder='". $placeholder ."'> ". $value ."</textarea><br>";
			break;
		case "img":
			return "<label>". $name ."</label><br><input type='". $type ."' id='". $name ."' name='". $name ."' placeholder='". $placeholder ."' value='". $value ."'/>
					<div class='image-preview-wrapper'>
                    <img id='image-preview' src='' width='200'/>
					</div>
					<input id='upload_image_button' type='button' class='button' value='". __( 'Upload image' ) ."' /></br>
					<button type='button' id='mpbp_hidden_image_form_btn' value=''>insert to Form</button><br>";
					break;
		case "select":
		    $looped_results;
			for($i=0; $i<sizeof($value); $i++){
				$looped_results[] = "<option id='mpbp_". $value[$i] ."' value='". $value[$i]."'> ". $value[$i]." </option>";
			}
			$result = "<label>". $name ."</label><br><select type='". $type ."' id='". $name ."' name='". $name ."' placeholder='". $placeholder ."'>".
			 implode($looped_results)
			 ."</select><br>";
			 return $result;
			break;
	}
}

/* 
* renders the inputs in respective order
*/
public function mpbp_render_services($data, $url, $action, $h1Text, $method, $id, $buttonName){
	/*
	* Prints out new inputs
	* Below array shows how the data is organized
	* ['name', 'element', 'type', 'class' , 'placeholder', 'value', 'options']
	* Loops through the above array and print out values
	*/
	$dataArray;
	for($i = 0; $i < sizeof($data); $i++){
		$dataArray[] = $this->mpbp_printout_inputs($data[$i][0], $data[$i][1], $data[$i][2], $data[$i][3] , $data[$i][4], $data[$i][5], $data[$i][6]);
	}
	$results = '<form method="'. $method .'" enctype="multipart/form-data" action="'. $action .'" id="'. $id .'">
	<h1 id="h11" class="wp-heading-inline"> '. $h1Text .' 
	</h1> <a href="'. get_site_url() . $url .'" class="page-title-action">'. $buttonName.'</a>
	<br>'. implode($dataArray) .'</form>';
	return $results;
}
}
ob_end_flush();