<?php
require_once("../Classes/userClass.php");
require_once("../Classes/dbClass.php");

if(isset($_POST["data"])){
    $data = $_POST["data"];
    //$data = "ar,qweqwe123123";
	
	$pieces = explode(",", $data);
    $user=new User($pieces[0],$pieces[1]);
    $sql = new dbClass($user);

	if($validation=$sql->arduinoUserValidation())
	{
		echo $validation;
	}
}
else if(isset($_POST["push"])){
	$sp=explode(',',$_POST["push"]);
	$user=new User($sp[count()-1],"");
	unset($sp[count()-1]);
    $sql = new dbClass($user);
	$sql->arduinoPush($data);
}
?>