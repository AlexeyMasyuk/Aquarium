<?php
require_once('../Page/Page.php');
class SettingsChange extends Page{

    public function SettingsChangeAct($postArr){
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=$tm[$t['sA']][$t['m']]; 
        $r=$tm[$t['r']];

        $notChoosen=true;
        $failStr="";
        foreach ($postArr as $key=>$val)
        {
            if(strpos($key,$t['C'])){
                $notChoosen=false;
                if(strpos($key,$t['fA'])!==false){
                    $postArr=dateTimeHandler::defaultFeedTimeAlert($val,$postArr);
                }
                $failStr.=(($tmp=Validation::userParamValidation($val,$postArr[$val],$r,$msg,true))!==true)?$tmp:"";
                if($failStr===""){
                    $dataArr[$val]=$postArr[$val];
                }
            }
        }
        if (isset($dataArr)&&!$notChoosen){
            $this->ChangeSettings($dataArr,$tm,$t);
        }
        $this->BadInp($failStr,$notChoosen,$msg,$tm,$t);
        
    }

    public function ChangeSettings($dataArr,$tm,$t){    
        $sql=new dbClass($tm[$t['sA']][$t['u']]);
        foreach ($dataArr as $key=>$val)
            $sql->change((strpos('pass',$key)!==false)?$val=passHash($val):$val,$key);
        $this->MoveTo($tm[$t['h']][$t['mn']]);
    }

    public function BadInp($failStr,$notChoosen,$msg,$tm,$t){

        if($notChoosen){
            $failStr=$msg->getMessge("NC");
        }
        sessionClass::sessionPush(array($t['f']=>$failStr));
        $this->MoveTo($tm[$t['h']][$t['a']]);
    }
}
$stCng=new SettingsChange(basename(__FILE__,".php"));
$p=$_POST;
$stCng->SettingsChangeAct($p);
?>