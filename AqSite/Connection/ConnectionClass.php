<?php
require_once('../Page/Page.php');
class Connection extends Page{
	public function ConnectionValidation()
	{   
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=new TextMssg($tm[$t['t']][$t['m']]);   // Creating new object to throw relevant masseges
        if(isset($_POST[$t['p']])&&isset($_POST[$t['un']]))
        {
            $user=new User($_POST[$t['un']],$_POST[$t['p']]); // Creating new object to save user entered data
            $sql=new dbClass($user);                         // Creating new object to connect to DataBase 
            if($sql->userExists())   // If entered data exists in DataBase
            {
                // $rulesArr=fileHandler::Pull($tagMap[$t['t']][$t['r']]);
        
                sessionClass::sessionPush(array($t['u']=>$user,$t['m']=>$msg));
                $this->MoveTo($tm[$t['h']][$t['mn']]);
            }
            else     // If entered data not exists in DataBase, show relevant massage from Object
            {
                sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['w'])));
            }
        }
        $this->MoveTo($tm[$t['h']][$t['b']]);
    }
}
?>