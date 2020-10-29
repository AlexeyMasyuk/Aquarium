<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('userClass.php');
require_once('Querys.php');

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
		$this->connect();
		$stmnt=Query::select($this->connection,"userpass");
		$stmnt->execute(array());
		print_r($this->user);
		while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
			if($act=="userAndPass"&&$row["username"]==$this->user->getUserName()&&$row["password"]==$this->user->getPassword()){			
				$this->disconnect();
				return true;
			}
			if($act=="onlyUser"&&$row["username"]==$this->user->getUserName())
			{
				$this->disconnect();
				return true;
			}
		}
		$this->disconnect();
		return false;
	}
	

	// Function to write new user in user table and new user table in DataBase 
	// or delete user from user table and delete user data table
	// If act is create handlerDecide func will generate needed query to create user and users table
    // else querys to delete users data from DataBase returned and querys activated
	// return true or false depends if querys seccsed
	public function userCreate()
	{
		$this->connect();
		$stmnt1=Query::TableCreate($this->connection,$this->user->getUserName());
		$stmnt2=Query::insert($this->connection,"userpass");
		if($stmnt1->execute(array()))
		{
			if($stmnt2->execute(array($this->user->getUserName(),$this->user->getPassword(),$this->user->getFirstName(),$this->user->getLastName(),$this->user->getEmail())))
			{
				$this->disconnect();
				return true;
			}
			else
				{
					$this->disconnect();
					return false;
				}
		}
		else
			{
				$this->disconnect();
				return false;
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

	public function chartQuery($name)
	{
		$dataArr=array('temp'=>"",'PH'=>"",'level'=>"");		
		$this->connect();
			try {
					$result = $this->connection->query("SELECT * FROM `".$name."`");
					if($result){
						while($row = $result->fetch(PDO::FETCH_ASSOC)) {
							$ph .= "['".$row{'time'}."',".$row{'ph'}."],";
							$temp .= "['".$row{'time'}."',".$row{'temp'}."],";
							$level .="['".$row{'time'}."',".$row{'level'}."],";
						}
						$dataArr['temp']=$temp;
						$dataArr['PH']=$ph;
						$dataArr['level']=$level;
				    	return $dataArr;
					}

			} catch (Exception $e) {
		    	$this->disconnect();
			}
			$this->disconnect();
	}
}
?>