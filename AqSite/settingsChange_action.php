<?php

require_once('dbClass.php');
require_once('userClass.php');
require_once('functions.php');

if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}

$sql=new dbClass($user);

function validation($key,$inp){
    if($key=="email"){
        if(strpos($inp, "@")>=0&&strpos($inp, "."))
           return true;
        return false;
    }
    else if($key=="fname"||$key=="lname"){
        if (ctype_alpha(str_replace(' ', '', $inp)) === false)
            return false;
        return true;
    }
    else if($key=="ph"||$key=="temp"){
        if (is_numeric( $inp) == true)
        return true;
    return false;
    }
}

foreach ($_POST as $key=>$val)
{
    if(strlen($val)>0){
        if($key!="pass"){
            $sql->change($_POST[$key],$key);
        }
        else{
            $sql->change(passHash($_POST[$key]),$key);
        }
    }
}
header('Location:dataTbl.php');
?>