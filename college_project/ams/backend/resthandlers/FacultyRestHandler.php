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
	function getFaculty($faculty_id){
		$object = new Faculty($this->conn);
		$rawData = $object->getFaculty($faculty_id);

		return $this->restHandling($rawData);
	}
	function getTeachingCourse($faculty_id, $year){
		$object = new Faculty($this->conn);
		$rawData = $object->getTeachingCourse($faculty_id, $year);
		
		return $this->restHandling($rawData);
	}
	function getCourseEnrollment($course_faculty_year_id){
		$object = new Faculty($this->conn);
		$rawData = $object->getCourseEnrollment($course_faculty_year_id);

		return $this->restHandling($rawData);
	}

}

?>