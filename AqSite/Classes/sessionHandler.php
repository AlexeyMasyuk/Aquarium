<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Class that handle sessions.
    ------------------------------------------------------
	** init() function can disable and alert session unexpected behaviors,
    currently this option is disabled.
	------------------------------------------------------
*/

class sessionClass{

    // Function to initiate session and checkin if session not disabled.
    // returning session.
    // *can manipulate session via lines 24-34, currently disabled
    private static function init(){
        if (function_exists('session_status'))
        {
            // PHP 5.4.0+
            if (session_status() == PHP_SESSION_DISABLED)
                throw new Exception();
        }

        // $httponly = true;
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

    // Function end the current session and store session data, if id not empty
    public static function close()
    {
        if ( '' !== session_id() )
        {
            return session_write_close();
        }
        return true;
    }

    // Function pulls session data from gived tags array,
    // $arrToPull contains all tags to be pullen from sesion
    // returning false if no session pulled or array storing retrived data. 
    public static function sessionPull($arrToPull){
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
    
    // Function pushing data to session from given $arrToPush,
    // saving key and data from $arrToPush
    public static function sessionPush($arrToPush){
        self::init();

        foreach($arrToPush as $key=>$val){
            $_SESSION[$key]=$val;
        }
        self::close();
    }

    // Function destroing and unset the session
    public static function sessionDestroy(){
        self::init();
        
        session_unset();
        session_destroy();
    }

    // Function unseting from session data stored under given $tag
    public static function sessionUnset($tag){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
        unset($_SESSION[$tag]);
    }
}
?>