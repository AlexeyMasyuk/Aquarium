<?php
include_once('fileHandler.php');
//Alexey Masyuk,Yulia Berkovich Aquarium Control System

function passHash($pass){
	return password_hash($pass, PASSWORD_DEFAULT);
}

function passCheck($pass,$cryptPass){
	return password_verify($pass,$cryptPass);
}

function PassGen(){
	$pass;
	for($i=0;$i<3;$i++){
		$pass.=chr(rand(48,57));
		$pass.=chr(rand(65,90));
		$pass.=chr(rand(97,122));
	}
	return $pass;
}

function newPass($mail){
	$pass=PassGen();
	$subject="Aquarium New Pass!";
	$message="Hello! You'r new passyord is: ".$pass;
	$headers="From: AquariumControlSystem@from_mail";
	mail($mail,$subject,$message,$headers);
	return passHash($pass);
}

function sendMail($mail){
	$subject="Welcome!";
	$message="Welcome!Registration completed successfully!";
	$headers="From: AquariumControlSystem@from_mail";
	mail($mail,$subject,$message,$headers);
}
?>