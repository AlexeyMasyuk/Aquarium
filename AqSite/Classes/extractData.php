<?php
class extractData
{
    public $ClassData;
    public function __construct($location){
        require_once('fileHandler.php');
        $class_data=fileHandler::Pull('../TextData/ClassWrapData.txt')[$location];

        if(array_key_exists('include',$class_data)!==false){
            foreach($class_data['include'] as $val){
                require_once($val);
            }
            unset($class_data['include']);
        }
        
        $this->ClassData=$class_data;
    }
}

function Init($location)
{
    $extracteData = new extractData($location);
    return $extracteData->ClassData;
}
?>