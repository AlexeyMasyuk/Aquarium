<?php
require_once('dateTimeHandler.php');
    define("key_seperatingChar", "_");
    define("value_seperatingChar", "$");
    define("rulesEqual", "=");

class fileHandler_dataCrop{
//-------------------------------- Messege Func --------------------------------//

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

    public function message_strToKeyAndValueArr($strLine){
        $newArr=array('key'=>array(),'value'=>array());
        for($i=0;$i<strlen($strLine);$i++){
            if(key_seperatingChar==$strLine[$i]){
                $newArr['key']=self::messege_DataSlice($strLine,$newArr['key'],$i,key_seperatingChar);
            }
            if($strLine[$i]==value_seperatingChar){
                $newArr['value']=self::messege_DataSlice($strLine,$newArr['value'],$i,value_seperatingChar);
            }
        }
        return $newArr;
    }

    //-------------------------------- Messege Func End ----------------------------//

    //--------------------------------- PageTagMap Func ----------------------------//

    private function DataRules($dataArr,$fileName,$pageData,$dataName){
        foreach($dataArr as $tagName=>$val)
        {
            if(strpos($dataName,"headers")!==false)
            {
                $pageData[$fileName][$dataName][$tagName]="Location:../".$val.".php";
            }
            else if(strpos($dataName,"include")!==false)
            {
                $pageData[$fileName][$dataName][$tagName]="../".$val.".php";
            }
            else if(strpos($dataName,"txt")!==false)
            {
                $pageData[$fileName][$dataName][$tagName]="../".$val.".txt";
            }
            else if(strpos($dataName,"rules")!==false)
            {
                if(strpos($dataName,"feedAlert")!==false)
                {
                    $pageData[$fileName][$dataName][$tagName]=dateTimeHandler::feedingDayParameterCalc($val);
                } 
            }
        }
        return $pageData;
    }

    private function rulesFile_preNpostTagAdd($pageData){
        foreach($pageData as $fileName=>$pageDataArr)
        {
            foreach($pageDataArr as $dataName=>$dataArr)
            {
                $pageData=$this->DataRules($dataArr,$fileName,$pageData,$dataName);
            }
        }
        return $pageData;
    }

    public function HeaderSplit($val,&$key)
    {
        $pageNamesSplit=explode(']',$val);	
        $key=substr($pageNamesSplit[0], strpos($pageNamesSplit[0],"[")+1,strlen($pageNamesSplit[0])-1);
        return $pageNamesSplit[1];
    }

    public function rulesFile_StrToArray($read){
        $firstSplit=explode(';',$read);
        foreach($firstSplit as $val)
        {
            if(strpos($val,'[')!==false)
            {
                $val=$this->HeaderSplit($val,$key);
            }
            if(strpos($val,'=')!==false)
            {
                $val=trim(preg_replace('/\s\s+/', '', $val));
                $pageNamesSplit=explode('=',$val);
                $pageDataSplit=explode(',',$pageNamesSplit[1]);
                if(strpos($pageDataSplit[0],'-')!==false)
                {
                    for($i=0;count($pageDataSplit)>$i;$i++)
                    {
                        $tmpArr=explode('-',$pageDataSplit[$i]);
                        $pageData[$key][$pageNamesSplit[0]][$tmpArr[0]]=$tmpArr[1];
                    }
                }
                else
                {
                    $pageData[$key][$pageNamesSplit[0]]=$pageDataSplit;
                }
            }
        }
        return isset($pageData)?self::rulesFile_preNpostTagAdd($pageData):false;
    }
    //--------------------------------- Rules Func Ends -----------------------------//
}

?>