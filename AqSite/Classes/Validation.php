<?php

require_once('extractData.php');
global $extracted;
$extracted = Init(basename(__FILE__,".php"));

class Validation
{
    private static function GetPageData(){
        global $extracted;
        return $extracted['tagsNstrings'];
    }

    public static function userParamValidation($key,$inp,$rulesArr,$msg,$aquaParamCheck=false)
    {
        $t = self::GetPageData();

        if(($emptyCheck=self::emptyCheck($inp,$msg)) !== true){
            return $emptyCheck;
        }
        else if($aquaParamCheck && (strpos($key,$t['p'])!==false||strpos($key,$t['t'])!==false||strpos($key,$t['f'])!==false)){
            return self::aquaParamCheck($key,$inp,$msg,$rulesArr);
        }
        else if($key==$t['fn'] || $key==$t['ln']){
            if ((ctype_alpha(str_replace(' ', '', $inp)) !== true) || (strlen($inp) > $rulesArr[$t['ml']]))
                return $msg->getMessge($key).$t['b'];
        }
        else if($key == $t['ps']){
            if(!(preg_match('/[a-z]/i', $inp) && preg_match('/[0-9]/', $inp)) || !(strlen($inp)>$rulesArr[$t['pm']]))
                return $msg->getMessge($key).$t['b'];
        }
        else if($key == $t['u']){
                if((ctype_alpha(str_replace(' ', '', $inp)) === false) || !(strlen($inp)>$rulesArr[$t['ux']]))
                    return $msg->getMessge($key).$t['b'];
        }



        // else if($key=="email"){
        //     $email=test_input($inp);
        //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        //        return true;
        //     return $msg->getMessge($key);
        // }
        return true;
    }

    public static function emptyCheck($inp,$msg)
    {
        $t = self::GetPageData();

        if(!isset($inp)||strlen($inp)>0){
            return true;
        }
        return $msg->getMessge($t['ef']).$t['b'];
    }

    public static function aquaParamCheck($key,$inp,$msg,$rulesArr){
        $t = self::GetPageData();
        
        if($key==$t['th']||$key==$t['tl']){
            if (is_numeric($inp) == false || !(floatval($inp)<=$rulesArr[$t['tx']] && floatval($inp)>=$rulesArr[$t['tn']]))
                return $msg->getMessge($t['t']).$t['b'];
        }
        else if($key==$t['ph']||$key==$t['pl']){
            if (is_numeric( $inp) == false || (floatval($inp)<$rulesArr[$t['pn']] || floatval($inp)>$rulesArr[$t['px']]))
                return  $msg->getMessge($t['p']).$t['b'];
        }
        else if($key==$t['fA']){
            if(strpos($inp,":")===false)
               return $msg->getMessge($key).$t['b'];
        }
        return true;
    }
}
?>