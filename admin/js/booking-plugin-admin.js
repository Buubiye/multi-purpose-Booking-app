jQuery(document).ready(function ($){
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 /*
	 * this code validates the ['available_times'] input value using regex
	 */
	document.getElementById("available_times").addEventListener("keyup", displayDate);
    function displayDate() {
		  let regex = /\[(\d\d|\d)\:(\d\d|\d)(\s|\S)(am|pm)\s(\-|\,)\s(\d\d|\d)\:(\d\d|\d)(\s|\S)(am|pm)]/gi;
		  let mpbp_available_regex = document.getElementById("available_times").value;
		  document.getElementById('mpbp_available_times_tester').innerHTML = regex.test(mpbp_available_regex);
	  
	}
	
	/*
	* this code stores the image src attribute in one input
	*/
	var pushValues = [];
		$('#mpbp_hidden_image_form_btn').on('click', function(){
		   var imgSrcArray = document.getElementsByClassName('mpbp_new_images');
		   pushValues = []; // remove the old values
		   let i = '';
		   for(i=0; i<imgSrcArray.length; i++){
			 pushValues.push(document.getElementsByClassName('mpbp_new_images')[i].getAttribute('src'));
		   }
		   document.getElementById('pictures').value = pushValues;
		});
	
	/*
	* function for deleting unwanted images 
	*/
	$('body').on('click', '#mpbp_img_deleter', function(){
		$(this).parent().remove();
	});
	
	/*
	* make created images sortbale in services "editng" and "add new" actions
	*/
	$('.image-preview-wrapper').sortable();
	$('body').on('mouseover', '.mpbp_image_parent', function(){
	 $('.image-preview-wrapper').sortable();
	});
	
	/*
	* add a datepicker
	*/
	$('body').on('mouseover', '#date_created', function(){
	$('#date_created').datepicker();
	});
	
        var tgm_media_frame;
  
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
				$("#image-preview").after("<div class='mpbp_image_parent'><span id='mpbp_img_deleter'> &#10006 </span><img class='mpbp_new_images' style='width: 100px;' src=" +attachment.url+"></div>");
			});
		  });

		  tgm_media_frame.open();
		});
	
});
