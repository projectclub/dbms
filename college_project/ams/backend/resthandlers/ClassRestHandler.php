<?php
	require_once("SimpleRest.php");
	require_once('classes/Class.php');


class ClassRestHandler extends SimpleRest {

	protected $conn=null;

	use BasicEncoding;

	public function __construct()
	{
		include 'config.php'; //make the cofig file include
		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	

	}	

	public function __destruct() {
		$this->conn->close();
	}

	function getClasses(){
		$object = new TClass($this->conn);
		$rawData = $object->getClasses();
		return $this->restHandling($rawData);
	}

	function add(){
		$object = new TClass($this->conn);
		$rawData = $object->addClass();
		return $this->restHandlingNSQ($rawData);
	}

}

?>