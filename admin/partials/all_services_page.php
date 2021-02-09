<?php
  /*
  * This file displays the services in a list of 10 per laod
  *
  */
  
  echo "<h1>This is Services List</h1>";

  function mpbp_display_services(){
  global $wpdb;
  
  global $mpbp_current_service_page;
  
  $mpbp_services_last_row = $_POST['mpbp_services_last_row'];
  $mpbp_services_first_key = array_key_first($mpbp_services_last_row);
  $mpbp_services_last_key = array_key_last($mpbp_services_last_row);
  
  if(isset($_GET['order'])){
	$mpbp_current_service_page = $_GET['order'] - 1;
  }else{
	 $mpbp_current_service_page = 0; 
  }
  $mpbp_next_service_page = $mpbp_current_service_page + 1;
  $mpbp_previous_service_page = $mpbp_current_service_page - 1;
  $mpbp_services_query = $wpdb->get_results("
	SELECT id , name, description FROM wp_mpbpservices2 LIMIT ". $mpbp_current_service_page .",2;
  ");
  
  // change page number
  //echo '<form type="POST"><input name="mpbp_services_last_row" value="'. print_r($mpbp_services_query) .'"/><input type="submit"/></form>';
  echo '<a href="http://localhost:8080/wordpress/wp-admin/admin.php?page=all_services&order='. $mpbp_next_service_page .'"> Next Page </a>';
  //echo $mpbp_current_service_page;
 // print out services
	  for($i = 0; $i <= 2; $i++){
		 //$i += $mpbp_current_service_page;
		//  print_r(mpbp_current_service_page);
	  echo $mpbp_services_query[$i]->id . ' <br> ';
	 // echo $mpbp_services_query[$i]->name . ' , ';
	 // echo $mpbp_services_query[$i]->description . ' <br> ';
	  }
  }
  
  
  mpbp_display_services();
?>

<form>
	<input/>
</form>