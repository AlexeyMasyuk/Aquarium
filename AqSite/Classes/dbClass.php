<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('extractData.php');
global $extracted;
$extracted = Init(basename(__FILE__,".php"));
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
	private $tagsNstrings;          
	private $opt=array(
	PDO::ATTR_ERRMODE   =>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
	private $connection;
	
	public function __construct($userCls)
		{
			global $extracted;
			$this->tagsNstrings = $t = $extracted['tagsNstrings'];
			$cred=$extracted[$t['c']];
			unset($extracted);
			$this->host = $cred[$t['h']];
			$this->db = $cred[$t['d']];
			$this->charset = $cred[$t['ch']];
			$this->serverUser = $cred[$t['su']];
			$this->pass = $cred[$t['p']];
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

	private function init(){
		$this->connect();
		return $this->tagsNstrings;
	}

    // Function checking if given user Object username is exists in DataBase.
	// Can check if only username exists if onlyUser string given
    // or username and password if no string sended
	// Returning true or false 
	public function userExists($act)
	{
		try
		{
			$t = $this->init();

			$stmnt=Query::select($this->connection,$t['up']);
			$stmnt->execute(array($this->user->getUserName()));

			while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
				if($act==$t['uap']&&$row[$t['u']]==$this->user->getUserName()&&password_verify($this->user->getPassword(),$row[$t['ps']]))						    
					return $row;
				else if($act==$t['ou']&&$row[$t['u']]==$this->user->getUserName())				
					return true;
				else if($act==$t['f']&&$row[$t['u']]==$this->user->getUserName())				
					return $row[$t['e']];
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
			$t = $this->init();

			$stmnt1=Query::TableCreate($this->connection,$this->user->getUserName());
			$stmnt2=Query::insert($this->connection,$t['up']);
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

	public function getUserAlarms($t)
	{
		$alarm=array($t['ph']=>"",$t['pl']=>"",$t['th']=>"",$t['tl']=>"");
		$stmnt=Query::select($this->connection,$t['up']);
		$stmnt->execute(array($this->user->getUserName()));
		while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
			$alarm=$this->helpingClass->UserAlarms_DataArrange($alarm,$row);
		}
		return $alarm;
	}

	public function chartQuery($msg,$feedAlertSkip=false)
	{
		$defineAlarmFlag=false;
		$feedingTime=false;			
		try 
		{
			$t = $this->init();

			$dataArr=array($t['T']=>"",$t['P']=>"",$t['l']=>"",
			$t['a']=>$msg->getMessge($t['nd']),$t['lt']=>"",$t['pr']=>"");

			$alarms=$this->getUserAlarms($t);
			$dataArr[$t['pr']]=implode(',',$alarms[$t['pr']]);
			unset($alarms[$t['pr']]);
			$dataArr=$this->helpingClass->chartQuery_AlarmsAndFeedingCheck($alarms,$dataArr,$feedAlertSkip,$feedingTime,$defineAlarmFlag,$msg);

			$stmnt=Query::select($this->connection,$this->user->getUserName(),$t['s']);
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
			$t = $this->init();
			$stmnt=Query::update($this->connection,$t['up'],$this->user->getUserName(),$whatToChange);
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