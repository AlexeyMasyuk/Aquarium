
<?php
require_once('dbClass.php');
require_once('userClass.php');
require_once('TextAndMSG.php');
require_once('fileHandler.php');
require_once('functions.php');
require_once('sessionHandler.php');

$msg=new TextMssg("MessageBank.txt");   // Creating new object to throw relevant masseges
if(isset($_POST['uname'])&&isset($_POST['pword']))
{
	$user=new User($_POST['uname'],$_POST['pword']); // Creating new object to save user entered data
	$sql=new dbClass($user);                         // Creating new object to connect to DataBase 
	if($sql->userExists())   // If entered data exists in DataBase
	{
		$rulesArr=fileHandler::rulesPull('inputRules.txt');

		sessionClass::sessionPush(array('user'=>$user,'msg'=>$msg,'rulesArr'=>$rulesArr));
        header('Location:dataTbl.php');
		// header('Location:dataTbl.php');  // Redirect to main page
		exit;
	}
	else     // If entered data not exists in DataBase, show relevant massage from Object
	{
		sessionClass::sessionPush(array('flag'=>$msg->getMessge("Wrong")));
    }
}
	header('Location:indexAq.php'); // For case POST passed empty or not set
	exit; 
?>
