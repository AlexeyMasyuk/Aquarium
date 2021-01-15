<?php
require_once('sessionHandler.php');
sessionClass::sessionDestroy();

header('Location:indexAq.php');
?>