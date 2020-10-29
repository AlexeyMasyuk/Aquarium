<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System
require_once('userClass.php');
class Query
// Class to generate all needed querys for user handle with SQL
{
	private String $insert;
	private String $tableCreate;
	private String $userSelect;
	private String $dataSelect;
	private String $delUser;
	private String $delTabl;
	private String $delData;
	
	public function __construct($user)
	{
		
		$this->insert="INSERT INTO `userpass` (`username`, `password`, `firstName`, `lastName`, `email`, `temp`, `ph`)
		VALUES ('".$user->getUserName()."', '".$user->getPassword()."', '".$user->getFirstName()."', '".$user->getLastName()."', '".$user->getEmail()."', '', '')";

		$this->tableCreate="CREATE TABLE `php_prj`.`".$user->getUserName()."`
		                    ( `time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `temp` VARCHAR(5) NOT NULL ,
		                      `ph` VARCHAR(5) NOT NULL , `level` VARCHAR(5) NOT NULL , PRIMARY KEY (`time`)) ENGINE = InnoDB;";
        $this->userSelect="SELECT * FROM userpass";
        $this->dataSelect="SELECT * FROM ".$user->getUserName();
        $this->delUser="DELETE FROM userpass WHERE username='".$user->getUserName()."';";
        $this->delTabl="DROP TABLE ".$user->getUserName().";";
		$this->delData="DELETE FROM ".$user->getUserName();
	}
	
	// returning relevant delete query 
	// delete all data if * sent
	// or specific date if sent
	public function getDelData($data)
	{
		if($data=='*')
		{
			$this->delData=$this->delData.";";
		    return $this->delData;
		}
		$this->delData=$this->delData." WHERE time='".$data."';";
		return $this->delData;
	}
	public function getInsert(){return $this->insert;}
	public function getTableCreate(){return $this->tableCreate;}
	public function getUserSelect(){return $this->userSelect;}
	public function getDataSelect(){return $this->dataSelect;}
	public function getDelUser(){return $this->delUser;}
	public function getDelTabl(){return $this->delTabl;}
}
?>