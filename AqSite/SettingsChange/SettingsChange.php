<?php
require_once('../Page/Page.php');
class SettingsChange extends Page{
    private $sql;

    public function SettingsChangeAct($postArr){
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=$tm[$t['sA']][$t['m']]; 
        $r=$tm[$t['r']];

        $notChoosen=true;
        $failStr="";
        print_r($postArr);
        foreach ($postArr as $key=>$val)
        {
            if(strpos($key,$t['C'])){
                $notChoosen=false;
                if(strpos($key,$t['fA'])!==false){
                    $postArr=dateTimeHandler::defaultFeedTimeAlert($val,$postArr);
                }
                $failStr.=(($tmp=Validation::userParamValidation($val,$postArr[$val],$r,$msg,true))!==true)?$tmp:"";
                print_r(gettype($failStr));
                if($failStr===""){
                    $dataArr[$val]=$postArr[$val];
                }
            }
        }

        if (isset($dataArr)){
            self::ChangeSettings($dataArr);
        }
        self::BadInp($failStr,$notChoosen,$msg);
        
    }

    public function ChangeSettings($dataArr){     
        foreach ($dataArr as $key=>$val)
             $sql->change((strpos('pass',$key)!==false)?$val=passHash($val):$val,$key);
        self::MoveTo($tm[$t['h']][$t['mn']]);
    }

    public function BadInp($failStr,$notChoosen,$msg){     
        if($notChoosen){
            $failStr=$msg->getMessge("NC");
        }
        sessionClass::sessionPush(array($t['f']=>$failStr));
        self::MoveTo($tm[$t['h']][$t['mn']]);
    }
}
$stCng=new SettingsChange(basename(__FILE__,".php"));
$p=$_POST;
$stCng->SettingsChangeAct($p);
?>