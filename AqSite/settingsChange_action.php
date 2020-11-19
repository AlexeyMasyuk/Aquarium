<?php
require_once('dbClass.php');
require_once('userClass.php');

if(session_status() == PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}
$sql=new dbClass($user);

foreach ($_POST as $key=>$val)
{
    if(strlen($val)>0){
        $sql->change($_POST[$key],$key);
    }
}

?>