<?php
require_once 'config.php'; //make the cofig file include
global $details;

function nullHandler($value, $atrib_name=null, $cat="") {
/*	return  ((empty($value) or !isset($value))? "null": 
				((is_string($value))? ("'".$value."'") : $value) ); */
	$ret;
	if (empty($value) or !isset($value))
		$ret = isset($atrib_name)? "": "null" ;
	else {
		$ret = isset($atrib_name)? $cat. "`". $atrib_name."` = ": " " ;
		if (is_string($value))
			$ret .=("'".$value."'");
		else 
			$ret .= $value ; 
	}
	return $ret;
}

trait BasicEncoding{

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

	public function restHandling($rawData){
		if(empty($rawData)){
			$statusCode = 404;
			$rawData = array('error'=>'No Result found');
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
	public function restHandlingNSQ($rawData){
		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);
		}
		else {
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
}

trait DBhelper {
	function executeQuery($conn, $q) {
		$result = $this->conn->query( $q);
		if(!$result) {
			//duplicate entry
			if($conn->errno == 1062) {
				return false;
			}
			else {
				trigger_error(mysqli_error($conn), E_USER_NOTICE);
			}
		}
		$affectedRows = mysqli_affected_rows($conn);
		return $affectedRows;
	}
}