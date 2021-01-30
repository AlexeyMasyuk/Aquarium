<?php
class Page{
    public $PageData;
    public function __constructor($location,$session=false){
        require_once('fileHandler.php');
        $tagMap=fileHandler::Pull('PageTagMap.txt',false);
        foreach($tagMap[$location]['include'] as $val){
            require_once($val);
        }
        if($session){
            require_once('sessionHandler.php');
            $tagMap[$location]['sessArr']=sessionClass::sessionPull($tagMap[$location]['wantedSess']);
        }
        self::$PageData=$tagMap[$location];
    }
}
?>