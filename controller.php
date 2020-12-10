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

//create the first form and form validation system
?>
