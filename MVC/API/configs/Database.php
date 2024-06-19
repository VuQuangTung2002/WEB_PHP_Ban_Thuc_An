<?php

class db{
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $db = "project_mvc";

	public function connect(){
		$this->conn = null;
		try {
  		$this->conn = new PDO("mysql:host=localhost; dbname=project_mvc", "root", "");
  		// set the PDO error mode to exception
  		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  		echo "Connect successful!";
		} catch(PDOException $e) {
  		echo "Connect failed! " . $e->getMessage();
		}
		return $this->conn;
	}
	
}

?>