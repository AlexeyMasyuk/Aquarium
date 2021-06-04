<?php
require_once("Classes/dbClass.php");
require_once("Classes/userClass.php");

// if(isset($_POST["data"])){
    // $data = $_POST["data"];
    $data = "ar,qweqwe123123";
	
	$pieces = explode(",", $data);
    $user=new User($pieces[0],$pieces[1]);
    $sql = new dbClass($user);

	if($validation=$sql->arduinoUserValidation())
	{
		echo $validation;
	}
// }
?>