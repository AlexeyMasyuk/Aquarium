<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
   Page used to sign out the site.
   Destroing the session and unsetting the globals parameter.
*/
require_once('Classes/sessionHandler.php');
sessionClass::sessionDestroy();

// Function used to evoid recursivly loop,
// returning varieble name fromg globals , if exists, 
// and returning varible name as string.
function print_var_name($var) {
    foreach($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }
    return '!';
}
// Function unsetting all global varibles
function globalsUnset(&$array){
    if(!isset($array)){
        return;
    }
    foreach($array as &$val){
        if ( is_array($val) && print_var_name($val)!='GLOBALS') {
            $val=null;
            unset($val);
        }
    }
}
globalsUnset($GLOBALS);

// moving back to index
header('Location:indexAq.php');
?>