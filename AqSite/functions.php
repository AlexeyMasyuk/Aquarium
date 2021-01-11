<?php
include_once('fileHandler.php');
//Alexey Masyuk,Yulia Berkovich Aquarium Control System
function nameCheck($name)
//function for check name(if string not only numbers) ,User name  cannot be only a number
{
	if(strlen($name)>0&&($name[0]>='a'&&$name[0]<='z'||$name[0]>='A'&&$name[0]<='Z'))
		return true;
	else
		return false;
}

function settChgeValidation($key,$inp,$rulesArr){

    if($key=="email"){
        if(strpos($inp, "@")>0 && strpos($inp, ".")<strlen($inp)-1)
           return true;
        return false;
    }
    else if($key=="fname"||$key=="lname"){
        if ((ctype_alpha(str_replace(' ', '', $inp)) === false)||strlen($inp)>$rulesArr['fnamelnameMaxLen'])
            return false;
        return true;
    }
    else if($key=="tempHigh"||$key=="tempLow"){
        if (is_numeric($inp) == true)
            if(floatval($inp)<=$rulesArr['tempMax'] && floatval($inp)>=$rulesArr['tempMin'])
                return true;
    }
    else if($key=="phHigh"||$key=="phLow"){
        if (is_numeric( $inp) == true)
            if(floatval($inp)>=$rulesArr['phMin'] && floatval($inp)<=$rulesArr['phMax'])
                return true;
    }
    else if($key=="pass"){
        if(preg_match("/[a-z]/i", $inp) && preg_match('/[0-9]/', $inp))
            return true;
    }
    return false;
}

function passHash($pass){
	return password_hash($pass, PASSWORD_DEFAULT);
}

function passCheck($pass,$cryptPass){
	return password_verify($pass,$cryptPass);
}

function PassGen(){
	$pass;
	for($i=0;$i<3;$i++){
		$pass.=chr(rand(48,57));
		$pass.=chr(rand(65,90));
		$pass.=chr(rand(97,122));
	}
	return $pass;
}

function newPass($mail)
{
	$pass=PassGen();
	$subject="Aquarium New Pass!";
	$message="Hello! You'r new passyord is: ".$pass;
	$headers="From: AquariumControlSystem@from_mail";
	mail($mail,$subject,$message,$headers);
	return passHash($pass);
}

function sendMail($mail)
{
	$subject="Welcome!";
	$message="Welcome!Registration completed successfully!";
	$headers="From: AquariumControlSystem@from_mail";
	mail($mail,$subject,$message,$headers);
}
?>