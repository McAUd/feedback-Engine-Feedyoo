<?php
ob_start(); //Turns on output buffering 


$mysqli = new mysqli("fdb1034.atspace.me", "4441160_base", "(paI6E]jv5{xzyt", "4441160_base");
$con = mysqli_connect("fdb1034.atspace.me", "4441160_base", "(paI6E]jv5{xzyt", "4441160_base"); //Connection variable

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
}

?>