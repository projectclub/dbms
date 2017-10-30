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

	//Course
	//Faculty
	//Timetable			
	//Class
	//Attendance
	//Student
	//404

	$view = "";
	if(isset($_GET["view"]))
	{
		$view = $_GET["view"];
		/*
		controls the RRESTful services
		URL mapping
		*/
		switch($view){
			//Course
			case 'CourseAll':
				// to handle Rest Url /asm/all
				$RestHandler = new CourseRestHandler();
				$RestHandler->getAllCourses();
				break;
			case 'CourseEnrollment':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new CourseRestHandler();
				$RestHandler->getCourseEnrollment();
				break;	
			case 'StudentCourseEnrollment':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new CourseRestHandler();
				$RestHandler->getStudentEnrollment();
				break;

			//Faculty
			case 'Faculty':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->getFaculties();
				break;	
			case 'FacultyCourse':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->getTeachingCourse();
				break;	

			//Timetable
			case 'FacultyTimetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->getFacultyTimetable();
				break;	
			case 'SemTimetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->getSemTimetable();
				break;
			case 'StudentTimetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->getStudentTimetable();
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

			//Student
			case 'Student':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new StudentRestHandler();
				$RestHandler->getStudents();
				break;	

			//404
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
			//Course
			case 'Course':
				// to handle Rest Url /asm/all
				$RestHandler = new CourseRestHandler();
				$RestHandler->add();
				break;
			case 'CourseCEnrollment':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new CourseRestHandler();
				$RestHandler->addCourseCEnrollment();
				break;	

			//Faculty
			case 'Faculty':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->add();
				break;	
			case 'FacultyCourse':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->addTeachingCourse();
				break;	

			//Timetable			
			case 'Timetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->add();
				break;	

			//Class
			case 'Class':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new ClassRestHandler();
				$RestHandler->add();
				break;

			//Attendance
			case 'Attendance':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new AttendanceRestHandler();
				$RestHandler->add();
				break;			

			//Student
			case 'Student':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new StudentRestHandler();
				$RestHandler->add();
				break;	

			//404
			case '':
				# 404 - not found;
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
			
			//Course
			case 'Course':
				// to handle Rest Url /asm/all
				$RestHandler = new CourseRestHandler();
				$RestHandler->edit();
				break;	

			//Faculty
			case 'Faculty':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->edit();
				break;	
			case 'FacultyCourse':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->editTeachingCourse();
				break;	

			/*//Timetable			
			case 'Timetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->edit();
				break;*/	

			//Class
			case 'Class':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new ClassRestHandler();
				$RestHandler->edit();
				break;

			//Attendance
			case 'Attendance':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new AttendanceRestHandler();
				$RestHandler->edit();
				break;			

			//Student
			case 'Student':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new StudentRestHandler();
				$RestHandler->edit();
				break;	

			//404
			case '':
				# 404 - not found;
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
	
			
			//Course
			case 'Course':
				// to handle Rest Url /asm/all
				$RestHandler = new CourseRestHandler();
				$RestHandler->delete();
				break;	
			case 'CourseCEnrollment':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new CourseRestHandler();
				$RestHandler->deleteCourseCEnrollment();
				break;

			//Faculty
			case 'Faculty':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->delete();
				break;	
			case 'FacultyCourse':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new FacultyRestHandler();
				$RestHandler->deleteTeachingCourse();
				break;	

			//Timetable			
			case 'Timetable':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new TimetableRestHandler();
				$RestHandler->delete();
				break;	

			//Class
			case 'Class':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new ClassRestHandler();
				$RestHandler->delete();
				break;

			//Attendance
			case 'Attendance':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new AttendanceRestHandler();
				$RestHandler->delete();
				break;			

			//Student
			case 'Student':
				//to handle Rest Url /asm/show<id>/
				$RestHandler = new StudentRestHandler();
				$RestHandler->delete();
				break;

			//404
			case '':
				# 404 - not found;
				break;
			default:
				# code...
				break;
		}
	}

?>