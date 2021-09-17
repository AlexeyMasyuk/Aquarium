<?php // Alexey Masyuk,Yulia Berkovich Aquarium Control System.
      // Prepare and returns Wanted SQL query.
class Query
{
    private static function buildQuery( $querySelect,$tabelName,string $insertOrUpdateAct="",string $userName="" ) 
    {
        switch($querySelect)
        {
            case "select":
                $query = "SELECT * FROM `$tabelName`";			
            break;            
            case "selectWhere":
                $query = "SELECT * FROM `$tabelName` WHERE `username`=?";			
            break;			
		    case "create":
		        $query = "CREATE TABLE `$tabelName`
                ( `time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `Temp` VARCHAR(5) NOT NULL ,
                `ph` VARCHAR(5) NOT NULL , `level` VARCHAR(5) NOT NULL , PRIMARY KEY (`time`)) ENGINE = InnoDB;";
			break;			
            case "update":
                $query =self::updateSelect($insertOrUpdateAct,$userName,$tabelName);
            break;           
		    case "insert":		
                $query =self::insertSelect($insertOrUpdateAct,$tabelName);
            break;
        }
        return $query;
    }

    private static function prep($dbConn, $qString)
    {
        $retQuery=$dbConn->prepare($qString);
        return $retQuery;
    }
	
    public static function select($dbConn,$tabelName,$allOrWhere="selectWhere")
    {
        $query=self::buildQuery( $allOrWhere,$tabelName );
        return self::prep($dbConn,$query);
    }

    public static function TableCreate($dbConn,$tabelName)
    {
        $query=self::buildQuery( "create",$tabelName );
        return self::prep($dbConn,$query);
    }

    private static function insertSelect($insertAction,$tabelName)
	{
        $qrStart="INSERT INTO `$tabelName` ";
		switch($insertAction)
		{
		       case "user":
			      $qString=$qrStart."(`username`, `password`, `firstName`, `lastName`, `email`)
                    VALUES (?, ?, ?, ?, ?)";
				break;
			    case "sensorData":
				   $qString=$qrStart."(`Temp`, `ph`, `level`) VALUES (?, ?, ?)";
				break;
		}
		return $qString;
    }

    public static function insert($dbConn,$tabelName,string $insertAct="user")
    {   
	    $query=self::buildQuery( "insert",$tabelName,$insertAct );
		return self::prep($dbConn,$query);      
    }
    
    private static function updateSelect($updateAction,$userName,$tabelName)
	{
        $qrStart="UPDATE `$tabelName` SET ";
		switch($updateAction)
		{
            case "pullCycle":
                $qString=$qrStart."`pullingCycle`=? WHERE `username`='$userName'";
            break;
		    case "phHigh":
                $qString=$qrStart."`phHigh`=? WHERE `username`='$userName'";
            break;
		    case "phLow":
                $qString=$qrStart."`phLow`=? WHERE `username`='$userName'";
            break;
            case "tempHigh":
                $qString=$qrStart."`tempHigh`=? WHERE `username`='$userName'";
			break;
            case "tempLow":
                $qString=$qrStart."`tempLow`=? WHERE `username`='$userName'";
			break;
			case "pass":
               $qString=$qrStart."`password`=? WHERE `username`='$userName'";
            break;
            case "email":
                $qString=$qrStart."`email`=? WHERE `username`='$userName'";
            break;
            case "fname":
                $qString=$qrStart."`firstName`=? WHERE `username`='$userName'";
            break;
            case "lname":
                $qString=$qrStart."`lastName`=? WHERE `username`='$userName'";
            break;
            case "feedAlert":
                $qString=$qrStart."`feedAlert`=? WHERE `username`='$userName'";
            break;
            case "feedAlertOFF":
                $qString=$qrStart."`feedAlert`=`feedAlert`+' '+? WHERE `username`='$userName'";
            break;
		}
		return $qString;
	}

	public static function update($dbConn,$tabelName,$userName,string $updateAct="pass")
    {   
        $query=self::buildQuery( "update", $tabelName, $updateAct, $userName );	
		return self::prep($dbConn,$query);   
    }
}
?>