<?php
require_once('dbClass.php');

if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    $defaultAlarms=$_SESSION['rulesArr']['defaultAlarms'];
}

$sql=new dbClass($user);
foreach ($defaultAlarms as $key=>$val){
        $sql->change($val,$key);
    }
    header('Location:dataTbl.php');
?>