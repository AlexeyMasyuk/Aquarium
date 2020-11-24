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
	private String $settingsEmptyField;
	private String $settingsBadInp;
	private String $settingsNotChoosen;
	
	public function __construct()
	{
		$this->Wrong="<div class='errorMessage'><img onload='openForm()'class='attention' src='images/attention.png ' alt=''><p>No such user or wrong password</p></div>";
		$this->userExist="User already exists. Choose diffrent username";
		$this->queryError="Cannot save your data. Try again please";
		$this->noDeletedData="No match. No deleted data.";
		$this->fileFail="Faild to create file. Please try again .";
		$this->cannotBeUser="User name  cannot be only a number<br/>choose other one.";
		$this->settingsEmptyField="Please fill all the choosen field you want to change .";
		$this->settingsNotChoosen="Press on Personal or Aquarium and select settings to update";
	}
	
	public function getWrong(){return $this->Wrong;}
	public function getUserExist(){return $this->userExist;}
	public function getQueryError(){return $this->queryError;}
	public function getNoDeletedData(){return $this->noDeletedData;}
	public function getFileFail(){return $this->fileFail;}
	public function getCannotBeUser(){return $this->cannotBeUser;}
	public function getEmptyField(){return $this->settingsEmptyField;}
	public function settingsNotChoosen(){return $this->settingsNotChoosen;}

	private function aqua($name){
			$msg= " must be a number between ! and ?.";
			$signs=array("!","?");
			$tmpVal=array("15","30");
			$phVal=array("6.5","8");
			if(strpos($name,"ph") !== false)
				$this->settingsBadInp = "PH".str_replace($signs,$phVal,$msg);
			else if(strpos($name,"temp") !== false)
				$this->settingsBadInp = "Temperature".str_replace($signs,$tmpVal,$msg);
	}

	private function personal($name){
			$nameMsg=" Name must be up to 20 characters (contain  letters only)";
			if(strpos($name,"email") !== false)
			    $this->settingsBadInp = "Wrong email format";
			else if(strpos($name,"pass") !== false)
			    $this->settingsBadInp ="Password must be minimum 9 up to 20 signs and contain numbers and letters";
			else if(strpos($name,"fname") !== false)
				$this->settingsBadInp = "First".$nameMsg;
			else if(strpos($name,"lname") !== false)
			    $this->settingsBadInp = "Last".$nameMsg;
	}

	public function getSettingsBadInp($name){
		$this->aqua($name);
		$this->personal($name);
		return $this->settingsBadInp;
	}
}
?>