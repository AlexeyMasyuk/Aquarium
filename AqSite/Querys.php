<?php //Alexey Masyuk,Yulia Berkovich Aquarium Control System

class Query
{
function buildQuery( $querySelect,$tabelName,string $insertOrUpdateAct="",string $userName="" ) 
{
    switch($querySelect)
    {
        case "select":
            $query = "SELECT * FROM `$tabelName`";			
            break;
        case "selectWhere":
            $query = "SELECT * FROM `$tabelName` WHERE `username`='?'";			
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
    }
    return $query;
}
	
    public static function select($dbConn,$tabelName)
    {
        $query=Query::buildQuery( "select",$tabelName );
        return Query::prep($dbConn,$query);
    }

    public static function selectWhere($dbConn,$tabelName)
    {
        $query=Query::buildQuery( "selectWhere",$tabelName );
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

    private function updateSelect($updateAction,$userName,$tabelName)
	{
        $qrStart="UPDATE `$tabelName` SET ";
		switch($updateAction)
		{
		       case "tempAndPH":
                  $qString=$qrStart."`temp`=`?` AND PH=? WHERE `username`='$userName'";
				  break;
			    case "pass":
                   $qString=$qrStart."`password`=? WHERE `username`='$userName'";
                   break;
                case "email":
                    $qString=$qrStart."`email`=? WHERE `username`='$userName'";
                    break;
		}
		return $qString;
	}

    public static function insert($dbConn,$tabelName,string $insertAct="user")
    {   
	        $query=Query::buildQuery( "insert",$tabelName,$insertAct );
			return Query::prep($dbConn,$query);      
    }
	
	public static function update($dbConn,$tabelName,$userName,string $updateAct="pass")
    {   
            $query=Query::buildQuery( "update", $tabelName, $updateAct, $userName );	
			return Query::prep($dbConn,$query);   
    }

}

?>