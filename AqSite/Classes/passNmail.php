<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Class that handling all mail and password needs.
    ------------------------------------------------------
	Using 'extractData' wrapper that contains all needed  
	strings and text for the class.
	** Lines 14-16 unwrapind class data and store it
	   in $extractedPnM parameter. Data pulled and stored in 
	   $tagsNstrings via GetPageData() function using global.
	------------------------------------------------------
*/

require_once('extractData.php');
global $extractedPnM;
$extractedPnM = Init(basename(__FILE__,".php"));

class PnM extends extractData
{
	// Function pulling wrapped class data
	// via global variable and return needed data.
    private static function GetPageData(){
        global $extractedPnM;
        $tagsNstrings=$extractedPnM[tNs];
        return $tagsNstrings;
    }

	// Funcrion returning hashed password.
	public static function passHash($pass){
		return password_hash($pass, PASSWORD_DEFAULT);
	}

	// Function returning true/false depends on match
	//  of two given parameters $pass and $cryptPass.
	public static function passCheck($pass,$cryptPass){
		return password_verify($pass,$cryptPass);
	}
	
	// Function returning random password,
	// generating one number, one lowercase 
	// and one uppercase caracter three times.
	public static function PassGen(){
		$pass;
		for($i=0;$i<3;$i++){
			$pass.=chr(rand(48,57));
			$pass.=chr(rand(65,90));
			$pass.=chr(rand(97,122));
		}
		return $pass;
	}

	// Function handling forget pass action,
	// generating new password using PassGen(),
	// sending mail to user and returning hashed 
	// pasword to be saved in sqlDB.
	public static function newPassAction($mail){
		$t = self::GetPageData();

		$pass=self::PassGen();
		$subject=$t[$t['nps']];
		$message=$t[$t['npm']].$pass;
		$headers=$t[$t['h']];
		mail($mail,$subject,$message,$headers);
		return self::passHash($pass);
	}
	
	// Function sending mail to user, to mail saved in given parameter $mail,
	// after registrating to the site.
	public static function sendMail($mail){
		$t = self::GetPageData();

		$subject=$t[$t['sms']];
		$message=$t[$t['smm']];
		$headers=$t[$t['h']];
		mail($mail,$subject,$message,$headers);
	}
}
?>