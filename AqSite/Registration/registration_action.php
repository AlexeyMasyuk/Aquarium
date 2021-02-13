 <?php
require_once("RegistrationClass.php");
$reg=new Registration(basename(__FILE__,".php"));
$reg->RegistrationAct();
?>