<?php
class Page {
    public $tagMap;
    public $T;
    public function __construct($location) {
      require_once('../fileHandler.php');
      $TM=fileHandler::Pull('../PageTagMap.txt',false)[$location];
      foreach($TM['include'] as $val){
          require_once($val);
      }
      if(array_key_exists('wantedSess',$TM)!==false||in_array('wantedSess',$TM)!==false){
          require_once('../sessionHandler.php');
          $TM['sessArr']=sessionClass::sessionPull($TM['wantedSess']);
      }
      // if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
      // {
      //   $this->tagMap=array_map( 'stripslashes', $this->tagMap );
      // } 
 
      $this->tagMap=$TM;
      $this->T=$TM['tagsNstrings'];
    }

    public function MoveTo($moveToPage){
      header($moveToPage); 
      exit; 
  }
  }
?>