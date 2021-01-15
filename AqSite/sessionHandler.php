<?php
class sessionClass{
    public static function sessionPull($arrToPull,$needAllData=true){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        foreach($arrToPull as $valToPull){
    
            if(isset($_SESSION[$valToPull])){
                $sessionArr[$valToPull]=$_SESSION[$valToPull];
            }
            else if($needAllData){
                return false;
            }
        }
    
        return $sessionArr;
    }
    
    public static function sessionPush($arrToPush){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        foreach($arrToPush as $key=>$val){
            $_SESSION[$key]=$val;
        }
    }

    public static function sessionDestroy(){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
        
        session_unset();
        session_destroy();
        session_write_close();
    }

    public static function sessionUnset($tag){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
        unset($_SESSION[$tag]);
    }
}
?>