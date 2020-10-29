
<?php
require_once('dbClass.php');
require_once('userClass.php');
require_once('classMSG.php');
session_start();

$msg=new MSG();  // Creating new object to throw relevant masseges
if(isset($_POST['uname'])&&isset($_POST['pword']))
{
	$user=new User($_POST['uname'],$_POST['pword']); // Creating new object to save user entered data
	$sql=new dbClass($user);                         // Creating new object to connect to DataBase 
	if($sql->userExists())   // If entered data exists in DataBase
{
	$_SESSION['user']=$user;  // Save user entered data for futer actions
	header('Location:dataTbl.php');  // Redirect to main page
	exit;
}
else     // If entered data not exists in DataBase, show relevant massage from Object
{
    $_SESSION['flag']=$msg->getWrong();
   
}
}
    
	header('Location:indexAq.php'); // For case POST passed empty or not set
	exit; 
?>
