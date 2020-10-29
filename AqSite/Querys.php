<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System

class Query
{
function buildQuery( $querySelect,$tabelName,string $insertAction="",string $userName="" ) 
{
    switch($querySelect)
    {
        case "select":
            $query = "SELECT * FROM `$tabelName`";			
            break;
			
		case "create":
		    $query = "CREATE TABLE `$tabelName`
                      ( `time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `temp` VARCHAR(5) NOT NULL ,
                         `ph` VARCHAR(5) NOT NULL , `level` VARCHAR(5) NOT NULL , PRIMARY KEY (`time`)) ENGINE = InnoDB;";
			break;
			
        case "update":
				   $qString="UPDATE `$tabelName` SET `temp`=`?` AND `PH`=`?` WHERE `username`=$userName";
				   break;
		case "insert":		
            $query =Query::insertSelect($insertAction,$tabelName);
    }
    return $query;
}
	
    public static function select($dbConn,$tabelName)
    {
        $query=Query::buildQuery( "select",$tabelName );
        return Query::prep($dbConn,$query);
    }

    private static function prep($dbConn, $qString)
    {
        $retQuery=$dbConn->prepare($qString);
        return $retQuery;
    }

    public static function TableCreate($dbConn,$tabelName)
    {
        $query=Query::buildQuery( "create",$tabelName );
        return Query::prep($dbConn,$query);
    }

    private function insertSelect($insertAction,$tabelName)
	{
		switch($insertAction)
		{
		       case "user":
			      $qString="INSERT INTO `$tabelName` (`username`, `password`, `firstName`, `lastName`, `email`, `temp`, `ph`)
                                         VALUES (?, ?, ?, ?, ?, '', '')";
				  break;
			    case "sensorData":
				   $qString="INSERT INTO `$tabelName` (`temp`, `PH`, `level`) VALUES (?, ?, ?)";
				   break;

		}
		return $qString;
	}

    public static function insert($dbConn,$tabelName,string $insertAct="user")
    {   
	        $query=Query::buildQuery( "insert",$tabelName,$insertAct );
			return Query::prep($dbConn,$query);      
    }
	
	public static function update($dbConn,$tabelName,$userName)
    {   
            $query=Query::buildQuery( "update",$tabelName,$userName );	
			return Query::prep($dbConn,$query);   
    }

}

?>