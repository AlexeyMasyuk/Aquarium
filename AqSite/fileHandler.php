<?php
    define("key_seperatingChar", "_");
    define("value_seperatingChar", "$");

class fileHandler{
//--------------------------------Messege Func--------------------------------//

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

//--------------------------------Messege Func--------------------------------//


}


?>