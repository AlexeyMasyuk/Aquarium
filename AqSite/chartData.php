<?php
require_once("includeNpath.php");
$tagMap=getIncludeNpathData(basename(__FILE__,".php"),true);
$T=$tagMap['tagsNstrings'];

$sql=new dbClass($tagMap[$T['sA']][$T['u']]);
$entry=$sql->chartQuery($tagMap[$T['sA']][$T['m']],isset($tagMap[$T['sA']][$T['fAS']])?$tagMap[$T['sA']][$T['fAS']]:null);

echo json_encode($entry);
exit;
?> 