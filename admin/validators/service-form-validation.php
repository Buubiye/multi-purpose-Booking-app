<?php

/*
* Used for service's form validation 
*/
if (! defind(ABSPATH){
	die;
}
 class post_request
 {
	 function print_name()
	 {
 if(isset($_POST['name']))
 {
	 echo $_POST['name'];
 }
	 }
	 
 }
 
 $poster = new post_request();
 $poster->print_name();
