<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control System

require_once('extractData.php');
global $extractedPnM;
$extractedPnM = Init(basename(__FILE__,".php"));

class PnM extends extractData
{
    private static function GetPageData(){
        global $extractedPnM;
        $tagsNstrings=$extractedPnM['tagsNstrings'];
        return $tagsNstrings;
    }

	public static function passHash($pass){
		return password_hash($pass, PASSWORD_DEFAULT);
	}

	public static function passCheck($pass,$cryptPass){
		return password_verify($pass,$cryptPass);
	}
	
	public static function PassGen(){
		$pass;
		for($i=0;$i<3;$i++){
			$pass.=chr(rand(48,57));
			$pass.=chr(rand(65,90));
			$pass.=chr(rand(97,122));
		}
		return $pass;
	}
	
	public static function newPass($mail){
		$t = self::GetPageData();

		$pass=self::PassGen();
		$subject=$t[$t['nps']];
		$message=$t[$t['npm']].$pass;
		$headers=$t[$t['h']];
		mail($mail,$subject,$message,$headers);
		return self::passHash($pass);
	}
	
	public static function sendMail($mail){
		$t = self::GetPageData();

		$subject=$t[$t['sms']];
		$message=$t[$t['smm']];
		$headers=$t[$t['h']];
		mail($mail,$subject,$message,$headers);
	}
}
?>