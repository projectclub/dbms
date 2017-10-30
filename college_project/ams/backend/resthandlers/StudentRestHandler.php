<?php
	require_once("SimpleRest.php");
	require_once('classes/Student.php');


class StudentRestHandler extends SimpleRest {

	protected $conn=null;

	use BasicEncoding;

	public function __construct()
	{
		include 'config.php'; //make the cofig file include
		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	

	}	

	public function __destruct()
	{
		$this->conn->close();
	}

	function getStudents(){
		$object = new Student($this->conn);
		$rawData = $object->getStudents();
		return $this->restHandling($rawData);
	}
	function add(){
		$object = new Student($this->conn);
		$rawData = $object->addStudent();
		return $this->restHandlingNSQ($rawData);
	}
	function edit(){
		$object = new Student($this->conn);
		$rawData = $object->updateStudent();
		return $this->restHandlingNSQ($rawData);
	}
	function delete(){
		$object = new Student($this->conn);
		$rawData = $object->deleteStudent();
		return $this->restHandlingNSQ($rawData);
	}	
}

?>