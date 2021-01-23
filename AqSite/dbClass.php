<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('userClass.php');
require_once('Querys.php');
require_once('TextAndMSG.php');
require_once('DB_DataHandler.php');

// Class to handle all worck with SQL DataBase
class dbClass
{
	private $host;
	private $db;
	private $charset;
	private $serverUser;
	private $user;
	private $pass;
	private $helpingClass;           
	private $opt=array(
	PDO::ATTR_ERRMODE   =>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
	private $connection;
	
	public function __construct($userCls,string $host="localhost", string $db = "test",string $charset="utf8", string $serverUser = "root", string $pass = "")
						{
							$this->host = $host;
							$this->db = $db;
							$this->charset = $charset;
							$this->serverUser = $serverUser;
							$this->pass = $pass;
							$this->user = $userCls;
							$this->helpingClass = new DB_DataHandler();
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

	public function getUserAlarms()
	{
		$alarm=array('phHigh'=>"",'phLow'=>"",'tempHigh'=>"",'tempLow'=>"");
		$stmnt=Query::select($this->connection,"userpass");
		$stmnt->execute(array($this->user->getUserName()));
		while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
			$alarm=$this->helpingClass->UserAlarms_DataArrange($alarm,$row);
		}
		return $alarm;
	}

	public function chartQuery($msg,$feedAlertSkip=false)
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

			$alarms=$this->getUserAlarms($this->user->getUserName());
			$dataArr=$this->helpingClass->chartQuery_AlarmsAndFeedingCheck($alarms,$dataArr,$feedAlertSkip,$feedingTime,$defineAlarmFlag,$msg);

			$stmnt=Query::select($this->connection,$this->user->getUserName(),"select");
			$stmnt->execute(array());
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
				$dataArr=$this->helpingClass->chartQuery_sqlRow_strToArr($row,$alarms,$dataArr,$feedingTime,$defineAlarmFlag,$msg);
			}
			$dataArr=$this->helpingClass->chartQuery_noAlarmsCheck($dataArr,$defineAlarmFlag,$feedingTime,$msg);
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