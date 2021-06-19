<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
// AFS -> A-AlertOnHTML, F-feedAlarmSkip, S-signOut.
/*
    Class contains 'little' actiong for HTML pages
    --------------------------------------------------------------
	Using 'Wrapper' that contains all needed  
	includes, session name, headers to move to,
    strings and rules.
	** On lines 18-19 unwraping stored data to variables for 
       more simpler use.
	--------------------------------------------------------------
*/
require_once('Wrapper.php');
class AFS extends WrappingClass{

    // Function called for printing messagees on HTML pages.
    public function AlertOnHTML(){
        $tm=$this->tagMap;  // unpacking data
        $t=$this->T;

        if($msg=sessionClass::sessionPull(array($t['fl'])))
        {
           echo $msg[$t['fl']]; // Print the error ocured
           sessionClass::sessionUnset($t['fl']);
        }
    }

    // Function called for closing feeding alert ocure in alarm DIV.
    public function feedAlarmSkip(){
        $tm=$this->tagMap;  // unpacking data
        $t=$this->T;

        echo"<pre>";
        print_r($tm);
        echo"<pre/>";
        

        if(isset($_GET[$t['of']])&&$_GET[$t['of']]==$t['o']){
            $cookie_name = $t['f'];
            $cookie_value = $t['of'];
            setcookie($cookie_name,$cookie_value,strtotime($t['tm']),'/');
        }
        
        // If OFF varible NOT sent hide the alert until user will sign out.
        sessionClass::sessionPush(array($t['fas']=>true));
        
        // Back to main page
        //header('Location:dataTbl.php');
        $this->MoveTo($tm[$t['h']][$t['b']]);
    }

    // Function called for deleating all stored data on site exit/sign out.
    public function signOut(){
        $tm=$this->tagMap;  // unpacking data
        $t=$this->T;

        sessionClass::sessionDestroy();

        // Function used to evoid recursivly loop,
        // returning varieble name fromg globals , if exists, 
        // and returning varible name as string.
        function print_var_name($var) {
            foreach($GLOBALS as $var_name => $value) {
                if ($value === $var) {
                    return $var_name;
                }
            }
            return '!';
        }
        // Function unsetting all global varibles
        function globalsUnset(&$array){
            if(!isset($array)){
                return;
            }
            foreach($array as &$val){
                if ( is_array($val) && print_var_name($val)!=$t['G']) {
                    $val=null;
                    unset($val);
                }
            }
        }
        globalsUnset($GLOBALS);
        
        // moving back to index
        //header('Location:indexAq.php');
        $this->MoveTo($tm[$t['h']][$t['i']]);
    }
}

$action=new AFS(basename(__FILE__,p));
if(isset($_GET["out"])){
    $action->signOut();
}
else if(isset($_GET['o'])||isset($_GET[O])){
    $action->feedAlarmSkip();
}
else{
    $action->AlertOnHTML();
}
?>