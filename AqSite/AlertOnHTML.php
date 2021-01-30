<?php
require_once('sessionHandler.php');
// Checking if some error flag returned from connection_action.php page
if($msg=sessionClass::sessionPull(array('flag'),false))
{
   echo $msg['flag']; // Print the error ocured
   sessionClass::sessionUnset('flag');
}
?>