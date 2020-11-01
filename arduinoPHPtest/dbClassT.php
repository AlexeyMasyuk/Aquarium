<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('Querys.php'); 

// Class to handle all worck with SQL DataBase
class dbClassT
{
	private $host;
	private $db;
	private $charset;
	private $user;
	private $pass;          
	private $opt=array(
	PDO::ATTR_ERRMODE   =>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
	public $connection;
	
	public function __construct(string $host="localhost", string $db = "php_prj",string $charset="utf8", string $user = "root", string $pass = "")
						{
							$this->host = $host;
							$this->db = $db;
							$this->charset = $charset;
							$this->user = $user;
							$this->pass = $pass;
						}

	public function connect()  //  Connecting to Data Base
	{
	$dns = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
	try {
		$this->connection = new PDO($dns, $this->user, $this->pass, $this->opt);
		return true;
	}
	catch(Exception $e){return false;}
	}

	public function disconnect(){
	  $this->connection = null;
	}

	
	
	public function check($user,$pass)
	{
		$st = "<NCDB>"; // not connected to db
		if($this->connect())
		{
			try{
				$tmpData=array();
				$qry=Query::select($this->connection, "userpass");
				if($qry->execute(array())){
					$st = "<NFU>"; // not found user
					while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
						if($row['username'] == $user && $row['password']==$pass){
							$st="<OKEY".$row['temp'].",".$row['ph']."\n>";
						}
					}
				}
			}catch(Exception $e){				
			}
			finally{
				$this->disconnect();
				return $st;
			}
		}
		return $st;
	}
}
?>