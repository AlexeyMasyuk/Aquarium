<?php
// Add to setting change, 'set to deafoult'
// Add Curent alarms view

require_once("includeNpath.php");
$tagMap=getIncludeNpathData(basename(__FILE__,".php"),true);
$T=$tagMap['tagsNstrings'];

$sql=new dbClass($tagMap[$T['sA']][$T['u']]);

$dataArr=array();
$notChoosen=true;

// val is a key for wanted data ex: array('emailCheckbox' => "email", 'email' => "alex@mail.com") 
foreach ($_POST as $key=>$val)
{
    if(strpos($key,$T['C'])){
        $notChoosen=false;
        if(strpos($key,$T['fA'])!==false){
            $_POST=dateTimeHandler::defaultFeedTimeAlert($val,$_POST);
        }
        if(strlen($_POST[$val])>0){
            if($valid=settChgeValidation($val,$_POST[$val],$tagMap[$T['sA']][$T['rA']][$T['sCL']])){
                $dataArr[$val]=$_POST[$val];               
            }
            if(!$valid){
                $flagMsg.=badInputMassegeChoose($val,$tagMap[$T['sA']],$T);
             }
        }
        else{
            if(!strpos($flagMsg,$T['fl'])){
                $flagMsg.=$T['b'].$tagMap[$T['sA']][$T['m']]->getMessge($T['EF']);
            }           
        }   
    }
}

function badInputMassegeChoose($val,$sessionArr,$T){
    $messageName="ChangeBadInput";
    if(strpos($val,$T['p'])!==false)
        $flagMsg.=$T['b'].$sessionArr[$T['m']]->getMessge($T['p'].$messageName);
    else if(strpos($val,$T['t'])!==false)
        $flagMsg.=$T['b'].$sessionArr[$T['m']]->getMessge($T['t'].$messageName);
    else
        $flagMsg.=$T['b'].$sessionArr[$T['m']]->getMessge($val.$messageName);
    return $flagMsg;
}

// echo "<pre>";
// print_r($tagMap);
// print_r(sessionClass::sessionPull(array('u','rulesArr')));
// echo "<pre>";

if($notChoosen){
    sessionClass::sessionPush(array($T['f']=>$T['b'].$tagMap[$T['sA']][$T['m']]->getMessge($T['NC'])));  
	header($tagMap[$T['h']][$T['a']]);
	exit;
}
else if(isset($flagMsg)){
    sessionClass::sessionPush(array($T['f']=>$flagMsg));  
	header($tagMap[$T['h']][$T['a']]);
	exit;
}
else{
	foreach ($dataArr as $key=>$val)
        $sql->change((strpos('pass',$key)!==false)?$val=passHash($val):$val,$key);
	header($tagMap[$T['h']][$T['mn']]);
	exit;
}
?>