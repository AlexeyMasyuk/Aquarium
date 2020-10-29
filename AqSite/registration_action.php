 
<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('dbClass.php');
require_once('userClass.php');
require_once('classMSG.php');
require_once('functions.php');
session_start();

$msg=new MSG();    // Creating new object to throw relevant masseges
if(nameCheck($_POST['uname'])) // If entered name is possible (first char not a number)
{         // Creating new object to save user entered data
	$user=new User($_POST['uname'],$_POST['pword'],$_POST['fname'],$_POST['lname'],$_POST['email']);
	$sql=new dbClass($user);    // Creating new object to connect to DataBase 
	
	if(!$sql->userExists("onlyUser")) // If entered username NOT exists in DataBase
	{
		if($sql->userCreate())       // dbClass function to enter user data to DataBaes
		{
			sendMail($_POST['email']);                // Send mail for secssesful user creation
			$_SESSION['dataCreate']=$_POST['uname'];  // Save user entered data for generate data in user table
	    	header('Location:indexAq.php');    // Redirect to data generator file
	    	exit;   
		}
		else // If entered data not saved in DataBase show relevant massege 
		{    // and redirect back to registration page
		
			$_SESSION['flag']=$msg->getQueryError();
			header('Location:registration.php');
			exit;
		}
	}
	else    // If entered username already exists in DataBase show relevant massege 
	{      // and redirect back to registration page
	
		$_SESSION['flag']=$msg->getUserExist();
		header('Location:registration.php');
		exit;
	}
}
else      // If entered username cannot be a table name in DataBase show relevant massege
{        // and redirect back to registration page

	$_SESSION['flag']=$msg->getCannotBeUser();
	header('Location:registration.php');
	exit;
}
?>