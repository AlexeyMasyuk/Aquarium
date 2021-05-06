<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
   Page used to handle delay or block of feeding alert from being diplay in alarm_div.
   Destroing the session and unsetting the globals parameter.
*/
require_once('Classes/sessionHandler.php');

// If OFF varible sent via get and he equal to 1,
// user clicked the "already fed" button and the alert not needed.
// Using cookie set deticated flag for the alarm block.
// **At midnight the block canceledץ
if(isset($_GET["OFF"])&&$_GET["OFF"]=="1"){
    $cookie_name = "FA";
    $cookie_value = "OFF";
    setcookie($cookie_name,$cookie_value,strtotime('tomorrow midnight'),'/');
}

// If OFF varible NOT sent hide the alert until user will sign out.
sessionClass::sessionPush(array('feedAlertSkip'=>true));

// Back to main page
header('Location:dataTbl.php');
?>