<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    HTML page action Class pulling data for JS Chart from sqlDB.
    This page stores the needed class and his usage on lines 30-31
    --------------------------------------------------------------
	Using 'Wrapper' that contains all needed  
	includes, session name, headers to move to,
    strings and rules.
	** On lines 16-17 unwrapping stored data to variables for 
       more simpler use.
	--------------------------------------------------------------
*/
require_once('Wrapper.php');
class chartData extends WrappingClass{
	public function dataToJS()
	{   
        $tagData=$this->tagMap;  // unpacking data
        $t=$this->T;
        
        $sql=new dbClass($tagData[$t['sA']][$t['u']]);  // connecting to sqlDB

        // Pulling all neede data for JS chart and setting change 
        // "isset($tagData[$t['sA']][$t['fAS']])?$tagData[$t['sA']][$t['fAS']]:null"
        // used for delaying feeding alarm as long as user connected to the site
        $entry=$sql->chartQuery($tagData[$t['sA']][$t['m']],isset($tagData[$t['sA']][$t['fAS']])?$tagData[$t['sA']][$t['fAS']]:null);
        if($entry!==false){
            echo json_encode($entry);  // if data exist echo it to JS page (cached in js/chart.js)
        }
        exit;
    }
}
// chartData Activation.
$chartData=new chartData(basename(__FILE__,p));
$chartData->dataToJS();
?>