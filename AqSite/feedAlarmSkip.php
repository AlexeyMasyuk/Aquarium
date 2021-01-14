<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
$_SESSION['feedAlertSkip']=true;
header('Location:dataTbl.php');
?>