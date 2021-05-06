<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Class that store all needed messages for the site.
    ------------------------------------------------------
	** Need fileHandler as messages readed from text file.
       MessageBank.txt path defined below.
	------------------------------------------------------
*/

include_once('fileHandler.php');

define("messageBankPath","../TextData/MessageBank.txt");


class TextMssg{
    private $mssgArr;

    // Constructor pulling messages using fileHandler class
    // and storing it in $mssgArr.
    public function __construct(){
        $this->mssgArr=fileHandler::messagePull(messageBankPath);
    }

    // Function returning message from mssgArr,
    //  by given tag $value, if data existing. 
    public function getMessge($value){
        if(isset($this->mssgArr[$value])){
            return $this->mssgArr[$value];
        }
        return false;
    }
}