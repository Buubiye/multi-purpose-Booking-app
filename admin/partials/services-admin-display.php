<?php
// This file contains the services page
 function mpbp_validate_services(){
	 global $mpbp_services_new_name;
	 global $mpbp_services_data;
	 // validate the name
	 if(isset($_POST['name']))
	 {
		 $mpbp_services_new_name = $_POST['name'];
		 $mpbp_services_data[0] = $_POST['name'];
	 }
	 // validate the description
	 //if(){
		 
	 //}
	 //uploaded pictures
	 if($_FILES['mpbp_services_pic_upload']['name'] == !''){
		 $mpbp_services_data[2] = $_FILES['mpbp_services_pic_upload']['name'];
		 
		 $mpbp_upload = media_handle_upload('mpbp_services_pic_upload', 0);
		 if(is_wp_error($mpbp_upload)){
            echo "Error uploading file: " . $mpbp_upload->get_error_message();
        }else{
            echo "File upload successful!";
        }
	 }
	 //validate price
	 
	 //date_created
	 
	 //validate category
	 
	 //avialable_times
	 
	 //validate quantity
	 
	 //validate status
	 
	 //validate extra_info
	 
	 //
	 mpbp_insert_to_db();
}

function mpbp_insert_to_db(){
	global $wpdb;
	global $mpbp_services_data;
	//global $mpbp_services_data
	echo $mpbp_services_data[0];
	$wpdb->query(
		$wpdb->prepare("
		    INSERT INTO wp_mpbpservices2 (name, description, pictures, price) values (%d, %s, %s, %d)", '209922', $mpbp_services_data[0], "hello", 5645
		)
	);
}

mpbp_validate_services();

?>
<h1 id="h11"> Add New Services </h1>
<form method='POST' enctype="multipart/form-data" action='' id='services_1'>
	<input type='text' id='name' name='name' placeholder='name'/><br>
	<input type='text' id='description' name='description' placeholder='description'/><br>
	<input type='text' id='pictures' name='pictures' placeholder='pictures'/>
	<input type="file" id="mpbp_services_pic_upload" name="mpbp_services_pic_upload" value="Upload Picture"/><br>
	<input type='text' id='price' name='price' placeholder='price'/><br>
	<input type='text' id='date_created' name='date_created' placeholder='date_created'/><br>
	<input type='text' id='category' name='category' placeholder='category'/><br>
	<input type='text' id='available_times' name='available_times' placeholder='available_times'/><br>
	<textarea type='text' id='quantity' name='quantity' placeholder='quantity'> </textarea><br>
	<input type='text' id='status' name='status' placeholder='status'/><br>
	<input type='text' id='extra_info' name='extra_info' placeholder='extra_info'/><br>
	<input class="button" type='submit'/>
 </form>
 
<?php
if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
        update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
    endif;
    wp_enqueue_media();
	wp_enqueue_script( array("jquery", "jquery-ui-core", "interface", "jquery-ui-sortable", "wp-lists", "jquery-ui-sortable") );
    ?><form method='post'>
        <div class='image-preview-wrapper'>
            <img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' width='200'>
        </div>
        <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
        <input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
		
        <input type="submit" name="submit_image_selector" value="Save" class="button-primary">
    </form>
	
    <button type="button" id="mpbp_hidden_image_form_btn" value="">insert to Form</button>
<?php
$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
    ?><script type='text/javascript'>
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
	