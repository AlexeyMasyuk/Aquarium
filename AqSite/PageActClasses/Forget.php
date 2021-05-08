<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    HTML page action Class handling password forget case.
    --------------------------------------------------------------
	  Using 'Wrapper' that contains all needed  
	  includes, session name, headers to move to,
    strings and rules.
	  ** On lines 21-22 unwrapping stored data to variables for 
       more simpler use.
	--------------------------------------------------------------
*/
require_once('Wrapper.php');
class Forget extends WrappingClass{

  // Main class function checking if username exist,
  // sending new generated new password via mail
  // or throwing relevan message.
	public function ForgetAct()
	{   
    $tm=$this->tagMap;
    $t=$this->T;
    $msg=new TextMssg(); 

    if(isset($_POST[$t['un']]))
    {
      $user=new User($_POST[$t['un']],"");
      $sql=new dbClass($user);
 
      if($mail=$sql->userExists($t['ft'])){
        $this->UserMatch($tm,$t,$sql,$mail);
      }
      else{      
        $this->UserNotMatch($tm,$t,$msg);
      }
    }
  }

  // Function used if entered username no found.
  // Showing relebvant message and reloading the page. 
  private function UserNotMatch($tm,$t,$msg){
    sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['fNUM'])));
    $this->MoveTo($tm[$t['h']][$t['a']]);
  }

  // Function used if entered username founded in sqlDB.
  // sending new generated new password via mail to saved mail in sqlDB
  private function UserMatch($tm,$t,$sql,$mail){
    $sql->change(PnM::newPassAction($mail),$t['p']);
    $this->MoveTo($tm[$t['h']][$t['b']]);
  }
}

// Forget Activation.
$frgt=new Forget(basename(__FILE__,".php"));
$frgt->ForgetAct()
?>