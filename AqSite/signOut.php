<?php
require_once('Classes/sessionHandler.php');
sessionClass::sessionDestroy();
if(isset($GLOBALS)){
    foreach($GLOBALS as $val){
        unset($val);
    }
}
if(isset($_COOKIE)){
    foreach($_COOKIE as $val){
        unset($val);
    }
}

header('Location:indexAq.php');
?>