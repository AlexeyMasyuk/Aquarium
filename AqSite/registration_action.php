 <?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control System
// require_once('dbClass.php');
// require_once('userClass.php');
// require_once('TextAndMSG.php');
// require_once('functions.php');
// require_once('sessionHandler.php');
require_once("includeNpath.php");
$tagMap=getIncludeNpathData(basename(__FILE__,".php"));
$T=$tagMap['tagsNstrings'];

$msg=new TextMssg($tagMap[$T['t']][$T['m']]);  

if(nameCheck($_POST[$T['un']])) // If entered name is possible (first char not a number)
{         // Creating new object to save user entered data
	$user=new User($_POST[$T['un']],passHash($_POST[$T['up']]),$_POST[$T['fn']],$_POST[$T['ln']],$_POST[$T['e']]);
	$sql=new dbClass($user);    // Creating new object to connect to DataBase 
	
	if(!$sql->userExists($T['oU'])) // If entered username NOT exists in DataBase
	{
		if($sql->userCreate())       // dbClass function to enter user data to DataBaes
		{
			sendMail($_POST[$T['e']]);                // Send mail for secssesful user creation
	    	header($tagMap[$T['h']][$T['b']]);    // Redirect to data generator file
	    	exit;   
		}
		else // If entered data not saved in DataBase show relevant massege 
		{    // and redirect back to registration page
			sessionClass::sessionPush(array($T['f']=>$msg->getMessge($T['qA'])));
			header($tagMap[$T['h']][$T['a']]);
			exit;
		}
	}
	else    // If entered username already exists in DataBase show relevant massege 
	{      // and redirect back to registration page
		sessionClass::sessionPush(array($T['f']=>$msg->getMessge($T['uE'])));
		header($tagMap[$T['h']][$T['a']]);
		exit;
	}
}
else      // If entered username cannot be a table name in DataBase show relevant massege
{        // and redirect back to registration page
	sessionClass::sessionPush(array($T['f']=>$msg->getMessge($T['cBU'])));
	header($tagMap[$T['h']][$T['a']]);
	exit;
}
?>