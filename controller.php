<?php
global $value;
  class controller{
	  // this variable 'value' stores values of the calculator
	  // calculates the value
	  public function calculator($num1, $num2, $sign, $getValue){
		  switch ($sign){
			  case 'Add':
			    $getValue = $num1 + $num2;
				break;
		      case 'Subtract':
			     $getValue = $num1 - $num2;
				 break;
			  Default:
			  echo "no value found";
	  }
  }
	  public function getValue(){
			 return $value;
	  }
	  public function signup(){
		  
	  }
  }
  
  $numb1 = $_GET['num1'];
  $numb2 = $_GET['num2'];
  $signt = $_GET['sign'];
  $calculator = new controller();
  $calculator->calculator($numb1, $numb2, $signt);
  echo $calculator->getValue();
  include 'view.php';

//create a form controller
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["website"])) {
    $website = "";
  } else {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL";
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
