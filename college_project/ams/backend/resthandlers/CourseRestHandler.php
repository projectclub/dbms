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
	function add(){
		$object = new Course($this->conn);
		$rawData = $object->addCourse();
		return $this->restHandlingNSQ($rawData);
	}
	function edit(){
		$object = new Course($this->conn);
		$rawData = $object->updateCourse();
		return $this->restHandlingNSQ($rawData);
	}
	function delete(){
		$object = new Course($this->conn);
		$rawData = $object->deleteCourse();
		return $this->restHandlingNSQ($rawData);
	}	

	function getCourseEnrollment(){
		$object = new Course($this->conn);
		$rawData = $object->getCourseEnrollment();
		return $this->restHandling($rawData);
	}
	function getStudentEnrollment(){
		$object = new Course($this->conn);
		$rawData = $object->getStudentEnrollment();
		return $this->restHandling($rawData);
	}
	function addCourseCEnrollment(){
		$object = new Course($this->conn);
		$rawData = $object->addCourseCEnrollment();
		return $this->restHandlingNSQ($rawData);
	}
	function deleteCourseCEnrollment(){
		$object = new Course($this->conn);
		$rawData = $object->deleteCourseCEnrollment();
		return $this->restHandlingNSQ($rawData);
	}	
	
}

?>