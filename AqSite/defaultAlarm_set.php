<?php
// Add to setting change, 'set to deafoult'
// Add Curent alarms view
require_once('dbClass.php');
require_once('sessionHandler.php');

define('wantedSessions', array(
    'user',
    'rulesArr'
));
$sessionArr=sessionClass::sessionPull(wantedSessions);
$defaultAlarms=$sessionArr['rulesArr']['defaultAlarms'];

$sql=new dbClass($sessionArr['user']);
foreach ($defaultAlarms as $key=>$val){
        $sql->change($val,$key);
    }
    header('Location:dataTbl.php');
?>