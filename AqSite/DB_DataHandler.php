<?php
require_once('TextAndMSG.php');
class DB_DataHandler
{ 
	public function UserAlarms_DataArrange($alarm,$row){
		$alarm['phHigh']=$row['phHigh'];
		$alarm['phLow']=$row['phLow'];
		$alarm['tempHigh']=$row['tempHigh'];
		$alarm['tempLow']=$row['tempLow'];
		$alarm['feedAlert']=$row['feedAlert'];
		return $alarm;
	}

	private function risedAlarmCheck($row,$alarmsArr,$msg)
	{
		$alarmStr="";
		$phpdate = strtotime( $row{'time'} );
		$dateTime=date("d.m.y H:i:s",$phpdate);
		$text=array('start'=>$msg->getMessge("DBalChkTxtArrStrt"),'midd'=>$msg->getMessge("DBalChkTxtArrMidd"),'br'=>"<br>");
		if(floatval($row['ph'])>floatval($alarmsArr['phHigh']))
			$alarmStr .= str_replace('?',"PH",$text['start']).$dateTime.str_replace('?',"PH",$text['midd']).$row['ph'].$text['br'];
		else if(floatval($row['ph'])<floatval($alarmsArr['phLow']))
			$alarmStr .= str_replace('?',"PH",$text['start']).$dateTime.str_replace('?',"PH",$text['midd']).$row['ph'].$text['br'];
		$alarmType="Temperature";
		if(floatval($row['Temp'])>floatval($alarmsArr['tempHigh']))
			$alarmStr .= str_replace('?',"Temperature",$text['start']).$dateTime.str_replace('?',"Temp.",$text['midd']).$row['Temp'].$text['br'];
		else if(floatval($row['Temp'])<floatval($alarmsArr['tempLow']))
			$alarmStr .= str_replace('?',"Temperature",$text['start']).$dateTime.str_replace('?',"Temp.",$text['midd']).$row['Temp'].$text['br'];
		return $alarmStr;
	}

	public function chartQuery_AlarmsAndFeedingCheck($alarms,$dataArr,$feedAlertSkip,&$feedingTime,&$defineAlarmFlag,$msg){
		if(strlen($alarms['phHigh'])>0 && strlen($alarms['phLow'])>0 && strlen($alarms['tempHigh'])>0 && strlen($alarms['tempLow'])>0 && strlen($alarms['feedAlert'])>0){
			$defineAlarmFlag=true;				
			$dataArr['limits']=implode(',',$alarms);
			if(!$feedAlertSkip){
				$feedAlerts=explode(' ',$alarms['feedAlert']);
				$myTime = new DateTime($feedAlerts[1]);
				$endTime=(new DateTime($feedAlerts[1]))->add(new DateInterval('PT' . 30 . 'M'));
				$now=new DateTime();
				if ($now->format('H:i')>=$myTime->format('H:i')&&$now->format('H:i')<$endTime->format('H:i')) {
					if($now->format('d')%intval($feedAlerts[0])==$feedAlerts[2]){
						$feedingTime=true;
						$dataArr['alarms']=$msg->getMessge("DBalarmFeedingTime");
					}
				}
			}
		}
		return $dataArr;
	}

	public function chartQuery_sqlRow_strToArr($row,$alarms,$dataArr,$feedingTime,$defineAlarmFlag,$msg){
		$phpdate = strtotime( $row{'time'} );
		$dateTime=date("d.m.y H:i:s",$phpdate);
		$dataArr['Temp'] .= $dateTime.",".$row{'Temp'}.",";
		$dataArr['PH'] .= $dateTime.",".$row{'ph'}.",";
		$dataArr['level'] .= $dateTime.",".$row{'level'}.",";
		if($defineAlarmFlag&&!$feedingTime){
			if(strpos($dataArr['alarms'],"defined") !== false){
				$dataArr['alarms']="";
			}
			$dataArr['alarms'] .= $this->risedAlarmCheck($row,$alarms,$msg);					
		}
		return $dataArr;
	}

	public function chartQuery_noAlarmsCheck($dataArr,$defineAlarmFlag,$feedingTime,$msg){
		if($defineAlarmFlag&&!$feedingTime){
			if(strpos($dataArr['alarms'],"defined") !== false){
				$dataArr['alarms'] = $msg->getMessge("DBnoAlarms");
			}
		}
		return $dataArr;
	}
}
?>