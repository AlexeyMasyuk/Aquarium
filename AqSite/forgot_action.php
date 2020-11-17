<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('dbClass.php');
require_once('userClass.php');
require_once('classMSG.php');
require_once('functions.php');
session_start();

$msg=new MSG();    // Creating new object to throw relevant masseges
if(isset($_POST['uname'])) // If entered name is possible (first char not a number)
{         // Creating new object to save user entered data
	$user=new User($_POST['uname'],"");
	$sql=new dbClass($user);    // Creating new object to connect to DataBase 
	
	if($mail=$sql->userExists("forgot")) // If entered username NOT exists in DataBase
	{
        $sql->passUp(newPass($mail),$user->getUserName());
        
        header('Location:indexAq.php');    // Redirect to data generator file
        exit; 
	}
	else    // If entered username already exists in DataBase show relevant massege 
	{      // and redirect back to registration page
	
		$_SESSION['flag']=$msg->getUserExist();
		header('Location:registration.php');
		exit;
	}
}
?>