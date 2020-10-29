<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control Sistem
class MSG
//class for error messages
{
	private String $Wrong;
	private String $userExist;
	private String $noDeletedData;
	private String $fileFail;
	private String $cannotBeUser;
	
	public function __construct()
	{
		$this->Wrong="<div class='errorMessage'><img onload='openForm()'class='attention' src='images/attention.png ' alt=''><p>No such user or wrong password</p></div>";
		$this->userExist="User already exists. Choose diffrent username";
		$this->queryError="Cannot save your data. Try again please";
		$this->noDeletedData="No match. No deleted data.";
		$this->fileFail="Faild to create file. Please try again .";
		$this->cannotBeUser="User name  cannot be only a number<br/>choose other one.";
	}
	
	public function getWrong(){return $this->Wrong;}
	public function getUserExist(){return $this->userExist;}
	public function getQueryError(){return $this->queryError;}
	public function getNoDeletedData(){return $this->noDeletedData;}
	public function getFileFail(){return $this->fileFail;}
	public function getCannotBeUser(){return $this->cannotBeUser;}
}
?>