<?php
require_once('Wrapper.php');
class SettingsChange extends WrappingClass{

    public function SettingsChangeAct($postArr){
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=$tm[$t['sA']][$t['m']]; 
        // $r=$tm[$t['r']];
        
        $notChoosen=true;
        $failStr="";
        
        foreach ($postArr as $key=>$val)
        {
            if(strpos($key,$t['C'])){
                $notChoosen=false;
                if(strpos($key,$t['fA'])!==false){
                    $tmp=dateTimeHandler::feedingAlarmSet($postArr[$val]);
                    $postArr[$val]=$tmp;
                }
                $failStr.=(($tmp=Validation::userParamValidation($val,$postArr[$val],$msg,true))!==true)?$tmp:"";
                if($failStr===""){

                    $dataArr[$val]=$postArr[$val];
                }
            }
        }
        if (isset($dataArr)&&!$notChoosen&&$failStr===""){
            $this->ChangeSettings($dataArr,$tm,$t);
        }
        $this->BadInp($failStr,$notChoosen,$msg,$tm,$t);
        
    }

    public function ChangeSettings($dataArr,$tm,$t){    
        $sql=new dbClass($tm[$t['sA']][$t['u']]);
        foreach ($dataArr as $key=>$val)
            {
                $sql->change((strpos($t['ps'],$key)!==false)?$val=PnM::passHash($val):$val,$key);
            }
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