<?php
require_once("chartDataClass.php");
$chartData=new chartData(basename(__FILE__,".php"));
$chartData->dataToJS();
?> 