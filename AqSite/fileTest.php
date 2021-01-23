<?php
require_once("includeNpath.php");
$tagMap=getIncludeNpathData("chartData",true);
$T=$tagMap['tagsNstrings'];
echo "<pre>";
print_r(array('msg','user','rulesArr'));
print_r($T);
print_r($tagMap);
print_r(sessionClass::sessionPull(array('msg','user','feedAlertSkip')));
echo "<pre>";

// $sql=new dbClass($tagMap[$T['sA']][$T['u']]);
// $entry=$sql->chartQuery($tagMap[$T['sA']][$T['m']],isset($tagMap[$T['sA']][$T['fAS']])?$tagMap[$T['sA']][$T['fAS']]:null);
// echo "<pre>";
// print_r($tagMap);
// echo "<pre>";
?>