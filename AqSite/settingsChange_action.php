<?php

require_once('dbClass.php');
require_once('TextAndMSG.php');
require_once('userClass.php');
require_once('functions.php');

if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}

$sql=new dbClass($user);
$msg=new TextMssg("MessageBank.txt");

function validation($key,$inp){
    if($key=="email"){
        if(strpos($inp, "@")>0 && strpos($inp, ".")<strlen($inp)-1)
           return true;
        return false;
    }
    else if($key=="fname"||$key=="lname"){
        if (ctype_alpha(str_replace(' ', '', $inp)) === false)
            if(strlen($inp)>20)
                return false;
        return true;
    }
    else if($key=="tempHigh"||$key=="tempLow"){
        if (is_numeric($inp) == true)
            if(floatval($inp)<=30 && floatval($inp)>=15)
                return true;
    }
    else if($key=="phHigh"||$key=="phLow"){
        if (is_numeric( $inp) == true)
            if(floatval($inp)>=6.5 && floatval($inp)<=8)
                return true;
    }
    else if($key=="pass"){
        if(preg_match("/[a-z]/i", $inp) && preg_match('/[0-9]/', $inp))
            return true;
    }
    return false;
}


$dataArr=array();
$dataFound=false;
$notChoosen=true;
// val is a key for wanted data ex: array('phCheckbox' => "email", 'email' => "alex@mail.com") 


    foreach ($_POST as $key=>$val)
    {
        if(strpos($key,"Checkbox")){
            if(strlen($val)>0){
                $notChoosen=false;
                if(strlen($_POST[$val])>0){
                    if(($valid=validation($val,$_POST[$val]))&&$dataFound){
                        $_SESSION['flag'].="VP";
                        $dataArr[$val]=$_POST[$val];
                        $dataFound=true;
                    }
                    else if(!$valid){
                        $_SESSION['flag'].="<br>".$msg->getMessge($val."ChangeBadInput");
                        $dataFound=false;
                    }
                }
                else{
                    $dataFound=false;
                    if(!strpos($_SESSION['flag'],"fill")){
                        $_SESSION['flag'].="<br>".$msg->getMessge("EmptyFieldChangeBadInput");
                    }
                }           
            }
        }
    }

if($notChoosen){
    $_SESSION['flag']=$msg->getMessge("NotChoosenChangeBadInput");
    header('Location:settChng.php');
}
if($dataFound){
    $_SESSION['flag'].="!!";
    foreach ($dataArr as $key=>$val){
        $sql->change($val,$key);
    }
}
if(isset( $_SESSION['flag'])&&!$dataFound){
    $_SESSION['flag'].="22";
    header('Location:settChng.php');
}
else{
    $_SESSION['flag'].="33";
    //unset($_SESSION['flag']);
    header('Location:settChng.php');
}
?>