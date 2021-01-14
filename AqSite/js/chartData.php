<?php
require_once('../dbClass.php');
require_once('../TextAndMSG.php');
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    $msg=$_SESSION['msg'];
}
$sql=new dbClass($user);
$entry=$sql->chartQuery($msg,$_SESSION['feedAlertSkip']);
echo json_encode($entry);
?> 