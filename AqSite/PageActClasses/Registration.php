<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    HTML page action Class that handling user registration.
    --------------------------------------------------------------
	Using 'Wrapper' that contains all needed  
	includes, session name, headers to move to,
    strings and rules.
	** On lines 23-24 unwrapping stored data to variables for 
       more simpler use.
	--------------------------------------------------------------
*/
require_once('Wrapper.php');
class Registration extends WrappingClass{
    private $sql; // storing sqlDB connection object.

    // Main class function checking if user input correct and valid,
    // storing all user credential and personal data
    // and creatin table for aquarium data.
    // On fail throwing relevan message.
	public function RegistrationAct($postArr)
	{   
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=new TextMssg();  

        $failStr=self::validation($postArr,$msg,$t,$tm);

        if($failStr==='')
        {
            UserInit($postArr,$t,$tm);

            // if UserInit fail.
            $this->badInp(array($t['f']=>$msg->getMessge($t['tce'])),$tm[$t['h']][$t['a']]);
        }
        $this->badInp(array($t['f']=>$failStr),$tm[$t['h']][$t['a']]);
    }

    // Function 'creating user', sending welcome mail
    // and navigating to index page
    private function UserInit($postArr,$t,$tm){
        if($this->sql->userCreate()){
            PnM::sendMail($postArr[$t['e']]);
            $this->MoveTo($tm[$t['h']][$t['b']]);
        }
    }

    // Function pushing error message to session to be displayed
    // and navigating to back to regstration html page
    private function badInp($ArrToPush,$whereToMove){
        sessionClass::sessionPush($ArrToPush);
        $this->MoveTo($whereToMove);
    }

    // Function validating user input, stored in $postArr.
    // Checking via rules stored in Validation wrapper
    // and alse checking if username Exists.
    // Returning relevant error message if validation fails 
    // or null if all data valid.
    private function validation($postArr,$msg,$t,$tm)
    {
        foreach($postArr as $key=>$val){
            $failStr.=(($tmp=Validation::userParamValidation($key,$val,$msg))!==true)?$tmp:null;
        }
        // hashing user password if data valid and storing in User object
        $user=new User($postArr[$t['un']],PnM::passHash($postArr[$t['up']]),$postArr[$t['fn']],$postArr[$t['ln']],$postArr[$t['e']]);


        $this->sql=new dbClass($user);    
        if($this->sql->userExists($t['oU'])){
            $failStr.=$msg->getMessge($t['uE']);
        }
        return isset($failStr)?$failStr:null;
    }
}

// Connection Activation.
$reg=new Registration(basename(__FILE__,p));
$p=$_POST;
$reg->RegistrationAct($p);
?>