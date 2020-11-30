<?php // Alexey Masyuk,Yulia Berkovich Aquarium Control System.
      // Prepare and returns Wanted SQL query.
class Query
{
    private function buildQuery( $querySelect,$tabelName,string $insertOrUpdateAct="",string $userName="" ) 
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
                ( `time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `temp` VARCHAR(5) NOT NULL ,
                `ph` VARCHAR(5) NOT NULL , `level` VARCHAR(5) NOT NULL , PRIMARY KEY (`time`)) ENGINE = InnoDB;";
			break;			
            case "update":
                $query =Query::updateSelect($insertOrUpdateAct,$userName,$tabelName);
            break;           
		    case "insert":		
                $query =Query::insertSelect($insertOrUpdateAct,$tabelName);
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
        $query=Query::buildQuery( $allOrWhere,$tabelName );
        return Query::prep($dbConn,$query);
    }

    public static function TableCreate($dbConn,$tabelName)
    {
        $query=Query::buildQuery( "create",$tabelName );
        return Query::prep($dbConn,$query);
    }

    private function insertSelect($insertAction,$tabelName)
	{
        $qrStart="INSERT INTO `$tabelName` ";
		switch($insertAction)
		{
		       case "user":
			      $qString=$qrStart."(`username`, `password`, `firstName`, `lastName`, `email`, `temp`, `ph`)
                    VALUES (?, ?, ?, ?, ?, '', '')";
				break;
			    case "sensorData":
				   $qString=$qrStart."(`temp`, `PH`, `level`) VALUES (?, ?, ?)";
				break;
		}
		return $qString;
    }

    public static function insert($dbConn,$tabelName,string $insertAct="user")
    {   
	    $query=Query::buildQuery( "insert",$tabelName,$insertAct );
		return Query::prep($dbConn,$query);      
    }
    
    private function updateSelect($updateAction,$userName,$tabelName)
	{
        $qrStart="UPDATE `$tabelName` SET ";
		switch($updateAction)
		{
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
		}
		return $qString;
	}

	public static function update($dbConn,$tabelName,$userName,string $updateAct="pass")
    {   
        $query=Query::buildQuery( "update", $tabelName, $updateAct, $userName );	
		return Query::prep($dbConn,$query);   
    }
}
?>