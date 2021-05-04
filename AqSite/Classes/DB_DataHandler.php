<?php
require_once('extractData.php');
class DB_DataHandler extends extractData
{ 
	public function __construct(){
		parent::__construct(basename(__FILE__,".php"));
	}

	public function UserAlarms_DataArrange($alarm,$row){
		$t = $this->ClassData['tagsNstrings'];
		$alarm[$t['ph']]=$row[$t['ph']];
		$alarm[$t['pl']]=$row[$t['pl']];
		$alarm[$t['th']]=$row[$t['th']];
		$alarm[$t['tl']]=$row[$t['tl']];
		$alarm[$t['fA']]=$row[$t['fA']];

		$alarm[$t['pr']][$t['f']]=$row[$t['fN']];
		$alarm[$t['pr']][$t['ln']]=$row[$t['lN']];
		$alarm[$t['pr']][$t['u']]=$row[$t['un']];
		$alarm[$t['pr']][$t['e']]=$row[$t['e']];
		
		return $alarm;
	}

	private function risedAlarmCheck($row,$alarmsArr,$msg)
	{
		$t = $this->ClassData['tagsNstrings'];
		$alarmStr="";
		$dateTime=dateTimeHandler::getTime($t['TF'],$row[$t['tm']]);
		$alMsgMidd=$msg->getMessge($t['md']);
		$alMsgStrt=$msg->getMessge($t['st']);
		$text=array($t['s']=>$alMsgStrt,$t['m']=>$alMsgMidd);
		if(floatval($row[$t['p']])>=floatval($alarmsArr[$t['ph']]))
			$alarmStr .= str_replace('?',$t['P'],$text[$t['s']]).$dateTime.str_replace('?',$t['P'],$text[$t['s']]).$row[$t['p']].$t['b'];
		else if(floatval($row[$t['p']])<=floatval($alarmsArr[$t['pl']]))
			$alarmStr .= str_replace('?',$t['P'],$text[$t['s']]).$dateTime.str_replace('?',$t['P'],$text[$t['s']]).$row[$t['p']].$t['b'];
		// $alarmType=$T;
		if(floatval($row[$t['t']])>=floatval($alarmsArr[$t['th']]))
			$alarmStr .= str_replace('?',$t['T'],$text[$t['s']]).$dateTime.str_replace('?',$t['t'].'.',$text[$t['s']]).$row[$t['t']].$t['b'];
		else if(floatval($row[$t['t']])<=floatval($alarmsArr[$t['tl']]))
			$alarmStr .= str_replace('?',$t['T'],$text[$t['s']]).$dateTime.str_replace('?',$t['t'].'.',$text[$t['s']]).$row[$t['t']].$t['b'];
		return $alarmStr;
	}

	public function chartQuery_AlarmsAndFeedingCheck($alarms,$dataArr,$feedAlertSkip,&$feedingTime,&$defineAlarmFlag,$msg){
		$t = $this->ClassData['tagsNstrings'];
	
		if(strlen($alarms[$t['ph']])>0 && strlen($alarms[$t['pl']])>0 && strlen($alarms[$t['th']])>0 && strlen($alarms[$t['tl']])>0 && strlen($alarms[$t['fA']])>0){
			$defineAlarmFlag=true;				
			$dataArr[$t['lt']]=implode(',',$alarms);

			if(!$feedAlertSkip){
				if($feedingTime=dateTimeHandler::FAC($alarms[$t['fA']])){
					$dataArr[$t['a']]=$msg->getMessge($t['ft']).$msg->getMessge($t['ftF']);
				}
			}
		}

		return $dataArr;
	}

	public function chartQuery_sqlRow_strToArr($row,$alarms,$dataArr,$feedingTime,$defineAlarmFlag,$msg){
		$t = $this->ClassData['tagsNstrings'];
		$dateTime=dateTimeHandler::getTime($t['TF'],$row[$t['tm']]);
		$dataArr[$t['t']] .= $dateTime.",".$row[$t['t']].",";
		$dataArr[$t['P']] .= $dateTime.",".$row[$t['p']].",";
		$dataArr[$t['l']] .= $dateTime.",".$row[$t['l']].",";
		if($defineAlarmFlag&&!$feedingTime){
			if(strpos($dataArr[$t['a']],$t['df']) !== false){
				$dataArr[$t['a']]="";
			}
			$dataArr[$t['a']] .= $this->risedAlarmCheck($row,$alarms,$msg);					
		}
		return $dataArr;
	}

	public function chartQuery_noAlarmsCheck($dataArr,$defineAlarmFlag,$feedingTime,$msg){
		$t = $this->ClassData['tagsNstrings'];
		if($defineAlarmFlag&&!$feedingTime){
			if(strpos($dataArr[$t['a']],$t['df']) !== false){
				$dataArr[$t['a']] = $msg->getMessge("DBnoAlarms");
			}
		}
		return $dataArr;
	}
}
?>