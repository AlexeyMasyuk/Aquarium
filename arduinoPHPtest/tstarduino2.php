<?php
require_once('dbClassT.php');

if(isset($_POST["data"])){
    $data = $_POST["data"];
	$sql = new dbClassT();
	$pieces = explode(",", $data);   
	if($initData=$sql->check($pieces[0],$pieces[1]))
	{
		echo $initData;
	}
}


?>