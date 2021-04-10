<?php
require_once('ActWrap.php');
class chartData extends Page{
	public function dataToJS()
	{   
        $tagData=$this->tagMap;
        $t=$this->T;
        
        $sql=new dbClass($tagData[$t['sA']][$t['u']]);
        $entry=$sql->chartQuery($tagData[$t['sA']][$t['m']],isset($tagData[$t['sA']][$t['fAS']])?$tagData[$t['sA']][$t['fAS']]:null);
        echo json_encode($entry);
        exit;
    }
}
$chartData=new chartData(basename(__FILE__,".php"));
$chartData->dataToJS();
?>