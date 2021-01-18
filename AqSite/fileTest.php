<?php
require_once('sessionHandler.php');
if(session_status() == PHP_SESSION_NONE){
	session_start();
}
		echo "<pre>";
		print_r(sessionClass::sessionPull(array('flag'),false)?"true":"false");
		echo "<br>SESSION<br>";
		print_r($_SESSION);
		echo "<pre>";
?>