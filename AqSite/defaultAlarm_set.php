<?php
require_once("includeNpath.php");
$tagMap=getIncludeNpathData(basename(__FILE__,".php"),true);
$T=$tagMap['tagsNstrings'];

$defaultAlarms=$tagMap[$T['sA']][$T['rA']][$T['dA']];
$sql=new dbClass($tagMap[$T['sA']][$T['u']]);
foreach ($defaultAlarms as $key=>$val){
    $sql->change($val,$key);
}

header($tagMap[$T['h']][$T['mn']]);
exit;
?>