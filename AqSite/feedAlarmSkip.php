<?php
require_once('Classes/sessionHandler.php');

if(isset($_GET["OFF"])&&$_GET["OFF"]=="1"){
    
    $cookie_name = "FA";
    $cookie_value = "OFF";
    setcookie($cookie_name,$cookie_value,strtotime('tomorrow midnight'),'/');
}

sessionClass::sessionPush(array('feedAlertSkip'=>true));

header('Location:dataTbl.php');
?>