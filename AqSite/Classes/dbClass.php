<?php 
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Class that handling all sqlDB itaration,
	using DB_DataHandler for data format adjustment.
    ------------------------------------------------------
	Using 'extractData' wrapper that contains all needed  
	includes, strings and sqlDB credential for the class.
	** Lines 12-14 unwrapind class data and store it
	   in $extracted parameter. Data pulled and stored, in 
	   $tagsNstrings via class constructor.
	------------------------------------------------------
*/

require_once('extractData.php');
global $extracted;
$extracted = Init(basename(__FILE__,".php"));    // Getting data from wraping class.

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
	
	// Cunstractor, initializing all needed parameeters for sqlDB connection
	// and helping Class object (DB_DataHandler).
	// after pulling unwraped class data ia global variable. 
	// Unsseting sqlDB credential after initialization.
	// Need User object for construction. 
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

	private function connect()    //  Connecting to Data Base
	{
		$dns = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
		$this->connection = new PDO($dns, $this->serverUser, $this->pass, $this->opt);
	}

	public function disconnect()  //  Disconnect to Data Base
	{
		$this->connection = null;
	}

	// Connecting to sqlDB and returning all tags and strings array.
	private function init(){      
		$this->connect();       
		return $this->tagsNstrings;
	}

    // Function checking if '$this->user' exists in sqlDB.
	// Can check if only username exists,
	// returning sql row for arduinoUserValidation() use,
    // or username and password, returning true/false, 
	// or same as first but returning user email for foreget password action
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
	

	// Function to write new user in user table and new user table in sqlDB
	// using data stored in user class object given on construction.
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

	// Function pulling user data from sqlDB,
	// alarms limits and personal data.
	// $tbl -> table name for userData.
	// Returning aranged data stored in $userData
	public function getUserData($tbl)
	{
		$userData=array();
		$stmnt=Query::select($this->connection,$tbl);
		$stmnt->execute(array($this->user->getUserName()));
		while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
			$this->helpingClass->UserAlarmsAndPersonal_DataArrange($userData,$row);
		}
		return $userData;
	}

	// Function pulling all needed data for JS Chart and setting change display.
	// Needs Message class object, Optionally skips alert if flag rised.
	// Using helpingClass functions for data crop and manipulation.
	// Returning all data stored in $dataArr or false if exception thrown.
	public function chartQuery($msg,$feedAlertSkip=false)
	{
		$defineAlarmFlag=false;
		$feedingTimeFlag=false;			
		try 
		{
			$t = $this->init();

			$alarms=$this->getUserData($t['up']);
			$dataArr=$this->helpingClass->UserDataInit($msg,$alarms);
			$dataArr=$this->helpingClass->chartQuery_AlarmsAndFeedingCheck($alarms,$dataArr,$feedAlertSkip,$feedingTimeFlag,$defineAlarmFlag,$msg);

			$stmnt=Query::select($this->connection,$this->user->getUserName(),$t['s']);
			$stmnt->execute(array());
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
				$dataArr=$this->helpingClass->chartQuery_sqlRow_strToArr($row,$alarms,$dataArr,$feedingTimeFlag,$defineAlarmFlag,$msg);
			}
			
			$dataArr=$this->helpingClass->chartQuery_noAlarmsCheck($dataArr,$defineAlarmFlag,$feedingTimeFlag,$msg);

			return $dataArr;
		} catch (Exception $e) {
			$this->disconnect();
			return false;
		}
		finally{
			$this->disconnect();
		}
	}

	// Function changing user alarms limits and/or credential,
	// depenting on $whatToChange parameter,
	// sqlBD user data will be changed to parameter stored in $data.
	// ** Updating one cell per iteration.
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

	// Function for validating connection between the arduino and the sqlDB.
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