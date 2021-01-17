<?php
require_once('dbClass.php');
require_once('TextAndMSG.php');
require_once('userClass.php');
require_once('functions.php');
include_once('fileHandler.php');
require_once('sessionHandler.php');
require_once('dateTimeHandler.php');

define('wantedSessions', array(
    'user',
    'rulesArr',
    'msg'
));
$sessionArr=sessionClass::sessionPull(wantedSessions);
$settChgeRules=$sessionArr['rulesArr']['settChgeValidation'];

$sql=new dbClass($sessionArr['user']);

$dataArr=array();
$notChoosen=true;

function badInputMassegeChoose($val,$sessionArr){
    $messageName="ChangeBadInput";
    if(strpos($val,"ph")!==false)
        $flagMsg.="<br>".$sessionArr['msg']->getMessge("ph".$messageName);
    else if(strpos($val,"temp")!==false)
        $flagMsg.="<br>".$sessionArr['msg']->getMessge("temp".$messageName);
    else
        $flagMsg.="<br>".$sessionArr['msg']->getMessge($val.$messageName);
    return $flagMsg;
}

// val is a key for wanted data ex: array('emailCheckbox' => "email", 'email' => "alex@mail.com") 
foreach ($_POST as $key=>$val)
{
    if(strpos($key,"Checkbox")){
        $notChoosen=false;
        if(strpos($key,"feedAlert")!==false){
            $_POST=dateTimeHandler::defaultFeedTimeAlert($val,$_POST);
        }
        if(strlen($_POST[$val])>0){
            if($valid=settChgeValidation($val,$_POST[$val],$settChgeRules)){
                $dataArr[$val]=$_POST[$val];               
            }
            if(!$valid){
                $flagMsg.=badInputMassegeChoose($val,$sessionArr);
             }
        }
        else{
            if(!strpos($flagMsg,"fill")){
                $flagMsg.="<br>".$sessionArr['msg']->getMessge("EmptyFieldChangeBadInput");
            }           
        }   
    }
}


if($notChoosen){
    sessionClass::sessionPush(array('flag'=>"<br>".$sessionArr['msg']->getMessge("NotChoosenChangeBadInput")));  
	header('Location:settChng.php');
	exit;
}
else if(isset($flagMsg)){
    sessionClass::sessionPush(array('flag'=>$flagMsg));  
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