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

    Data stored in PageTagMap example:

    [chartData] - class file name of stored data below.

    include=dbClass,TextAndMSG,sessionHandler;
    wantedSess=user,msg,feedAlertSkip;
    tagsNstrings=u-user,m-msg,fAS-feedAlertSkip,sA-sessArr;    
*/
// define("fileHandlerPath",'../Classes/fileHandler.php');
// define("dataFilePath",'../TextData/PageTagMap.txt');
// define("sessHandlerPath",'../Classes/sessionHandler.php');

define("ws",'wantedSess');
define("sa",'sessArr');

// echo " ".substr_count(getcwd(),'\\')." ";
// exit;
if(substr_count(getcwd(),'\\')<=3){                     // If wrapper if called from root folder
  define("fileHandlerPath",'Classes/fileHandler.php');
  define("dataFilePath",'TextData/PageTagMap.txt');
  define("sessHandlerPath",'Classes/sessionHandler.php');
}
else{
  define("fileHandlerPath",'../Classes/fileHandler.php');
  define("dataFilePath",'../TextData/PageTagMap.txt');
  define("sessHandlerPath",'../Classes/sessionHandler.php');
  
}

require_once(fileHandlerPath);
class WrappingClass {
  public $tagMap;
  public $T;
  public function __construct($location) {

    $TM=fileHandler::Pull(dataFilePath)[$location];                   // 1

    foreach($TM[i] as $val){                                          // 2
      strpos(fileHandlerPath,"../")!==false?null:$val=substr($val,3); // Adjusting path if called from root folder

      
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