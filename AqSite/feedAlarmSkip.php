<?php
require_once('sessionHandler.php');

sessionClass::sessionPush(array('feedAlertSkip'=>true));

header('Location:dataTbl.php');
?>