<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Class that handling all user parameters validation.
    ------------------------------------------------------
	Using 'extractData' wrapper that contains all needed  
	strings and text for the class.
	** Lines 13-15 unwrapind class data and store it
	   in $extractedV parameter. Data pulled and stored in 
	   $tagsNstrings via GetPageData() function using global.
	------------------------------------------------------
*/
require_once('extractData.php');
global $extractedV;
$extractedV = Init(basename(__FILE__,".php"));

class Validation
{

	// Function pulling wrapped class data
	// via global variable and return needed data.
    private static function GetPageData($OnlyRules=false){
        global $extractedV;
        if($OnlyRules){
            return $extractedV[r];
        }
        return $extractedV[tNs];
    }

    // Function validating all user parameters, personal and aquarium limits,
    // -- Parameters:
    //  - $key -> represent the data need to validate (FirstName, LastName, Temerature limits and more...).
    //  - $inp -> user input to validate.
    //  - $msg -> contain all needed alert messages.
    //  - $aquaParamCheck -> if set to true, activating temperature and ph validation.
    // Returning true or relevant fail message.
    public static function userParamValidation($key,$inp,$msg,$aquaParamCheck=false)
    {
        $t = self::GetPageData();
        $r=self::GetPageData(true);
        
        if(($emptyCheck=self::emptyCheck($inp,$msg)) !== true){
            return $emptyCheck;
        }
        else if($aquaParamCheck && (strpos($key,$t['p'])!==false||strpos($key,$t['t'])!==false||strpos($key,$t['f'])!==false)){
            return self::aquaParamCheck($key,$inp,$msg,$r);
        }
        else if($key==$t['fn'] || $key==$t['ln']){
            if ((strpos($inp,' ')!==false || ctype_alpha($inp) !== true) || (strlen($inp) > $r[$t['ml']])  )
                return $msg->getMessge($key).$t['b'];
        }
        else if($key == $t['ps']){
            if(!(preg_match(az, $inp) && preg_match(zn, $inp)) || (strlen($inp)>$r[$t['pm']] || strlen($inp)<$r[$t['pn']]))
                return $msg->getMessge($key).$t['b'];
        }
        else if($key == $t['u']){
                if(strpos(' ',$inp)!==false||(ctype_alpha($inp) === false) || !(strlen($inp)>$r[$t['ux']]))
                    return $msg->getMessge($key).$t['b'];
        }
        return true;
    }

    // Function checking if field are empty
    // and returning relevan message.
    public static function emptyCheck($inp,$msg)
    {
        $t = self::GetPageData();
        if(!isset($inp)||strlen($inp)>0){
            return true;
        }
        return $msg->getMessge($t['ef']).$t['b'];
    }

    // Function validating temperature and ph
    // by rules saved in ClassWrapData.
    // Returning relevant message on fail.
    public static function aquaParamCheck($key,$inp,$msg,$rulesArr){
        $t = self::GetPageData();
        if($key==$t['th']||$key==$t['tl']){
            if (is_numeric($inp) == false || (floatval($inp)>$rulesArr[$t['tx']] || floatval($inp)<$rulesArr[$t['tn']]))
                return $msg->getMessge($t['t']).$t['b'];
        }
        else if($key==$t['ph']||$key==$t['pl']){
            if (is_numeric( $inp) == false || (floatval($inp)<$rulesArr[$t['pn']] || floatval($inp)>$rulesArr[$t['px']]))
                return  $msg->getMessge($t['p']).$t['b'];
        }
        return true;
    }
}
?>