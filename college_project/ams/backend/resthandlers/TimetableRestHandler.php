<?php
	require_once("SimpleRest.php");
	require_once('classes/Timetable.php');


class TimetableRestHandler extends SimpleRest{
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

	function getFacultyTimetable(){
		$object = new Timetable($this->conn);
		$rawData = $object->getFacultyTimetable();

		return $this->restHandling($rawData);
	}

	function getSemTimetable(){
		$object = new Timetable($this->conn);
		$rawData = $object->getSemTimetable();
		return $this->restHandling($rawData);
	}

	function getStudentTimetable(){
		$object = new Timetable($this->conn);
		$rawData = $object->getStudentTimetable();
		
		return $this->restHandling($rawData);
	}
	function add(){
		$object = new Timetable($this->conn);
		$rawData = $object->addTimetable();
		return $this->restHandlingNSQ($rawData);
	}

	function delete(){
		$object = new Timetable($this->conn);
		$rawData = $object->deleteTimetable();
		return $this->restHandlingNSQ($rawData);
	}
}

?>