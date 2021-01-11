<?php
require_once('dbClass.php');
require_once('TextAndMSG.php');
require_once('userClass.php');
require_once('functions.php');
include_once('fileHandler.php');

if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user'])&&isset($_SESSION['rulesArr'])&&isset($_SESSION['msg'])){
    $user=$_SESSION['user'];
    $rulesArr=$_SESSION['rulesArr']['settChgeValidation'];
    $msg=$_SESSION['msg'];
}

$sql=new dbClass($user);

$dataArr=array();
$notChoosen=true;
// val is a key for wanted data ex: array('emailCheckbox' => "email", 'email' => "alex@mail.com") 
foreach ($_POST as $key=>$val)
{
    if(strpos($key,"Checkbox")){
		$notChoosen=false;
        if(strlen($_POST[$val])>0){
            if($valid=settChgeValidation($val,$_POST[$val],$rulesArr)){
                $dataArr[$val]=$_POST[$val];               
            }
            if(!$valid){
                $messageName=$val."ChangeBadInput";
                if(strpos($val,"ph")!==false)
                    $_SESSION['flag'].="<br>".$msg->getMessge("phChangeBadInput");
                else if(strpos($val,"temp")!==false)
                    $_SESSION['flag'].="<br>".$msg->getMessge("tempChangeBadInput");
                else
                    $_SESSION['flag'].="<br>".$msg->getMessge($messageName);
             }
        }
        else{
            if(!strpos($_SESSION['flag'],"fill"))
                $_SESSION['flag'].="<br>".$msg->getMessge("EmptyFieldChangeBadInput");           
        }     
    }
}

if($notChoosen){
	$_SESSION['flag']=$msg->getMessge("NotChoosenChangeBadInput");
	header('Location:settChng.php');
	exit;
}
else if(isset($_SESSION['flag'])){
	header('Location:settChng.php');
	exit;
}
else{
	foreach ($dataArr as $key=>$val)
        $sql->change($val,$key);
	header('Location:dataTbl.php');
	exit;
}
?>