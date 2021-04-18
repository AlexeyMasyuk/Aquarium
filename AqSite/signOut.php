<?php
require_once('Classes/sessionHandler.php');
sessionClass::sessionDestroy();

function print_var_name($var) {
    foreach($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }

    return '!';
}

function recUnset(&$array){
    if(!isset($array)){
        return;
    }
    foreach($array as &$val){
        if ( is_array($val) && print_var_name($val)!='GLOBALS') {
            recUnset($val);
        }
        $val=null;
        unset($val);
    }
}

recUnset($GLOBALS);
recUnset($_COOKIE);

header('Location:indexAq.php');
?>