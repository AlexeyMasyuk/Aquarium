<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Class for handling all Dates and Time in the site.
	Also Handling Feeding Alert set and check if alert occur
*/
class dateTimeHandler{
	// Function returnning DateTime in given format by $formatTagStr parameter.
	// If $wantedDate given it will be the returned Date.
    public static function getTime($formatTagStr,$wantedDate=null){
        $thpTime=new DateTime($wantedDate);
        return $thpTime->format($formatTagStr);
    }

	// Function returnning parameter to be saved for feeding alert calculation.
	// Given $feedCycleParam and adding to it current date with space seperator between.
    public static function feedingAlarmSet($feedCycleParam){
		$thpTime=new DateTime();
		$feedStr=$thpTime->format('d-m-Y').' '.$feedCycleParam;
        return $feedStr;
		
    }

	// Function checking if feeding alert need to be shown.
	// Given $feedAlertStr from sqlDB, calculating if feeding alert needed.
	// If $_COOKIE['FA'] alert not needed (today).
    public static function FAC($feedAlertStr){
		try{
			$FAS=explode(' ',$feedAlertStr);
			if(isset($_COOKIE['FA'])){
				if($_COOKIE['FA']=="OFF"){
					return false;
				}
			}
			if(isset($FAS[1])){
				if($FAS[1]=='1'){       // 1 means alert shown every day.
					return true;
				}
				$now = new DateTime();
				$stored = new DateTime(explode(' ',$feedAlertStr)[0]);  // Turnning saved dato to date object.
		
				$diff=$now->diff($stored);                              // calculating the diffrance
				// ->format("%a"): Total number of days as a result of a DateTime::diff()
				if(intval($diff->format("%a")%2==0)){                   // If the Modulo of the diffrance (total number) and 2 are 0, Alert!
					return true;
				}
			}
		}catch(Exception $e){
			return false;
		}

	return false;		
	}
}
?>
