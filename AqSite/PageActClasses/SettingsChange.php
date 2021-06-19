<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    HTML page action Class that handling user setings change.
    --------------------------------------------------------------
	Using 'Wrapper' that contains all needed  
	includes, session name, headers to move to,
    strings and rules.
	** On lines 21-23 unwraping stored data to variables for 
       more simpler use.
	--------------------------------------------------------------
*/
require_once('Wrapper.php');
class SettingsChange extends WrappingClass{

    // Main class function, activating other metods for checking valid input,
    // changing user's relevant settings or throwing needed error message if input incorrect
    // Need $_POST contains user input, not returning anything,
    // ChangeSettings() or BadInp() methods navigating to needed page.
    public function SettingsChangeAct($postArr){
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=$tm[$t['sA']][$t['m']]; 
        
        $notChoosen=true;
        $failStr="";

        foreach ($postArr as $key=>$val)
        {
            $failStr.=$this->ValidateAndSave($dataArr,$postArr,$msg,$tm,$t,$notChoosen,$key,$val);
        }
        if (isset($dataArr)&&!$notChoosen&&$failStr===""){
            $this->ChangeSettings($dataArr,$tm,$t);
        }
        $this->BadInp($failStr,$notChoosen,$msg,$tm,$t);
        
    }

    // Functon validating if user's input is correct, $key what to change $val the new value.
    //  $msg,$tm,$t -> unwrapped class data, 
    // $notChoosen flag pointing if no settings chosen to change on checkbox.
    public function ValidateAndSave(&$dataArr,$postArr,$msg,$tm,$t,&$notChoosen,$key,$val){
        if(strpos($key,$t['C'])){  // checking if checkbox chosen, value contain the neede input tag 
            $notChoosen=false;
            if(strpos($key,$t['fA'])!==false){           // if feeding alert choosen adjust the data (current date saved)
                
                $tmp=dateTimeHandler::feedingAlarmSet($postArr[$val]);
                $postArr[$val]=$tmp;
            }
            // validating user input and geting needed fail message.
            $failStr.=(($tmp=Validation::userParamValidation($val,$postArr[$val],$msg,true))!==true)?$tmp:"";

            if($failStr===""){
                $dataArr[$val]=$postArr[$val];  // if no fail mesage store the input
            }
            return $failStr;
        }
    }

    // Functin connecting to sqlDB and changing the wanted data stored in $dataArr.
    // If password given, hash it before storing.
    // moving back to main page after change.
    // $tm,$t -> unwrapped class operating data
    public function ChangeSettings($dataArr,$tm,$t){    
        $sql=new dbClass($tm[$t['sA']][$t['u']]);
        foreach ($dataArr as $key=>$val)
            {
                $sql->change((strpos($t['ps'],$key)!==false)?$val=PnM::passHash($val):$val,$key);
            }
        $this->MoveTo($tm[$t['h']][$t['mn']]);
    }

    // Function handling bad input from the user,
    // storing relevant message on session['flag'] to be shown on HTML.
    // $notChoosen -> flag indicating no checkbox chosen to change.
    // $failStr -> stored bad input messages from ValidateAndSave().
    // $tm,$t,$msg -> unwrapped class operating data.
    // reloading current page
    public function BadInp($failStr,$notChoosen,$msg,$tm,$t){
        if($notChoosen){
            $failStr=$msg->getMessge("NC");
        }
        sessionClass::sessionPush(array($t['f']=>$failStr));
        $this->MoveTo($tm[$t['h']][$t['a']]);
    }
}

// SettingsChange Activation and $_POST reassigning
$stCng=new SettingsChange(basename(__FILE__,p));
$p=$_POST;
$stCng->SettingsChangeAct($p);
?>