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

    private function tagMap_innerSplit($arr,$tagsArr,$key1,$key3){
        for($i=0;count($tagsArr[$key1][$key3])>$i;$i++){
            if(strpos($key3,"headers")!==false){					
                $tmpArr=explode('-',$tagsArr[$key1][$key3][$i]);
                $arr[$tmpArr[0]]="Location:".$tmpArr[1].".php";
            }
            else if(strpos($key3,"include")!==false){
                $tagsArr[$key1][$key3][$i].=".php";
            }
            else if(strpos($key3,"txt")!==false){
                $tmpArr=explode('-',$tagsArr[$key1][$key3][$i]);
                $arr[$tmpArr[0]]=$tmpArr[1].".txt";
            }
            else if(strpos($key3,"tagsNstrings")!==false){
                $tmpArr=explode('-',$tagsArr[$key1][$key3][$i]);
                $arr[$tmpArr[0]]=$tmpArr[1];
            }
        }
        return $arr;
    }

    private function tagMap_dataSplir($tagsArr){
		$newArr=array();
        foreach($tagsArr as $key1=>$key2){
            foreach($key2 as $key3=>$val){
                $tagsArr[$key1][$key3]=explode(',',$val);
                for($i=0;count($tagsArr[$key1][$key3])>$i;$i++){
                    if(strpos($key3,"headers")!==false){					
                        $tmpArr=explode('-',$tagsArr[$key1][$key3][$i]);
                        $arr[$tmpArr[0]]="Location:".$tmpArr[1].".php";
                    }
                    else if(strpos($key3,"include")!==false){
                        $tagsArr[$key1][$key3][$i].=".php";
                    }
                    else if(strpos($key3,"txt")!==false){
                        $tmpArr=explode('-',$tagsArr[$key1][$key3][$i]);
                        $arr[$tmpArr[0]]=$tmpArr[1].".txt";
                    }
                    else if(strpos($key3,"tagsNstrings")!==false){
                        
                        $tmpArr=explode('-',$tagsArr[$key1][$key3][$i]);
                        $tmpArr[0] = trim(preg_replace('/\s\s+/', ' ', $tmpArr[0]));
                        $arr[$tmpArr[0]]=$tmpArr[1];
                    }
				}
				if(isset($arr)){
					$tagsArr[$key1][$key3]=$arr;
					unset($arr);	
				}
			}
        }
        return $tagsArr;
    }

    private function rulesFile_NamesFromDataSplit($newLine,&$split){
		
        foreach($newLine as $val){
			if(strpos($val,'/')!==false){
				$val=substr($val,0,strpos('/',$val)-1);
			}
            if(strpos($val,"[")!==false){
                $key=substr($val, strpos($val,"[")+1, strpos($val,"]")-1); 
            }
            else if(strpos($val,"=")!==false){
                $split=$val;
            }
        }

        return $key;
    }
    
    public function rulesFile_StrToArray($split,$rulesPull){
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
        if($rulesPull){
            $rulesArr['defaultAlarms']['feedAlert']=dateTimeHandler::feedingDayParameterCalc($rulesArr['defaultAlarms']['feedAlert']);
        }
        else{
            $rulesArr=self::tagMap_dataSplir($rulesArr);
        }
        return $rulesArr;
    }
    //--------------------------------- Rules Func Ends -----------------------------//
}

?>