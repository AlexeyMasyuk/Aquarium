<?php
require_once('../Page/Page.php');
class Registration extends Page{
	public function RegistrationAct()
	{   
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=new TextMssg($tm[$t['t']][$t['m']]);  

        if(nameCheck($_POST[$t['un']])) // If entered name is possible (first char not a number)
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
    }
}
?>