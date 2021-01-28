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
<h1> Add New Services </h1>
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
    ?><form method='post'>
        <div class='image-preview-wrapper'>
            <img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' width='200'>
        </div>
        <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
        <input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
		
        <input type="submit" name="submit_image_selector" value="Save" class="button-primary">
    </form>
<?php
$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
    ?><script type='text/javascript'>
        jQuery( document ).ready( function( $ ) {
            // Uploading files
            var file_frame;
            var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
            var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
            jQuery('#upload_image_button').on('click', function( event ){
                event.preventDefault();
                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    // Set the post ID to what we want
                    file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                    // Open frame
                    file_frame.open();
                    return;
                } else {
                    // Set the wp.media post id so the uploader grabs the ID we want when initialised
                    wp.media.model.settings.post.id = set_to_post_id;
                }
                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select a image to upload',
                    button: {
                        text: 'Use this image',
                    },
                    multiple: false // Set to true to allow multiple files to be selected
                });
                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();
                    // Do something with attachment.id and/or attachment.url here
                    $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
                    $( '#image_attachment_id' ).val( attachment.id );
                    // Restore the main post ID
                    wp.media.model.settings.post.id = wp_media_post_id;
                });
                    // Finally, open the modal
                    file_frame.open();
            });
            // Restore the main ID when the add media button is pressed
            jQuery( 'a.add_media' ).on( 'click', function() {
                wp.media.model.settings.post.id = wp_media_post_id;
            });
        });
    </script>