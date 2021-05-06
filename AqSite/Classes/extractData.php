<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Wrapping class - for all helping classes used in the Site (all classes in the folder).
    Can be initiated in two methods, 1st method is via constructor,
    2nd is via Init($location) function for static classes.
    The location parameter that needed, need to be without file extension (.php)

    1. Using fileHandler class for reading all needed data 
       from dedicated DataFile (ClassWrapData.txt).
    2. If 'include' found among the data needed, require the needed files.
    3. If 'rules' found among the data needed, convert strings to floats.
*/
define("FH",'fileHandler.php');                   // Class for reading DataFile, 
define("Path",'../TextData/ClassWrapData.txt');   // DataFile path
define("In",'include');
class extractData
{
    public $ClassData;

    public function __construct($location){
        require_once(FH);
        $class_data=fileHandler::Pull(Path)[$location];   // 1

        if(array_key_exists(In,$class_data)!==false){     // 2
            foreach($class_data[In] as $val){
                require_once($val);
            }
            unset($class_data[In]);
        }
        if(array_key_exists(r,$class_data)!==false){      // 3
            $i=0;
            foreach($class_data[r] as $key=>$val){
                $class_data[r][$key]=floatval($val);
            }
        }
        $this->ClassData=$class_data;
    }
}

function Init($location)     // Alternative entrance for static classes
{
    $extracteData = new extractData($location);
    return $extracteData->ClassData;
}
?>