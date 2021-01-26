<?php

/*
* Used for service's form validation 
*/
/*if (! defind(ABSPATH){
	//die;
}*/
 class post_request
 {
	 function print_name()
	 {
 if(isset($_POST['name']))
 {
	 echo '<div style="margin-left: 200px">'. $_POST['name'] . '</div>';
 }
	 }
	 
 }
 
 $poster = new post_request();
 $poster->print_name();
