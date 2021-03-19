<?php
class Validation
{
    public static function userParamValidation($key,$inp,$rulesArr,$msg,$aquaParamCheck=false)
    {
        if(($emptyCheck=self::emptyCheck($inp,$msg)) !== true){
            return $emptyCheck;
        }
        else if($aquaParamCheck && (strpos($key,"ph")!==false||strpos($key,"temp")!==false||strpos($key,"feed")!==false)){
            return self::aquaParamCheck($key,$inp,$msg,$rulesArr);
        }
        else if($key=="fname" || $key=="lname"){
            if ((ctype_alpha(str_replace(' ', '', $inp)) !== true) || (strlen($inp) > $rulesArr['fnamelnameMaxLen']))
                return $msg->getMessge($key)."<br>";
        }
        else if($key == "pass"){
            if(!(preg_match("/[a-z]/i", $inp) && preg_match('/[0-9]/', $inp)) || !(strlen($inp)>$rulesArr['pasMax']))
                return $msg->getMessge($key)."<br>";
        }
        else if($key == "uname"){
                if((ctype_alpha(str_replace(' ', '', $inp)) === false) || !(strlen($inp)>$rulesArr['userMax']))
                    return $msg->getMessge($key)."<br>";
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
        if(!isset($inp)||strlen($inp)>0){
            return true;
        }
        return $msg->getMessge("EmptyField")."<br>";
    }

    public static function aquaParamCheck($key,$inp,$msg,$rulesArr){
        if($key=="tempHigh"||$key=="tempLow"){
            if (is_numeric($inp) == false || !(floatval($inp)<=$rulesArr['tempMax'] && floatval($inp)>=$rulesArr['tempMin']))
                return $msg->getMessge("temp")."<br>";
        }
        else if($key=="phHigh"||$key=="phLow"){
            if (is_numeric( $inp) == false || (floatval($inp)<$rulesArr['phMin'] || floatval($inp)>$rulesArr['phMax']))
                return  $msg->getMessge("ph")."<br>";
        }
        else if($key=="feedAlert"){
            if(strpos($inp,":")===false)
               return $msg->getMessge($key)."<br>";
        }
        return true;
    }
}
?>