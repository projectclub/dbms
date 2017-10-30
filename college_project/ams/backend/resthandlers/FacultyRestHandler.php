<?php
	require_once("SimpleRest.php");
	require_once('classes/Faculty.php');


class FacultyRestHandler extends SimpleRest{

	use BasicEncoding;
	protected $conn=null;
	public function __construct()
	{
		include 'config.php'; //make the cofig file include
		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	

	}	

	public function __destruct()
	{
		$this->conn->close();
	}

	function getFaculties(){
		$object = new Faculty($this->conn);
		$rawData = $object->getFaculties();

		return $this->restHandling($rawData);
	}
	function add(){
		$object = new Faculty($this->conn);
		$rawData = $object->addFaculty();
		return $this->restHandlingNSQ($rawData);
	}
	function edit(){
		$object = new Faculty($this->conn);
		$rawData = $object->updateFaculty();
		return $this->restHandlingNSQ($rawData);
	}
	function delete(){
		$object = new Faculty($this->conn);
		$rawData = $object->deleteFaculty();
		return $this->restHandlingNSQ($rawData);
	}

	function getTeachingCourse(){
		$object = new Faculty($this->conn);
		$rawData = $object->getTeachingCourse();
		
		return $this->restHandling($rawData);
	}
	function addTeachingCourse(){
		$object = new Faculty($this->conn);
		$rawData = $object->addTeachingCourse();
		return $this->restHandlingNSQ($rawData);
	}
	function editTeachingCourse(){
		$object = new Faculty($this->conn);
		$rawData = $object->updateTeachingCourse();
		return $this->restHandlingNSQ($rawData);
	}
	function deleteTeachingCourse(){
		$object = new Faculty($this->conn);
		$rawData = $object->deleteTeachingCourse();
		return $this->restHandlingNSQ($rawData);
	}

}

?>