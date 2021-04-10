<?php
require_once('ActWrap.php');
class Forget extends Page{
	public function ForgetAct()
	{   
        $tm=$this->tagMap;
        $t=$this->T;
        $msg=new TextMssg($tm[$t['t']][$t['m']]); 

        if(isset($_POST[$t['un']])) // If entered name is possible (first char not a number)
        {         // Creating new object to save user entered data
          $user=new User($_POST[$t['un']],"");
          $sql=new dbClass($user);    // Creating new object to connect to DataBase 
          
          if($mail=$sql->userExists($t['ft'])) // If entered username NOT exists in DataBase
          {
                $sql->change(PnM::newPass($mail),$t['p']);
                $this->MoveTo($tm[$t['h']][$t['b']]);
          }
          else    // If entered username already exists in DataBase show relevant massege 
          {      // and redirect back to registration page
            sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['fNUM'])));
            $this->MoveTo($tm[$t['h']][$t['a']]);
          }
        }
  }
}


$frgt=new Forget(basename(__FILE__,".php"));
$frgt->ForgetAct()
?>