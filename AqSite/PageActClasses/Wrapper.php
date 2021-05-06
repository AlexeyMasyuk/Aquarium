<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Wrapping class - for all page actions used in the Site (all classes in the folder).

    1. Using fileHandler class for reading all needed data 
      from dedicated DataFile (PageTagMap.txt).
    2. If 'include' found among the data needed, require the needed files.
    3. If 'wantedSess' found among the data needed,
      getting the needed data from session.
    4. MoveTo($moveToPage) used by all page actions classes.
*/
define("fileHandlerPath",'../Classes/fileHandler.php');
define("dataFilePath",'../TextData/PageTagMap.txt');
define("ws",'wantedSess');
define("sessHandlerPath",'../Classes/sessionHandler.php');
define("sa",'sessArr');

require_once(fileHandlerPath);
class WrappingClass {
  public $tagMap;
  public $T;
  public function __construct($location) {
    
    $TM=fileHandler::Pull(dataFilePath)[$location];                  // 1
    foreach($TM[i] as $val){                                         // 2
      require_once($val);
    }
    if(array_key_exists(ws,$TM)!==false||in_array(ws,$TM)!==false){  // 3
      require_once(sessHandlerPath);
      $TM[sa]=sessionClass::sessionPull($TM[ws]);
    }
    $this->T=$TM[tNs];
    unset($TM[tNs]);
    $this->tagMap=$TM;
  }

  public function MoveTo($moveToPage){  // 4
    header($moveToPage); 
    exit; 
  }
}
?>