<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require_once("utility.php");
require_once("resthandlers/authenticator.php");
require_once("resthandlers/CourseRestHandler.php");
require_once("resthandlers/FacultyRestHandler.php");
require_once("resthandlers/TimetableRestHandler.php");
require_once("resthandlers/ClassRestHandler.php");
require_once("resthandlers/AttendanceRestHandler.php");

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
	{
		$view = $_GET["view"];
		/*
		controls the RRESTful services
		URL mapping
		*/
		switch($view){
			case 'CourseAll':
				// to handle Rest Url /asm/all
				$RestHandler = new CourseRestHandler();
				$RestHandler->getAllCourses();
				break;
			case 'CourseSingle':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new CourseRestHandler();
				$RestHandler->getCourse($_GET["course_id"]);
				break;
			
			//Faculty
			case 'FacultyCourse':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->getTeachingCourse($_GET["faculty_id"], $_GET["year"]);
				break;	
			case 'FacultyCourseEnrollment':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->getCourseEnrollment($_GET["course_faculty_year_id"]);
				break;	
			case 'Faculty':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->getFaculty($_GET["faculty_id"]);
				break;	

			//Timetable
			case 'FacultyTimetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->getFacultyTimetable($_GET["faculty_id"]);
				break;	
			case 'SemTimetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->getSemTimetable($_GET["semester"], $_GET["year"]);
				break;
			case 'StudentTimetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->getStudentTimetable($_GET["rollno"], $_GET["year"]);
				break;	

			//Class
			case 'Classes':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new ClassRestHandler();
				$RestHandler->getClasses();
				break;	

			//Attendance
			case 'Attendance':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new AttendanceRestHandler();
				$RestHandler->getAttendace();
				break;	
			case '':
				# 404 - not found;
				break;
		}
	}

	$create = "";
	if(isset($_GET["create"]))
	{
		$create = $_GET["create"];
		switch ($create) {
			case 'Class':
				# code...
				$RestHandler = new ClassRestHandler();
				$RestHandler->add();
				break;
			case 'Attendance':
				# code...
				$RestHandler = new AttendanceRestHandler();
				$RestHandler->add();
				break;			
			default:
				# code...
				break;
		}
	}

	$update = "";
	if(isset($_GET["update"]))
	{
		$update = $_GET["update"];
		switch ($update) {
			case 'Attendance':
				# code...
				$RestHandler = new AttendanceRestHandler();
				$RestHandler->edit();
				break;	
			
			default:
				# code...
				break;
		}
	}

	$delete = "";
	if(isset($_GET["delete"]))
	{
		$delete = $_GET["delete"];
		switch ($delete) {
			case 'Attendance':
				# code...
				$RestHandler = new AttendanceRestHandler();
				$RestHandler->delete();
				break;	
			
			default:
				# code...
				break;
		}
	}

?>