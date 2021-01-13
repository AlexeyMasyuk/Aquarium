<?php
    define("key_seperatingChar", "_");
    define("value_seperatingChar", "$");
    define("rulesEqual", "=");

class fileHandler{
//-------------------------------- Messege Func --------------------------------//

    private static function messegeDataSlice($str,$arr,&$i,$stopSign){
        $tmp="";
        $i++;
        for(;$str[$i]!=$stopSign;$i++){
            $tmp.=$str[$i];
        }		
        $i++;
        array_push($arr,$tmp);
        return $arr;
    }

    private static function stringToKeyAndValueArrays($strLine){
        $newArr=array('key'=>array(),'value'=>array());
        for($i=0;$i<strlen($strLine);$i++){
            if(key_seperatingChar==$strLine[$i]){
                $newArr['key']=fileHandler::messegeDataSlice($strLine,$newArr['key'],$i,key_seperatingChar);
            }
            if($strLine[$i]==value_seperatingChar){
                $newArr['value']=fileHandler::messegeDataSlice($strLine,$newArr['value'],$i,value_seperatingChar);
            }
        }
        return $newArr;
    }

    public static function messegePull($filePath){
        try{
            $strLine=file_get_contents($filePath);
    
            $newArr=fileHandler::stringTokeyAndValueArrays($strLine);
            
            $mssgArr=array();
            for($i=0;$i<count($newArr['key']);$i++){
                $mssgArr[$newArr['key'][$i]]=$newArr['value'][$i];
            }
            
            if(count($mssgArr)>0){
                return $mssgArr;
            }
            return false;
        }catch(Exeption $e){
            return false;
        }
    }

    //-------------------------------- Messege Func End ----------------------------//

    //----------------------------------- Rules Func -------------------------------//

    private static function NameDataSplit($newLine,&$split){
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
    
    private static function StrToArray($split){
        for($i=0;$i<count($split);$i++){
            if(strpos($split[$i],"[")!==false&&strpos($split[$i],"]")!==false){
                $newLine=explode(PHP_EOL,$split[$i]);
                if(($tmpSplit=fileHandler::NameDataSplit($newLine,$split[$i]))!==null){
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
        return $rulesArr;
    }
    
    public static function rulesPull(){
        try{
            $strLine=file_get_contents("inputRules.txt");
            $split=explode(";",$strLine);
            $rulesArr=fileHandler::StrToArray($split);
            if(count($rulesArr)>0){
                return $rulesArr;
            }
            return false;
        }catch(Exeption $e){
            return false;
        }
    }
    //--------------------------------- Rules Func Ends -----------------------------//
}

?>