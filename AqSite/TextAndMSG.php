<?php
include_once('fileHandler.php');
//Alexey Masyuk,Yulia Berkovich Aquarium Control Sistem
class TextMssg{
    private $mssgArr;

    public function __construct($filePath){
        $this->mssgArr=fileHandler::messegePull($filePath);
    }


    public function getMessge($value){
        if(isset($this->mssgArr[$value])){
            return $this->mssgArr[$value];
        }
        return false;
    }
}