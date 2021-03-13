<?php
require_once('../Page/Page.php');
class Registration extends Page{
    private $sql;

    private function validation($postArr,$msg,$t,$tm)
    {
        foreach($postArr as $key=>$val){
            $failStr.=(($tmp=Validation::userParamValidation($key,$val,$tm[$t['r']],$msg))!==true)?$tmp:null;
        }
        $user=new User($postArr[$t['un']],passHash($postArr[$t['up']]),$postArr[$t['fn']],$postArr[$t['ln']],$postArr[$t['e']]);


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
        $msg=new TextMssg($tm[$t['t']][$t['m']]);  

        $failStr=self::validation($postArr,$msg,$t,$tm);

        if($failStr==='')
        {
            $this->sql->userCreate();
            sendMail($_POST[$t['e']]);
            $this->MoveTo($tm[$t['h']][$t['b']]);
        }
        
        sessionClass::sessionPush(array($t['f']=>$failStr));
        $this->MoveTo($tm[$t['h']][$t['a']]);
/*
        {         // Creating new object to save user entered data
            $user=new User($_POST[$t['un']],passHash($_POST[$t['up']]),$_POST[$t['fn']],$_POST[$t['ln']],$_POST[$t['e']]);
            $sql=new dbClass($user);    // Creating new object to connect to DataBase 
            
            if(!$sql->userExists($t['oU'])) // If entered username NOT exists in DataBase
            {
                if($sql->userCreate())       // dbClass function to enter user data to DataBaes
                {
                    sendMail($_POST[$t['e']]);                // Send mail for secssesful user creation
                    $this->MoveTo($tm[$t['h']][$t['b']]);     // Redirect to data generator file  
                }
                else // If entered data not saved in DataBase show relevant massege 
                {    // and redirect back to registration page
                    sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['qA'])));
                    $this->MoveTo($tm[$t['h']][$t['a']]);
                }
            }
            else    // If entered username already exists in DataBase show relevant massege 
            {      // and redirect back to registration page
                sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['uE'])));
                $this->MoveTo($tm[$t['h']][$t['a']]);
            }
        }
        else      // If entered username cannot be a table name in DataBase show relevant massege
        {        // and redirect back to registration page
            sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['cBU'])));
            $this->MoveTo($tm[$t['h']][$t['a']]);
        }
*/
    }
}

$reg=new Registration(basename(__FILE__,".php"));
$p=$_POST;
$reg->RegistrationAct($p);
?>