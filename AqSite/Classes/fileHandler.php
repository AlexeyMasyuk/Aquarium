<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Class that handling all text files,
    reading stoerd data in text files.
	Using 'fileHandler_dataCrop' for data format adjustment,
    as all function in fileHandler are static dataCrop()
    initiate 'fileHandler_dataCrop' instance
    and used as first action in fileHandler functions.
*/
require_once('fileHandler_dataCrop.php');

class fileHandler{

    // Function initializing and returning 'fileHandler_dataCrop' instance.
    private static function dataCrop(){
        return new fileHandler_dataCrop();
    }

    // Function Pulling and cropping the messages stored in MessageBank.txt.
    // Returning message array or false if reading fail. 
    public static function messagePull($filePath){
        try{
            $cropClass=self::dataCrop();

            $strLine=file_get_contents($filePath);
            $mssgArr=$cropClass->message_strToKeyAndValueArr($strLine);         
            if(count($mssgArr)>0){
                return $mssgArr;
            }
            return false;
        }catch(Exeption $e){
            return false;
        }
    }
    
    // Function Pulling and cropping data text files (ClassWrapData.txt, PageTagMap.txt).
    // Returning all readed file as array or false if fail.    
    public static function Pull($path){
        try{
            $cropClass=self::dataCrop();
            
            $strLine=file_get_contents($path);
            $rulesArr=$cropClass->rulesFile_StrToArray($strLine);
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