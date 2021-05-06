<?php
require_once('Wrapper.php');
class Registration extends WrappingClass{
    private $sql;

    private function validation($postArr,$msg,$t,$tm)
    {
        foreach($postArr as $key=>$val){
            $failStr.=(($tmp=Validation::userParamValidation($key,$val,$msg))!==true)?$tmp:null;
        }
        $user=new User($postArr[$t['un']],PnM::passHash($postArr[$t['up']]),$postArr[$t['fn']],$postArr[$t['ln']],$postArr[$t['e']]);


        $this->sql=new dbClass($user);    // Creating new object to connect to DataBase 
        if($this->sql->userExists($t['oU'])){
            $failStr.=$msg->getMessge($t['uE']);
        }
        return isset($failStr)?$failStr:null;
    }

	public function RegistrationAct($postArr)
	{   
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=new TextMssg();  

        $failStr=self::validation($postArr,$msg,$t,$tm);

        if($failStr==='')
        {
            if($this->sql->userCreate()){
                PnM::sendMail($_POST[$t['e']]);
                $this->MoveTo($tm[$t['h']][$t['b']]);
            }
            sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['tce'])));
            $this->MoveTo($tm[$t['h']][$t['a']]);
            
        }
        
        sessionClass::sessionPush(array($t['f']=>$failStr));
        $this->MoveTo($tm[$t['h']][$t['a']]);

    }
}

$reg=new Registration(basename(__FILE__,".php"));
$p=$_POST;
$reg->RegistrationAct($p);
?>