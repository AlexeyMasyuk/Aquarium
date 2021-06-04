<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Helping dbClass Class handle all needed manipulation for data taken from ssqlDB
	and fitting it to the site needs.
	Include dateTimeHandler needed
*/

require_once('dateTimeHandler.php');
// define RULES for reading data.
define("key_seperatingChar", "_");   // Message tag seperator
define("value_seperatingChar", "$"); // Message seperator
define("rulesEqual", "=");
define("endOfTagedData", ";");
define("betweenDataNtagSep", ",");
define("dataNtagSep", "-");
define("pageTagStart", "[");
define("pageTagEnd", "]");
// frequently used
define("k", "key");
define("v", "value");
// Tags for DataRules()
define("h", "headers");
define("l", "Location:../");
define("p", ".php");
define("i", "include");
define("c", "../Classes/");
define("t", "txt");
define("td", ".txt");
define("TD", "../TextData/");
define("r", "rules");
define("f", "feedAlert");

// Used for Validation
define("az",'/[a-z]/i');
define("zn",'/[0-9]/');
define("tNs",'tagsNstrings');

class fileHandler_dataCrop{
//-------------------------------- Messege Func --------------------------------//

    // Function slicing text until given $stopSign,
    // removing // and returning cutted text.
    private function messege_DataSlice($str,$arr,&$i,$stopSign){
        $tmp="";
        $i++;
        for(;$str[$i]!=$stopSign;$i++){
            $tmp.=$str[$i];
        }		
        $i++;
        if ( strpos("//",$tmp)!==false )
        {
          $tmp=str_replace( '//','/',$tmp );
        }  
        array_push($arr,$tmp);
        return $arr;
    }

    // Function seperating key (seperated by _) and masseges (seperated by $),
    // initializing relevan key to data and returning new messaage array.
    public function message_strToKeyAndValueArr($strLine){
        $newArr=array(k=>array(),v=>array());
        for($i=0;$i<strlen($strLine);$i++){
            if(key_seperatingChar==$strLine[$i]){
                $newArr[k]=self::messege_DataSlice($strLine,$newArr[k],$i,key_seperatingChar);
            }
            if($strLine[$i]==value_seperatingChar){
                $newArr[v]=self::messege_DataSlice($strLine,$newArr[v],$i,value_seperatingChar);
            }
        }
        $mssgArr=array();
        for($i=0;$i<count($newArr[k]);$i++){
            $mssgArr[$newArr[k][$i]]=$newArr[v][$i];
        }  
        return $mssgArr;
    }

    //-------------------------------- Messege Func End ----------------------------//

    //--------------------------------- PageTagMap & ClassWrapData Func ----------------------------//

    // Function adjusting extracted data to needed rules,
    // Adding Location, adding needed file extension,
    // correcting path and setting feeding alarm for default rules.
    // Itarating per one data kind in fileName (PageTagMap & ClassWrapData main tag seperator is file name).
    // Returning arranged one data kind in given fileName
    private function DataRules($dataArr,$fileName,$pageData,$dataName){
        foreach($dataArr as $tagName=>$val)
        {
            if(strpos($dataName,h)!==false)
            {
                $pageData[$fileName][$dataName][$tagName]=l.$val.p;
            }
            else if(strpos($dataName,i)!==false)
            {
                $pageData[$fileName][$dataName][$tagName]=c.$val.p;
            }
            else if(strpos($dataName,t)!==false)
            {
                $pageData[$fileName][$dataName][$tagName]=TD.$val.td;
            }
            else if(strpos($dataName,r)!==false)
            {      
                if(strpos($tagName,f)!==false)
                {
                    $pageData[$fileName][$dataName][$tagName]=dateTimeHandler::feedingAlarmSet($val);
                } 
            }
        }
        return $pageData;
    }

    // Function iterating trought data and tags in the file 
    // and calling DataRules() for prepearing the needed values by wanted rules.
    private function rulesFile_RulesApply($pageData){
        foreach($pageData as $fileName=>$pageDataArr)
        {
            foreach($pageDataArr as $dataName=>$dataArr)
            {
                $pageData=$this->DataRules($dataArr,$fileName,$pageData,$dataName);
            }
        }
        return $pageData;
    }
    
    // Function seperating main tag/fileName, removing unneeded [].
    public function HeaderSplit($val,&$key)
    {
        $pageNamesSplit=explode(pageTagEnd,$val);	
        $key=substr($pageNamesSplit[0], strpos($pageNamesSplit[0],pageTagStart)+1,strlen($pageNamesSplit[0])-1);
        return $pageNamesSplit[1];
    }

    // Function controlling all cropping methods, seperating diffrent tags from the data.
    // $read -> all readed text from file
    public function rulesFile_StrToArray($read){
        $firstSplit=explode(endOfTagedData,$read);
        foreach($firstSplit as $val)
        {
            if(strpos($val,pageTagStart)!==false)
            {
                $val=$this->HeaderSplit($val,$key);
            }
            if(strpos($val,rulesEqual)!==false)
            {
                $val=trim(preg_replace('/\s\s+/', '', $val));
                $val=str_replace("\n", '', $val);
                $pageNamesSplit=explode(rulesEqual,$val);
                $pageDataSplit=explode(betweenDataNtagSep,$pageNamesSplit[1]);
                if(strpos($pageDataSplit[0],dataNtagSep)!==false)
                {
                    for($i=0;count($pageDataSplit)>$i;$i++)
                    {
                        $tmpArr=explode(dataNtagSep,$pageDataSplit[$i]);
                        $pageData[$key][$pageNamesSplit[0]][$tmpArr[0]]=$tmpArr[1];
                    }
                }
                else
                {
                    $pageData[$key][$pageNamesSplit[0]]=$pageDataSplit;
                }
            }
        }
        return isset($pageData)?self::rulesFile_RulesApply($pageData):false;
    }
    //--------------------------------- Rules Func Ends -----------------------------//
}

?>