<?php
function getIncludeNpathData($location,$session=false){
    require_once('fileHandler.php');
    $tagMap=fileHandler::Pull('PageTagMap.txt',false);
    foreach($tagMap[$location]['include'] as $val){
	    require_once($val);
    }
    if($session){
        require_once('sessionHandler.php');
        $tagMap[$location]['sessArr']=sessionClass::sessionPull($tagMap[$location]['wantedSess']);
    }
    return $tagMap[$location];
}
?>