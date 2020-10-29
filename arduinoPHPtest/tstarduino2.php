<?php
require_once('dbClassT.php');

function cut($str)
{
	$data = array("user" => substr($str, 0, strpos($str, " "))
	            , "pass" =>"");
	$data['pass'] = substr($str, strlen($data['user'])+1, strlen($str)-strlen($data['user'])-2);
	
	return $data;
}


if(isset($_POST["data"])){
    $data = $_POST["data"];
	$sql = new dbClassT();
	$dataArr = cut($data);
	if($initData = $sql->check($dataArr['user'],$dataArr['pass']))
	{
		echo $initData;
	}
}
// else if(isset($_POST["collecteData"]))
// {
// 	$str=$_POST["collecteData"];
// 	$pieces = explode(",", $_POST["collecteData"]);
// 	$sql = new dbClassT();
// 	$sql->insert($pieces);
// }
?>