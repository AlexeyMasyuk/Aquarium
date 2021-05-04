<?php
class sessionClass{
    private static function init(){
        if (function_exists('session_status'))
        {
            // PHP 5.4.0+
            if (session_status() == PHP_SESSION_DISABLED)
                throw new Exception();
        }
        $httponly = true;

        // Disallow session passing as a GET parameter.
        // Requires PHP 4.3.0
        // if (ini_set('session.use_only_cookies', 1) === false) {
        //     throw new Exception();
        // }

        // Mark the cookie as accessible only through the HTTP protocol.
        // Requires PHP 5.2.0
        // if (ini_set('session.cookie_httponly', 1) === false) {
        //     throw new Exception();
        // }
        if(session_status() == PHP_SESSION_NONE){
            return session_start();
        }
    }

    public static function close()
    {
        if ( '' !== session_id() )
        {
            return session_write_close();
        }
        return true;
    }
    public static function sessionPull($arrToPull,$needAllData=true){
        self::init();
        foreach($arrToPull as $valToPull){
            if(isset($_SESSION[$valToPull])){
                $sessionArr[$valToPull]=$_SESSION[$valToPull];
            }
        }
        if(isset($sessionArr)){
            self::close();
            return $sessionArr;
        }
        self::close();
        return false;
    }
    
    public static function sessionPush($arrToPush){
        self::init();

        foreach($arrToPush as $key=>$val){
            $_SESSION[$key]=$val;
        }
        self::close();
    }

    public static function sessionDestroy(){
        self::init();
        
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