<?php
	require_once("SimpleRest.php");
	require_once('classes/Attendance.php');


class AttendanceRestHandler extends SimpleRest {

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

	function getAttendace(){
		$object = new Attendance($this->conn);
		$rawData = $object->getAttendace();
		return $this->restHandling($rawData);
	}

	function add(){
		$object = new Attendance($this->conn);
		$rawData = $object->addAttendace();
		return $this->restHandlingNSQ($rawData);
	}
	
	function edit(){
		$object = new Attendance($this->conn);
		$rawData = $object->updateAttendace();
		return $this->restHandlingNSQ($rawData);
	}
	function delete(){
		$object = new Attendance($this->conn);
		$rawData = $object->deleteAttendace();
		return $this->restHandlingNSQ($rawData);
	}

}

?>