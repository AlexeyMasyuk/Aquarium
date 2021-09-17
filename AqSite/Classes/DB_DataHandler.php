<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Helping fileHandler Class handle all needed manipulation 
	for data taken from text files and fitting it to the site needs.
    ------------------------------------------------------
	Using 'extractData' wrapper that contains all needed  
	includes and strings for the class.
	** All functions first action is to unwrap the data by 
	   assigning $t = $this->ClassData['tagsNstrings'];.
	   Needed includes required in parent cunstructor
	------------------------------------------------------
*/
require_once('extractData.php');
define("tNs", "tagsNstrings");

class DB_DataHandler extends extractData
{ 
	// Cunstractor, call wraping class, all data stored in $this->ClassData.
	// Excluded file name given to extractData (parent class).
	public function __construct(){                      
		parent::__construct(basename(__FILE__,".php"));
	}


	// Function storing user alarms limits and personal data from sqlDB, given in $row parameter
	// and storing it in given array $userData for later JS Chart and setting change use.
	public function UserAlarmsAndPersonal_DataArrange(&$userData,$row){
		$t = $this->ClassData[tNs];

		$personal=6;
		$tg=array($t['ph'],$t['pl'],$t['th'],$t['tl'],$t['pc'] ,$t['fA'],$t['pr'],$t['f'],$t['fN'],$t['ln'],$t['lN'],$t['u'],$t['un'],$t['e']);

		for($i=0;$i<$personal;$i++){            // Loop for Aquarium limits
			$userData[$tg[$i]]=$row[$tg[$i]];
		}
		for($i=$personal+1;$i<count($tg);$i++){           // Loop for personal data
			$userData[$tg[$personal]][$tg[$i++]]=$row[$tg[$i]];
			$i==(count($tg)-2)?$userData[$tg[$personal]][$tg[++$i]]=$row[$tg[$i]]:null;
		}
	}

	// Function for initiating all needed parameters for JS Chart.
	// ** $dataArr alarms parameter initiated with 'notDefined' message
	//    and erased later if alarms defined.
	// $alarms -> store all user alarms limit parameters.
	// Returning $dataArr after initiating all neeeded cells.
	public function UserDataInit($msg,&$alarms){    
		$t = $this->ClassData[tNs];  

		$dataArr=array($t['t']=>"",$t['P']=>"",$t['l']=>"",
		$t['a']=>$msg->getMessge($t['nd']),$t['lt']=>"",$t['pr']=>"");

		$dataArr[$t['pr']]=implode(',',$alarms[$t['pr']]);



		unset($alarms[$t['pr']]);          // delete personal data from user alarms
		return $dataArr;
	}

	// Function checking if Temperature or PH alarms occured,
	// saving all alarm occurence in $alarmStr. Checking one alarm each iteration
	// from data stored in $row param and limits given in $alarmsArr.
	// ** Message class have prepared deticated start and middle text of the alarms
	//    and special sign, $insertSign='?' , to be raplaced by the alarm data.
	private function risedAlarmCheck($row,$alarmsArr,$msg)
	{
		$t = $this->ClassData[tNs];
		$alarmStr="";
		$insertSign='?';
		$dateTime=dateTimeHandler::getTime($t['TF'],$row[$t['tm']]);
		$text=array($t['s']=>$msg->getMessge($t['st']), $t['m']=>$msg->getMessge($t['md']));
		if(floatval($row[$t['p']])>=floatval($alarmsArr[$t['ph']])){
			$alarmStr .= str_replace($insertSign,$t['P'],$text[$t['s']]).$dateTime.
			    str_replace($insertSign,$t['P'],$text[$t['m']]).$row[$t['p']].$t['b'];
		}
		else if(floatval($row[$t['p']])<=floatval($alarmsArr[$t['pl']])){
			$alarmStr .= str_replace($insertSign,$t['P'],$text[$t['s']]).$dateTime.
			    str_replace($insertSign,$t['P'],$text[$t['m']]).$row[$t['p']].$t['b'];
		}
		if(floatval($row[$t['t']])>=floatval($alarmsArr[$t['th']])){
			$alarmStr .= str_replace($insertSign,$t['T'],$text[$t['s']]).$dateTime.
			    str_replace($insertSign,$t['t'].'.',$text[$t['m']]).$row[$t['t']].$t['b'];
		}
		else if(floatval($row[$t['t']])<=floatval($alarmsArr[$t['tl']])){
			$alarmStr .= str_replace($insertSign,$t['T'],$text[$t['s']]).$dateTime.
			    str_replace($insertSign,$t['t'].'.',$text[$t['m']]).$row[$t['t']].$t['b'];
		}
		return $alarmStr;
	}

