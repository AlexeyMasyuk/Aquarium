<?php
require_once('fileHandler_dataCrop.php');

class fileHandler{
    private static function dataCrop(){
        return new fileHandler_dataCrop();
    }

    public static function messagePull($filePath){
        try{
            $cropClass=self::dataCrop();
            $strLine=file_get_contents($filePath);
    
            $newArr=$cropClass->message_strToKeyAndValueArr($strLine);
            
            $mssgArr=array();
            for($i=0;$i<count($newArr['key']);$i++){
                $mssgArr[$newArr['key'][$i]]=$newArr['value'][$i];
            }
            
            if(count($mssgArr)>0){
                return $mssgArr;
            }
            return false;
        }catch(Exeption $e){
            return false;
        }
    }
    
    public static function rulesPull(){
        try{
            $cropClass=self::dataCrop();
            $strLine=file_get_contents("inputRules.txt");
            $split=explode(";",$strLine);
            $rulesArr=$cropClass->rulesFile_StrToArray($split);
            if(count($rulesArr)>0){
                return $rulesArr;
            }
            return false;
        }catch(Exeption $e){
            return false;
        }
    }
}

?>