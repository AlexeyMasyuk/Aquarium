<?php
class dateTimeHandler{
    public static function getTime($formatTagStr,$wantedDate=null){
        $thpTime=new DateTime($wantedDate);
        return $thpTime->format($formatTagStr);
    }

    public static function feedingAlarmSet($feedCycleParam){
		$thpTime=new DateTime();
		$feedStr=$thpTime->format('d-m-Y').' '.$feedCycleParam;
        return $feedStr;
		
    }

    public static function FAC($feedAlertStr){
		$FAS=explode(' ',$feedAlertStr);
		if(isset($FAS[1])){
			if($FAS[1]=='1'){
				return true;
			}
			$now = new DateTime();
			$stored = new DateTime(explode(' ',$feedAlertStr)[0]);
	
			$diff=$now->diff($stored);
			if(intval($diff->format("%a")%2==0)){
				return true;
			}
		}
	return false;		
	}
}
?>
