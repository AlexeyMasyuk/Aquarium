<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('userClass.php');
require_once('Querys.php');
require_once('TextAndMSG.php');

// Class to handle all worck with SQL DataBase
class dbClass
{
	private $host;
	private $db;
	private $charset;
	private $serverUser;
	private $user;
	private $pass;
	private $querys;           
	private $opt=array(
	PDO::ATTR_ERRMODE   =>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
	private $connection;
	
	public function __construct($userCls,string $host="localhost", string $db = "php_prj",string $charset="utf8", string $serverUser = "root", string $pass = "")
						{
							$this->host = $host;
							$this->db = $db;
							$this->charset = $charset;
							$this->serverUser = $serverUser;
							$this->pass = $pass;
							$this->user = $userCls;  
						}

	private function connect()  //  Connecting to Data Base
	{
	$dns = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
	$this->connection = new PDO($dns, $this->serverUser, $this->pass, $this->opt);
	}

	public function disconnect()
	{
	$this->connection = null;
	}

    // Function checking if given user Object username is exists in DataBase.
	// Can check if only username exists if onlyUser string given
    // or username and password if no string sended
	// Returning true or false 
	public function userExists(String $act="userAndPass")
	{
		try
		{
			$this->connect();
			$stmnt=Query::select($this->connection,"userpass");
			$stmnt->execute(array($this->user->getUserName()));
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
				if($act=="userAndPass"&&$row["username"]==$this->user->getUserName()&&password_verify($this->user->getPassword(),$row["password"]))						    
					return $row;
				else if($act=="onlyUser"&&$row["username"]==$this->user->getUserName())				
					return true;
				else if($act=="forgot"&&$row["username"]==$this->user->getUserName())				
					return $row["email"];
			}			
			return false;
		}catch(Exception $e){
			return false;
		}
		finally{
			$this->disconnect();
		}
	}
	

	// Function to write new user in user table and new user table in DataBase 
	// or delete user from user table and delete user data table
	// If act is create handlerDecide func will generate needed query to create user and users table
    // else querys to delete users data from DataBase returned and querys activated
	// return true or false depends if querys seccsed
	public function userCreate()
	{
		try
		{
			$this->connect();
			$stmnt1=Query::TableCreate($this->connection,$this->user->getUserName());
			$stmnt2=Query::insert($this->connection,"userpass");
			$userArr=array(
				$this->user->getUserName(),
				$this->user->getPassword(),
				$this->user->getFirstName(),
				$this->user->getLastName(),
				$this->user->getEmail()
			);
			if($stmnt2->execute($userArr))
			{
				$stmnt1->execute(array());
				return true;
			}
			return false;
		}catch(Exception $e){				
			return false;
		}
		finally{
			$this->disconnect();
		}
	}
	
	// Function getting data from DataBase
	// returning it as an array
	public function getData($user)
	{
		$this->connect();
		$result = $this->connection->query($this->querys->getDataSelect());
		$data=array();
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			array_push($data,$row);
		}
		$this->disconnect();
		return $data;
	}
	
	// Function deleating wanted data from user data table in DataBase
	public function delData($time)
	{
		$this->connect();
		if($this->connection->exec($this->querys->getDelData($time)))
		{
			$this->disconnect();
			return true;
		}
		$this->disconnect();
		return false;
	}

	public function alarms($name)
	{
		$alarm=array('phHigh'=>"",'phLow'=>"",'tempHigh'=>"",'tempLow'=>"");
		$stmnt=Query::select($this->connection,"userpass");
		$stmnt->execute(array($name));
		while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
			$alarm['phHigh']=$row['phHigh'];
			$alarm['phLow']=$row['phLow'];
			$alarm['tempHigh']=$row['tempHigh'];
			$alarm['tempLow']=$row['tempLow'];
			$alarm['feedAlert']=$row['feedAlert'];
		}
		return $alarm;
	}

	private function alarmCheck($row,$alarmsArr,$msg)
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

	private function TimeFeedingValidation($alarms,$dataArr,&$feedingTime){

	}

	public function chartQuery($name,$msg)
	{
		$dataArr=array('Temp'=>"",'PH'=>"",'level'=>"",
		'alarms'=>$msg->getMessge("DBalarmsNotDefined"),
		"limits"=>""
	    );
		$defineAlarmFlag=false;
		$feedingTime=false;			
		try 
		{
			$this->connect();
			$alarms=$this->alarms($name);
			
			if(strlen($alarms['phHigh'])>0 && strlen($alarms['phLow'])>0 && strlen($alarms['tempHigh'])>0 && strlen($alarms['tempLow'])>0 && strlen($alarms['feedAlert'])>0){
				$defineAlarmFlag=true;				
				$dataArr['limits']=implode(',',$alarms);

				$myTime = new DateTime(explode(' ',$alarms['feedAlert'])[1]);
				$endTime=(new DateTime(explode(' ',$alarms['feedAlert'])[1]))->add(new DateInterval('PT' . 30 . 'M'));
				$now=new DateTime();
				if ($now->format('H:i')>=$myTime->format('H:i')&&$now->format('H:i')<$endTime->format('H:i')) {
					$feedingTime=true;
					$dataArr['alarms']=$msg->getMessge("DBalarmFeedingTime");
				}
			}
			$stmnt=Query::select($this->connection,$name,"select");
			$stmnt->execute(array());
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
				$phpdate = strtotime( $row{'time'} );
				$dateTime=date("d.m.y H:i:s",$phpdate);
				$dataArr['Temp'] .= $dateTime.",".$row{'Temp'}.",";
				$dataArr['PH'] .= $dateTime.",".$row{'ph'}.",";
				$dataArr['level'] .= $dateTime.",".$row{'level'}.",";
				if($defineAlarmFlag&&!$feedingTime){
					if(strpos($dataArr['alarms'],"defined") !== false){
						$dataArr['alarms']="";
					}
					$dataArr['alarms'] .= $this->alarmCheck($row,$alarms,$msg);					
				}
			}
			if($defineAlarmFlag&&!$feedingTime){
				if(strpos($dataArr['alarms'],"defined") !== false){
					$dataArr['alarms'] = $msg->getMessge("DBnoAlarms");
				}
			}
			return $dataArr;
		} catch (Exception $e) {
			$this->disconnect();
			return false;
		}
		$this->disconnect();
	}

	public function change($data,$whatToChange)
	{
		try
	    {
			$this->connect();
			$stmnt=Query::update($this->connection,"userpass",$this->user->getUserName(),$whatToChange);
			$stmnt->execute(array($data));
			return true;
	    } catch (Exception $e) {
		    return false;
	    }
	    finally{
			$this->disconnect();
		}
	}

	public function arduinoUserValidation()
	{
		$st = "<NFU>"; // not found user
		if($row=$this->userExists()){
			$st="<OKEY".$row['temp'].",".$row['ph']."\n>";
		}
		return $st;
	}
}
?>