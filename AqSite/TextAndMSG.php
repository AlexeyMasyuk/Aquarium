<?php
require_once('functions.php');
//Alexey Masyuk,Yulia Berkovich Aquarium Control Sistem
class TextMssg{
    private $mssgArr;

    public function __construct($filePath){
        $this->mssgArr=messegeDataPull($filePath);
    }


    public function getMessge($value){
        if(isset($this->mssgArr[$value])){
            return $this->mssgArr[$value];
        }
        return false;
    }
}