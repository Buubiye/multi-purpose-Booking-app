<?php
// This file contains the services page
 function mpbp_validate_services(){
	 global $mpbp_services_new_name;
	 global $mpbp_services_data;
	 global $mpbp_services_error;
	 // validate the name
	 if(!empty($_POST['name']))
	 {
		 $mpbp_services_new_name = $_POST['name'];
		 $mpbp_services_data[0] = $_POST['name'];
		 //if($mpbp_services_error != ''){
			 //unset($mpbp_services_error['name_error']);
			 $mpbp_services_error = "Please check the name2";
		 //}
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

function mpbp_insert_to_db(){
	mpbp_validate_services();
	global $wpdb;
	global $mpbp_services_data;
	global $mpbp_services_error;
	echo $mpbp_services_data[0];
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

mpbp_insert_to_db();

?>
<h1 id="h11"> Add New Services </h1>
<form method='POST' enctype="multipart/form-data" action='' id='services_1'>
	<input type='text' id='name' name='name' placeholder='name' value=''/><br>
	<input type='text' id='description' name='description' placeholder='description'/><br>
	<input type='text' id='pictures' name='pictures' placeholder='pictures'/>
	<div class='image-preview-wrapper'>
            <img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' width='200'>
        </div>
        <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
        <input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
		
	<button type="button" id="mpbp_hidden_image_form_btn" value="">insert to Form</button><br>
	<input type='text' id='price' name='price' placeholder='price'/><br>
	<input type='text' id='date_created' name='date_created' placeholder='date_created'/><br>
	<select type='text' id='category' name='category' placeholder='category'>
		<option id="mpbp_category_select"> Select Category </option>
		<option id="mpbp_services_taxi"> Ride Sharing </option>
		<option id="mpbp_services_hotel"> Hotel </option>
		<option id="mpbp_services_accomodation"> Accomodation </option>
		<option id="mpbp_services_flight"> Flight </option>
		<option id="mpbp_services_other"> Other </option>
	</select><br>
	<label> The available time should be written like this [00:00 am - 00:00 pm], [00:00 am - 00:00 pm] .... <br>
			 [] = the brackets mean the different opening and closing times throught the day</label> <br>
	<input type='text' id='available_times' name='available_times' placeholder='available_times'/>
	<p id="mpbp_available_times_tester"></p><br>
	<textarea type='number' id='quantity' name='quantity' placeholder='quantity'> </textarea><br>
	<select type='text' id='status' name='status' placeholder='status'>
	    <option id="mpbp_services_status"> Select Status </option>
	    <option id="mpbp_services_available"> Available </option>
		<option id="mpbp_services_not_available"> Not Available </option>
	</select><br>
	<input type='text' id='extra_info' name='extra_info' placeholder='extra_info'/><br>
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
    ?><script type='text/javascript'>
	// this code validates the ['available_times'] input value using regex
	document.getElementById("available_times").addEventListener("keyup", displayDate);

	function displayDate() {
		  let regex = /\[(\d\d|\d)\:(\d\d|\d)(\s|\S)(am|pm)\s(\-|\,)\s(\d\d|\d)\:(\d\d|\d)(\s|\S)(am|pm)]/gi;
		  let mpbp_available_regex = document.getElementById("available_times").value;
		  document.getElementById('mpbp_available_times_tester').innerHTML = regex.test(mpbp_available_regex);
	  
	}
	// this code stores the image src attribute in one input
	var pushValues = [];
		document.getElementById('mpbp_hidden_image_form_btn').onclick = function(){
		   var imgSrcArray = document.getElementsByClassName('mpbp_new_images');
		   pushValues = []; // remove the old values
		   for(i=0; i<imgSrcArray.length; i++){
			 pushValues.push(document.getElementsByClassName('mpbp_new_images')[i].getAttribute('src'));
		   }
		   document.getElementById('pictures').value = pushValues;
		}
		
        var tgm_media_frame;
        $('h1').click(function(){
	 $(this).css({color: 'green'});
	 //$(this).css({color: 'yellow'});
  });
  
  document.getElementById('h11').addEventListener('click', function(){
	  //console.log('Axmed, here we go again');
  });
  
$('#upload_image_button').click(function() {

  if ( tgm_media_frame ) {
    tgm_media_frame.open();
    return;
  }

  tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
    multiple: 'add',
    library: {
      type: 'image'
    },
  });

  tgm_media_frame.on('select', function(){
    var selection = tgm_media_frame.state().get('selection');
    selection.map( function( attachment ) {
		attachment = attachment.toJSON();
		//$('.mpbp_new_images').remove(); // remove the current images
		$("#image-preview").after("<img class='mpbp_new_images' style='width: 100px;' src=" +attachment.url+">");
    });
  });

  tgm_media_frame.open();
  
  console.log('Axmed, i dont have event listener');
  
});
    </script>
	