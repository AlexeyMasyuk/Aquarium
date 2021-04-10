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
	
	public function __construct($userName,$password,String $firstName="",String $lastName="",String $email="")
	//initialization
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->userName = $userName;
	    $this->password = $password;
		$this->email = $email;
	}
	//functions "get"
	public function getFirstName(){return $this->firstName;}
	public function getLastName(){return $this->lastName;}
	public function getUserName(){return $this->userName;}
	public function getPassword(){return $this->password;}
	public function getEmail(){return $this->email;}
	
}
?>					