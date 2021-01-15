<?php
require_once('dbClass.php');
require_once('TextAndMSG.php');
require_once('sessionHandler.php');

define('wantedSessions', array(
    'user',
    'msg',
    'feedAlertSkip'
));
$sessionArr=sessionClass::sessionPull(wantedSessions,false);


$sql=new dbClass($sessionArr['user']);
$entry=$sql->chartQuery($sessionArr['msg'],$sessionArr['feedAlertSkip']);
echo json_encode($entry);
?> 