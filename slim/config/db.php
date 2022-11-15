<?php
	class db{
		// Properties
		private $dbhost = "wappprojects.de/mysqladmin/PMA5/"; //dev.wappprojects.de
		private $dbuser = "d03b050b";
		private $dbpass = "20i-dev-#db";
		private $dbname = "d03b050b";

		// Connect to DB
		public function connect(){
			$mysql_conn_string = "mysql:host=$this->dbhost;dbname=$this->dbname";
			$dbConnection = new PDO($mysql_conn_string, $this->dbuser, $this->dbpass);
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbConnection;
		}
	}
