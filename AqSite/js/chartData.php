<?php
require_once('../dbClass.php');
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}
$sql=new dbClass($user);
$entry=$sql->chartQuery($user->getUserName());
echo json_encode($entry);
?> 