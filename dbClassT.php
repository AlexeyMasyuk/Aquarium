<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System


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
	
	public function __construct(string $host="localhost", string $db = "test1",string $charset="utf8", string $user = "root", string $pass = "")
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

	public function disconnect()
	{
	$this->connection = null;
	}


	
	// Function deleating wanted data from user data table in DataBase
	public function store($data)
	{
		$this->connect();
		if($this->connection->exec("INSERT INTO `test` (`Temperature`) VALUES ('".$data."')"))
		{
			$this->disconnect();
			return true;
		}
		$this->disconnect();
		return false;
	}
	
	private function equal($data,$user,$pass)
	{
		if($data['users'][0]['username'] == $user && $data['users'][0]['password'] == $pass)
			return true;
	}
	
	function buildQuery( $get_var,$name ) 
    {
	    if(strlen($name)>0){
            switch($get_var)
            {
                case 1:
                    $sql = "SELECT * FROM $name";
                    break;
            }
	        $stmt = ($this->connection)->prepare($sql);
	        return $sql;
    	}
    }
	
	public function selectQuery($name)
	{
		$tmpData=array("flag" => 0);
			try {
				if($qry = $this->buildQuery( 1,$name )){
					$result = $this->connection->query($qry);
					if($result){
						while($row = $result->fetch(PDO::FETCH_ASSOC)) {
							array_push($tmpData,$row);
						}
				    	$tmpData['flag']=1;
				    	return $tmpData;
					}
				}
			} catch (Exception $e) {
		    	$this->disconnect();
			}
	}
	
	
	public function check($user,$pass)
	{
		$st = "<NCDB>"; // not connected to db
		if($this->connect())
		{
			$tmpData;
			$tmpData['users']=$this->selectQuery("userpass");
			$tmpData[$user."_initial"]=$this->selectQuery($user."_initial");
			if($tmpData["users"]['flag']==1&&$tmpData[$user."_initial"]['flag']==1){
				$st = "<WRNG>"; // Wrong user or no init data
				if($this->equal($tmpData,$user,$pass))
				{
					$init = $tmpData[$user."_initial"][0];			
					$st = "<OKEY".$init['Temp']." ".$init['co']." ".$init['ph']."\n>";		
				}
			}
		}
		return $st;
	}
}
?>