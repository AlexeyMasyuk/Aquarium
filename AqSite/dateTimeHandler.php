<?php
class dateTimeHandler{
    public static function getTime($formatTagStr,$wantedDate=null){
        $thpTime=new DateTime($wantedDate);
        return $thpTime->format($formatTagStr);
    }

    public static function feedingDayParameterCalc($feedAlertString,$feedCycleVal=null){
        if($feedCycleVal==null){
            $tmpArr=explode(' ',$feedAlertString);
            $feedCycleVal=$tmpArr[0];
        }
        $feedAlertString.= " ".dateTimeHandler::getTime('d')%intval($feedCycleVal);
        return $feedAlertString;
    }

    public static function defaultFeedTimeAlert($chkboxVal,$POST){
        $tmp=$POST[$chkboxVal."Cycle"]." ";
        $tmp.=$POST[$chkboxVal."Time"];
        $tmp.=dateTimeHandler::feedingDayParameterCalc($feedAlertString,$POST[$chkboxVal."Cycle"]);
        $POST[$chkboxVal]=$tmp;
        return $POST;
    }

    public static function FeedAlertCheck($feedRulesArr){
        $TF='H:i'; // Time Format
        $myTime = new DateTime($feedRulesArr[1]);
        $endTime=(new DateTime($feedRulesArr[1]))->add(new DateInterval('PT' . 30 . 'M'));
        $now=dateTimeHandler::getTime($TF);
        if ($now>=$myTime->format($TF)&&$now<$endTime->format($TF)) {
            if(dateTimeHandler::getTime('d')%intval($feedRulesArr[0])==$feedRulesArr[2]){
                return true;
            }
        }
        return false;
    }
}
?>
