<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control System

require_once("includeNpath.php");
$tagMap=getIncludeNpathData(basename(__FILE__,".php"));
$T=$tagMap['tagsNstrings'];

$msg=new TextMssg($tagMap[$T['t']][$T['m']]);   // Creating new object to throw relevant masseges
if(isset($_POST[$T['un']])) // If entered name is possible (first char not a number)
{         // Creating new object to save user entered data
	$user=new User($_POST[$T['un']],"");
	$sql=new dbClass($user);    // Creating new object to connect to DataBase 
	
	if($mail=$sql->userExists($T['ft'])) // If entered username NOT exists in DataBase
	{
        $sql->change(newPass($mail),$T['p']);
        
        header($tagMap[$T['h']][$T['b']]);    // Redirect to data generator file
        exit; 
	}
	else    // If entered username already exists in DataBase show relevant massege 
	{      // and redirect back to registration page
		sessionClass::sessionPush(array($T['f']=>$msg->getMessge($T['fNUM'])));
		header($tagMap[$T['h']][$T['a']]);
		exit;
	}
}
?>