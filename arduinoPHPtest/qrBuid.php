<?php
class dbClassT
{
		private $stm;
		
		public function __construct($data,$sql)
		{
			
			$stm = ($sql->connection)->prepare("SELECT * FROM :table");
			$stm->bindParam(':table', $data, PDO::PARAM_STR, 12);
		}
		
		public function getStm(){
			return $stm;
		}
}
?>