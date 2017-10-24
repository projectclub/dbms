<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include 'config.php';//make the cofig file include
global $details;//make the connection vars global

if($_GET['method'] == "load_news")
{
	$conn = new mysqli($details['server_host'], $details['mysql_name'],$details['mysql_password'], $details['mysql_database']);	
	$result = $conn->query("SELECT `course_id`,`title` FROM `course`");
	$data=array();
	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	  $data[$rs["course_id"]] = $rs["title"];		
	}


	$conn->close();
	return $data;
}
?>