
<?php
require_once('includeNpath.php');
$tagMap=getIncludeNpathData(basename(__FILE__,".php"));
$T=$tagMap['tagsNstrings'];

$msg=new TextMssg($tagMap[$T['t']][$T['m']]);   // Creating new object to throw relevant masseges
if(isset($_POST[$T['p']])&&isset($_POST[$T['un']]))
{
	$user=new User($_POST[$T['un']],$_POST[$T['p']]); // Creating new object to save user entered data
	$sql=new dbClass($user);                         // Creating new object to connect to DataBase 
	if($sql->userExists())   // If entered data exists in DataBase
	{
		$rulesArr=fileHandler::Pull($tagMap[$T['t']][$T['r']]);

		sessionClass::sessionPush(array($T['u']=>$user,$T['m']=>$msg));
		header($tagMap[$T['h']][$T['mn']]);
		exit;
	}
	else     // If entered data not exists in DataBase, show relevant massage from Object
	{
		sessionClass::sessionPush(array($T['f']=>$msg->getMessge($T['w'])));
    }
}
// echo "<pre>";
// print_r($tagMap);
// echo "<pre>";
	header($tagMap[$T['h']][$T['b']]); // For case POST passed empty or not set
	exit; 
?>
