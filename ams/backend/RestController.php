<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once("CourseRestHandler.php");
require_once("authenticator.php");

$auth_U = "";
$auth_P = "";
$auth_a = "";
if(isset($_GET["user"]))
	{
		$auth_U = $_GET["user"];
		$auth_P = $_GET["pass"];
		$authRestHandler = new AuthRestHandler();
		$authRestHandler->authenticate($auth_U, $auth_P);
	}
else {
	# Logout 
}



$view = "";
if(isset($_GET["view"]))
	$view = $_GET["view"];
/*
controls the RRESTful services
URL mapping
*/
switch($view){
	case 'CourseAll':
		// to handle Rest Url /asm/all
		$courseRestHandler = new CourseRestHandler();
		$courseRestHandler->getAllCourses();
		break;
	case 'CourseSingle':
		//to handle Rest Url /asm/show<id>/
		$courseRestHandler = new CourseRestHandler();
		$courseRestHandler->getCourse($_GET["course_id"]);
		break;
	case 'FacultyCourse':
		//to handle Rest Url /asm/show<id>/
		$courseRestHandler = new CourseRestHandler();
		$courseRestHandler->getFacultyCourses($_GET["id"]);
		break;	
	case '':
		# 404 - not found;
		break;

}

?>