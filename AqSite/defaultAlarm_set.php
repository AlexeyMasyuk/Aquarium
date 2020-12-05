<?php
require_once('dbClass.php');
require_once('classMSG.php');

if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}

$sql=new dbClass($user);
$alarm=array('phHigh'=>"7.5",'phLow'=>"6.5",'tempHigh'=>"25",'tempLow'=>"23");
foreach ($alarm as $key=>$val){
        $sql->change($val,$key);
    }
    header('Location:dataTbl.php');
?>