<?php
require_once('../Page/Page.php');
class DefaultAlarms extends Page{
    public function DefaultAlarmsSet(){
        $tm=$this->tagMap;
        $t=$this->T;
        $sql=new dbClass($tm[$t['sA']][$t['u']]);
        foreach ($tm[$t['r']] as $key=>$val){
            $sql->change($val,$key);
        }
        $this->MoveTo($tm[$t['h']][$t['mn']]);
    }
}
?>