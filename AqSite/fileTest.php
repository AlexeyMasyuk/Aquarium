<?php
define('wantedSessions', array(
    'user',
    'msg',
    'feedAlertSkip'
));
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
	echo "<pre>";
    print_r($_SESION);
    print_r(wantedSessions);
	echo "<pre>";

// require_once('/functions.php');

// define('wantedSessions', array(
    // 'user',
    // 'msg',
    // 'feedAlertSkip'
// ));

// if($sessionArr=sessionPull(wantedSessions)){
    // $sql=new dbClass($sessionArr['user']);
    // $entry=$sql->chartQuery($sessionArr['msg'],$sessionArr['feedAlertSkip']);
    // echo json_encode($entry);
// }


?> 