<?php
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

    //----------------------------------- Rules Func -------------------------------//

    private function rulesFile_NamesFromDataSplit($newLine,&$split){
        foreach($newLine as $val){
            if(strpos($val,"[")!==false){
                $tmp=substr($val, 0, -1);  // returns "abcde"
                $key=substr($tmp, 1);
            }
            else if(strpos($val,"=")!==false){
                $split=$val;
            }
        }

        return $key;
    }
    
    public function rulesFile_StrToArray($split){
        for($i=0;$i<count($split);$i++){
            if(strpos($split[$i],"[")!==false&&strpos($split[$i],"]")!==false){
                $newLine=explode(PHP_EOL,$split[$i]);
                if(($tmpSplit=self::rulesFile_NamesFromDataSplit($newLine,$split[$i]))!==null){
                    $key=$tmpSplit;
                }
            }else{
                $split[$i] = trim(preg_replace('/\s\s+/', ' ', $split[$i]));
            }
            $newLine=explode("=",$split[$i]);
            if(isset($newLine[0])&&isset($newLine[1])){
                $rulesArr[$key][$newLine[0]]=$newLine[1];
            }
        }
        $rulesArr['defaultAlarms']['feedAlert']=dateTimeHandler::feedingDayParameterCalc($rulesArr['defaultAlarms']['feedAlert']);
        return $rulesArr;
    }
    //--------------------------------- Rules Func Ends -----------------------------//
}

?>