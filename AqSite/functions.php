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

function sendMail($mail)
{
	$subject='Welcome!';
	$message='Welcome!Registration completed successfully!';
	$headers='From: AquariumControlSystem@from_mail'."\r\n".'X-Mailer:PHP/'.phpversion();
	mail($mail,$subject,$message,$headers);
}
?>