<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('dbClass.php');
require_once('userClass.php');
require_once('TextAndMSG.php');
require_once('functions.php');
require_once('sessionHandler.php');

define('wantedSessions', array(
    'msg'
));
$sessionArr=sessionClass::sessionPull(wantedSessions);



if(isset($_POST['uname'])) // If entered name is possible (first char not a number)
{         // Creating new object to save user entered data
	$user=new User($_POST['uname'],"");
	$sql=new dbClass($user);    // Creating new object to connect to DataBase 
	
	if($mail=$sql->userExists("forgot")) // If entered username NOT exists in DataBase
	{
        $sql->change(newPass($mail),"pass");
        
        header('Location:indexAq.php');    // Redirect to data generator file
        exit; 
	}
	else    // If entered username already exists in DataBase show relevant massege 
	{      // and redirect back to registration page
	
		sessionClass::sessionPush(array('flag'=>$sessionArr['msg']->getMessge("forgotNoUserMatch")));
		header('Location:forgot.php');
		exit;
	}
}
?>