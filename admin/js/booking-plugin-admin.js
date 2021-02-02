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

     /*document.querySelector('#h11').onclick = function(){
	 //$('#wpbody-content > h1').hide();
	 console.log('axmed Nuur is watching');
	 }*/
	 alert('hello world 222');
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

});
