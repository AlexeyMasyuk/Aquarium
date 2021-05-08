<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    HTML page action Class handling user connection to the site 
    --------------------------------------------------------------
	Using 'Wrapper' that contains all needed  
	includes, session name, headers to move to,
    strings and rules.
	** On lines 21-22 unwrapping stored data to variables for 
       more simpler use.
	--------------------------------------------------------------
*/
require_once('Wrapper.php');
class Connection extends WrappingClass{

    // Main class function checking if password and username match,
    // storing relevant data on match for main page use
    // or throwing relevan message.
	public function ConnectionValidation()
	{   
        $tm=$this->tagMap;  // unpacking data
        $t=$this->T;

        $msg=new TextMssg();   
        if(isset($_POST[$t['p']])&&isset($_POST[$t['un']]))
        {
            $user=new User($_POST[$t['un']],$_POST[$t['p']]); 
            $sql=new dbClass($user);                         
            if($sql->userExists($t['up']))   
            {   
                $this->seccesfullyConnected($user,$tm,$t,$msg);
            }
            else     
            {
                sessionClass::sessionPush(array($t['f']=>$msg->getMessge($t['w'])));
            }
        }
        $this->MoveTo($tm[$t['h']][$t['b']]);
    }

    // Function activated on successful connection,
    // Need tags, data, messages to be given ($tm,$t,$msg).
    // Deleting not hashed password, storing in session needed data
    // and moving to main page.
    private function seccesfullyConnected($user,$tm,$t,$msg){
        $user->PassDel(); 
        sessionClass::sessionPush(array($t['u']=>$user,$t['m']=>$msg));
        $this->MoveTo($tm[$t['h']][$t['mn']]);
    }
}

// Connection Activation.
$con=new Connection(basename(__FILE__,p));
$con->ConnectionValidation()
?>