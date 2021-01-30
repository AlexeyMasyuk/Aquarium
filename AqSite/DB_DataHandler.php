<?php
require_once('TextAndMSG.php');
require_once('dateTimeHandler.php');
class DB_DataHandler
{ 
	//--- Arrays Tags ---//
	// PH //
	private static $p="ph";
	private static $P="PH";
	private static $pH="phHigh";
	private static $pL="phLow";
    // Temperature //
	private static $t="Temp";
	private static $T="Temperature";
	private static $tH="tempHigh";
	private static $tL="tempLow";
	// Alert\Alarms //
	private static $a="alarms";
	private static $fA="feedAlert";

	private static $le="level";
	private static $li="limits";
	private static $tm="time";
	private static $DF="d.m.y H:i:s";

	private static $s="start";
	private static $m="midd";
	private static $b="<br>";

	private static $d="defined";


	public function UserAlarms_DataArrange($alarm,$row){
		$alarm[self::$pH]=$row[self::$pH];
		$alarm[self::$pL]=$row[self::$pL];
		$alarm[self::$tH]=$row[self::$tH];
		$alarm[self::$tL]=$row[self::$tL];
		$alarm[self::$fA]=$row[self::$fA];

		$alarm["personal"]["fname"]=$row["firstName"];
		$alarm["personal"]["lname"]=$row["lastName"];
		$alarm["personal"]["uname"]=$row["username"];
		$alarm["personal"]["email"]=$row["email"];
		
		return $alarm;
	}

	private function risedAlarmCheck($row,$alarmsArr,$msg)
	{
		$alarmStr="";
		$dateTime=dateTimeHandler::getTime(self::$DF,$row[self::$tm]);
		$alMsgMidd=$msg->getMessge("DBalChkTxtArrMidd");
		$alMsgStrt=$msg->getMessge("DBalChkTxtArrStrt");
		$text=array(self::$s=>$alMsgStrt,self::$m=>$alMsgMidd);
		if(floatval($row[self::$p])>=floatval($alarmsArr[self::$pH]))
			$alarmStr .= str_replace('?',self::$P,$text[self::$s]).$dateTime.str_replace('?',self::$P,$text[self::$m]).$row[self::$p].self::$b;
		else if(floatval($row[self::$p])<=floatval($alarmsArr[self::$pL]))
			$alarmStr .= str_replace('?',self::$P,$text[self::$s]).$dateTime.str_replace('?',self::$P,$text[self::$m]).$row[self::$p].self::$b;
		// $alarmType=$T;
		if(floatval($row[self::$t])>=floatval($alarmsArr[self::$tH]))
			$alarmStr .= str_replace('?',self::$T,$text[self::$s]).$dateTime.str_replace('?',self::$t.'.',$text[self::$m]).$row[self::$t].self::$b;
		else if(floatval($row[self::$t])<=floatval($alarmsArr[self::$tL]))
			$alarmStr .= str_replace('?',self::$T,$text[self::$s]).$dateTime.str_replace('?',self::$t.'.',$text[self::$m]).$row[self::$t].self::$b;
		return $alarmStr;
	}

	public function chartQuery_AlarmsAndFeedingCheck($alarms,$dataArr,$feedAlertSkip,&$feedingTime,&$defineAlarmFlag,$msg){
		if(strlen($alarms[self::$pH])>0 && strlen($alarms[self::$pL])>0 && strlen($alarms[self::$tH])>0 && strlen($alarms[self::$tL])>0 && strlen($alarms[self::$fA])>0){
			$defineAlarmFlag=true;				
			$dataArr[self::$li]=implode(',',$alarms);
			if(!$feedAlertSkip){
				$feedAlerts=explode(' ',$alarms[self::$fA]);
				if($feedingTime=dateTimeHandler::FeedAlertCheck($feedAlerts)){
					$dataArr[self::$a]=$msg->getMessge("DBalarmFeedingTime");
				}
			}
		}
		return $dataArr;
	}

	public function chartQuery_sqlRow_strToArr($row,$alarms,$dataArr,$feedingTime,$defineAlarmFlag,$msg){
		$dateTime=dateTimeHandler::getTime(self::$DF,$row[self::$tm]);
		$dataArr[self::$t] .= $dateTime.",".$row[self::$t].",";
		$dataArr[self::$P] .= $dateTime.",".$row[self::$p].",";
		$dataArr[self::$le] .= $dateTime.",".$row[self::$le].",";
		if($defineAlarmFlag&&!$feedingTime){
			if(strpos($dataArr[self::$a],self::$d) !== false){
				$dataArr[self::$a]="";
			}
			$dataArr[self::$a] .= $this->risedAlarmCheck($row,$alarms,$msg);					
		}
		return $dataArr;
	}

	public function chartQuery_noAlarmsCheck($dataArr,$defineAlarmFlag,$feedingTime,$msg){
		if($defineAlarmFlag&&!$feedingTime){
			if(strpos($dataArr[self::$a],self::$d) !== false){
				$dataArr[self::$a] = $msg->getMessge("DBnoAlarms");
			}
		}
		return $dataArr;
	}
}
?>