<?php
require_once('Classes/sessionHandler.php');

sessionClass::sessionPush(array('feedAlertSkip'=>true));

header('Location:dataTbl.php');
?>