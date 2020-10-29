<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control Sistem
//class for storing user data
class User
{
	private $firstName;
	private $lastName;
	private $userName;
	private $password;
	private $email;
	private $temperature;
	private $level;
	private $ph;
	
	public function __construct($userName,$password,String $firstName="",String $lastName="",String $email="")
	//initialization
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->userName = $userName;
	    $this->password = $password;
		$this->email = $email;
		$this->temperature=$temperature;
		$this->level=$level;
		$this->ph=$ph;
	}
	//functions "get"
	public function getFirstName(){return $this->firstName;}
	public function getLastName(){return $this->lastName;}
	public function getUserName(){return $this->userName;}
	public function getPassword(){return $this->password;}
	public function getEmail(){return $this->email;}
	public function getTemperature() {return $this->temperature;}
	public function getLevel() {return $this->level;}
	public function getPh() {return $this->ph;}
	
	public function toString()
	{
		return $this->firstName." ".$this->lastName." ".$this->userName." ".$this->password." ".$this->email;
	}
}
?>					