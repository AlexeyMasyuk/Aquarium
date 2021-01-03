<?php
class PassHandler
{
    function passHash($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }
    
    function passCheck($pass,$cryptPass){
        return password_verify($pass,$cryptPass);
    }
    
    function PassGen(){
        $pass;
        for($i=0;$i<3;$i++){
            $pass.=chr(rand(48,57));
            $pass.=chr(rand(65,90));
            $pass.=chr(rand(97,122));
        }
        return $pass;
    }
}

?>