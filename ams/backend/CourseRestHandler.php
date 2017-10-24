<?php
	require_once("SimpleRest.php");
	require_once('Course.php');


class CourseRestHandler extends SimpleRest{

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

	function getAllCourses(){
		$course = new Course($this->conn);
		$rawData = $course->getCourses();

		if(empty($rawData)){
			$statusCode = 404;
			$rawData = array('error'=>'No Course found');
		}else {
			$statusCode = 200;
		}
		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeader($requestContentType, $statusCode);

		if(strpos($requestContentType, 'application/json') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if(strpos($requestContentType, 'text/html') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if(strpos($requestContentType, 'application/xml') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		}
	}

	function getFacultyCourses(){
		$course = new Course($this->conn);
		$rawData = $course->getCourses();

		if(empty($rawData)){
			$statusCode = 404;
			$rawData = array('error'=>'No Course found');
		}else {
			$statusCode = 200;
		}
		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeader($requestContentType, $statusCode);

		if(strpos($requestContentType, 'application/json') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if(strpos($requestContentType, 'text/html') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if(strpos($requestContentType, 'application/xml') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		}
	}

	function getCourse($course_id){
/*		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
*/
		$course = new Course($this->conn);
		$rawData = $course->getCourse($course_id);

		if(empty($rawData)){
			$statusCode = 404;
			$rawData = array('error'=>'No Course found');
		}else {
			$statusCode = 200;
		}
		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeader($requestContentType, $statusCode);

		if(strpos($requestContentType, 'application/json') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if(strpos($requestContentType, 'text/html') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if(strpos($requestContentType, 'application/xml') !== false){
			$response = $this->encodeJson($rawData);
			echo $response;
		}
	}

	public function encodeHtml($responseData) {
		$htmlResponse = "<table border='1'>";
		foreach($responseData as $key=>$value) {
			$htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
		}
		$htmlResponse .= "</table>";
		return $htmlResponse;
	}

	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;
	}

	public function encodeXml($responseData) {
		// create object of SimpleXMLElement
		$xml = new SimpleXMLElement('<?xml version="1.0"?><mobile></mobile>');
		foreach($responseData as $key=>$value) {
			$xml->addChild($key, $value);
		}
		return $xml->asXML();
	}

}

?>