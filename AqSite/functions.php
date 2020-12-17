<?php
//Alexey Masyuk,Yulia Berkovich Aquarium Control System
function nameCheck($name)
//function for check name(if string not only numbers) ,User name  cannot be only a number
{
	if(strlen($name)>0&&($name[0]>='a'&&$name[0]<='z'||$name[0]>='A'&&$name[0]<='Z'))
		return true;
	else
		return false;
}

function nameGenerator()
{
	$fname="Data_tmp_time.txt";
	if(!file_exists($fname))
	{
		return $fname;
	}
	else
	{
		$name=$fname;
		for($i=1;file_exists($name);$i+=1)
		{
			$name=str_replace(".txt","",$fname).'('.$i.')'.".txt";
			if(!file_exists($name))
				return $name;
		}
	}
}

function dataToFile($data)
//function to create a file and save temperature data for user
{
	$name=nameGenerator();
	$myfile = fopen($name, "w") or die("Unable to open file!");
	if($myfile)
	{
		$txt="Data file\nTemperature  Time\n";
		foreach($data as $k=>$Kval)
		{
			$txt=$txt.$Kval['tmp']."             ".$Kval['time']."\n";
		}
		if(fwrite($myfile, $txt))
		{
			fclose($myfile);
			return true;
		}
		fclose($myfile);
		return false;
	}
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
	$subject='Aquarium New Pass!';
	$message="Hello! You'r new passyord is: ".$pass;
	$headers='From: AquariumControlSystem@from_mail'."\r\n".'X-Mailer:PHP/'.phpversion();
	mail($mail,$subject,$message,$headers);
	return passHash($pass);
}

function sendMail($mail)
{
	$subject='Welcome!';
	$message='Welcome!Registration completed successfully!';
	$headers='From: AquariumControlSystem@from_mail'."\r\n".'X-Mailer:PHP/'.phpversion();
	mail($mail,$subject,$message,$headers);
}

function messegeDataSlice($str,$arr,&$i,$stopSign){
	$tmp="";
	$i++;
	for(;$str[$i]!=$stopSign;$i++){
		$tmp.=$str[$i];
	}		
	$i++;
	array_push($arr,$tmp);
	return $arr;
}



function messegeDataPull($filePath){
	try{
		$strLine=file_get_contents();

		$k=array();
		$value=array();
		$newArr=array();

    	for($i=0;$i<strlen($strLine);$i++){
			if("_"==$strLine[$i]){
				$k=messegeDataSlice($strLine,$k,$i,'_');
			}
			if($strLine[$i]=='$'){
				$value=messegeDataSlice($strLine,$value,$i,'$');
			}
		}

		for($i=0;$i<count($k);$i++){
			$newArr[$k[$i]]=$value[$i];
		}
		
		if(count($newArr)>0){
			return $newArr;
		}
		return false;
	}catch(Exeption $e){
		return false;
	}
}
?>