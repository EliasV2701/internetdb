<?php
	class db{
		// Properties
		private $dbhost = "dev.wappprojects.de";
		private $dbuser = "d0xxx";
		private $dbpass = "yyy";
		private $dbname = "d0xxx";

		// Connect to DB
		public function connect(){
			$mysql_conn_string = "mysql:host=$this->dbhost;dbname=$this->dbname";
			$dbConnection = new PDO($mysql_conn_string, $this->dbuser, $this->dbpass);
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbConnection;
		}
	}
