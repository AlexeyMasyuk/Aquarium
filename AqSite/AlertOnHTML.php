<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
   Page used to show messages on "HTML" pagees.
   Echoing message stored in session under flag tag
*/
require_once('Classes/sessionHandler.php');
// Checking if some message flag rised
if($msg=sessionClass::sessionPull(array('flag')))
{
   echo $msg['flag']; // Print the error ocured
   sessionClass::sessionUnset('flag');
}
?>