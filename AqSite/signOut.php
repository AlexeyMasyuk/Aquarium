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

// if (isset($_SERVER['HTTP_COOKIE'])) {
//     $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
//     foreach($cookies as $cookie) {
//         $parts = explode('=', $cookie);
//         $name = trim($parts[0]);
//         setcookie($name, '', time()-1000);
//         setcookie($name, '', time()-1000, '/');
//     }
// }

recUnset($GLOBALS);
//recUnset($_COOKIE);

header('Location:indexAq.php');
?>