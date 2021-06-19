<?php
require_once('Wrapper.php');

class AFS extends WrappingClass
{

	public ArduinoValidation($postArr){
		$t=$this->T;

		$data = $postArr[$t['d']];
	
		$pieces = explode(",", $data);
		$user=new User($pieces[0],$pieces[1]);
		$sql = new dbClass($user);
	
		if($validation=$sql->arduinoUserValidation())
		{
			echo $validation;
		}
	}

	public ArduinoToDB($postArr){
		$t=$this->T;
		$sp=explode(',',$postArr[$t['p']]);
		$user=new User($sp[count($sp)-1],"");
		unset($sp[count($sp)-1]);
		$sql = new dbClass($user);
		$sql->arduinoPush($sp);
	}
}
$ard=new AFS(basename(__FILE__,p));
if(isset($_POST[d])){
	$ard->ArduinoValidation($_POST);
}
else if(isset($_POST[ps])){
	$ard->ArduinoToDB($_POST);
}
?>