	// Function checking if all user alarms are defined,
	// if they are the func store user alarms limits in $dataArr
	// and setting $defineAlarmFlag as true, if not defined, just return $dataArr.
	// Then if no skip alarm flag rised (stored in $feedAlertSkip)
	// the func checking if feeding alarm need to be rised, and storing the result (true/false) in $feedingTimeFlag
	// if feeding alarm rised, prepering dedicated stored message.
	// -- Parameters: 
	// - $alarms -> store alarm limits string from sqlDB.
	// - $dataArr -> store all needed data for JS Chart and settings change displayed data.
	public function chartQuery_AlarmsAndFeedingCheck($alarms,$dataArr,$feedAlertSkip,&$feedingTimeFlag,&$defineAlarmFlag,$msg){
		$t = $this->ClassData[tNs];
	    // Checking if all limits set
		if(strlen($alarms[$t['ph']])>0 && strlen($alarms[$t['pl']])>0 && strlen($alarms[$t['th']])>0 && strlen($alarms[$t['tl']])>0 && strlen($alarms[$t['fA']])>0){
			$defineAlarmFlag=true;				
			$dataArr[$t['lt']]=implode(',',$alarms);

			if(!$feedAlertSkip){
				if($feedingTimeFlag=dateTimeHandler::FAC($alarms[$t['fA']])){ // checking if feeding alert need to be shown
					$dataArr[$t['a']]=$msg->getMessge($t['ft']).$msg->getMessge($t['ftF']);
				}
			}
		}
		return $dataArr;
	}

	// Function arranging PH and Temperature data from sqlDB
	// and checking if Temperature or PH alarms occure.
	// -- Parameters: 
	// -  $dataArr -> store all needed data for JS Chart and settings change displayed data.
	// -  $alarms -> store alarm limits string from sqlDB.
	// -  $row -> Temperature and PH data stored in sqlDB.
	// Returning $dataArr after storing temperature, ph, level and time in dedicated string cell,
	// using risedAlarmCheck() func, if feeding alarm flag not rised,
	// for storing alarms will shown in alarms_div          
	public function chartQuery_sqlRow_strToArr($row,$alarms,$dataArr,$feedingTimeFlag,$defineAlarmFlag,$msg){
		$t = $this->ClassData[tNs];
		$dateTime=dateTimeHandler::getTime($t['TF'],$row[$t['tm']]);
		$dataArr[$t['t']] .= $dateTime.",".$row[$t['t']].",";
		$dataArr[$t['P']] .= $dateTime.",".$row[$t['p']].",";
		$dataArr[$t['l']] .= $dateTime.",".$row[$t['l']].",";
		if($defineAlarmFlag&&!$feedingTimeFlag){
			if(strpos($dataArr[$t['a']],$t['df']) !== false){
				$dataArr[$t['a']]="";             // erasing undefine massege stored on initialization
			}
			$dataArr[$t['a']] .= $this->risedAlarmCheck($row,$alarms,$msg);					
		}
		return $dataArr;
	}

	// Function checkin if no alarms occured,
	// if $defineAlarmFlag are true and $feedingTimeFlag are false,
	// store dedicated message to be shown in alarms_div.
	public function chartQuery_noAlarmsCheck($dataArr,$defineAlarmFlag,$feedingTimeFlag,$msg){
		$t = $this->ClassData[tNs];
		if($defineAlarmFlag&&!$feedingTimeFlag){
			if(strpos($dataArr[$t['a']],$t['df']) !== false){
				$dataArr[$t['a']] = $msg->getMessge($t['no']);
			}
		}
		return $dataArr;
	}

}
?>