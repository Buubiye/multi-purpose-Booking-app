<?php

/*
* add new user roles for this plugin
*/

 add_action('plugins_loaded', function(){
	add_role('mpbp_client', 'Mpbp Client' , $mpbp_client_caps);
 });