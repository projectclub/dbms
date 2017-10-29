<?php
	require_once("SimpleRest.php");
	require_once('classes/Course.php');


class CourseRestHandler extends SimpleRest {

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

	function getAllCourses(){
		$object = new Course($this->conn);
		$rawData = $object->getCourses();

		return $this->restHandling($rawData);
	}

	function getFacultyCourses($faculty_id){
		$object = new Course($this->conn);
		$rawData = $object->getCourses($faculty_id);
		
		return $this->restHandling($rawData);
	}

	function getCourse($course_id){
/*		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
*/
		$object = new Course($this->conn);
		$rawData = $object->getCourse($course_id);
		
		return $this->restHandling($rawData);
	}
}

?>