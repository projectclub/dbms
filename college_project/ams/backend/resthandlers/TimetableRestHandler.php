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

	function getFacultyTimetable($faculty_id){
		$object = new Timetable($this->conn);
		$rawData = $object->getFacultyTimetable($faculty_id);

		return $this->restHandling($rawData);
	}

	function getSemTimetable($semester, $year){
		$object = new Timetable($this->conn);
		$rawData = $object->getSemTimetable($semester, $year);
	
		return $this->restHandling($rawData);
	}

	function getStudentTimetable($rollno, $year){
/*		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
*/
		$object = new Timetable($this->conn);
		$rawData = $object->getStudentTimetable($rollno, $year);
		
		return $this->restHandling($rawData);
	}

}

?>