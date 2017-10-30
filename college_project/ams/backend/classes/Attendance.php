<?php
require_once 'config.php'; //make the cofig file include
require_once 'utility.php';
global $details;

Class Attendance{

	protected $conn=null;
	use DBhelper;
	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function getAttendace() {
		$query="SELECT `rollno`, `proxy`, `class_id` FROM `attendance` ";
		if(isset($_GET['class_id']))	{
			$class_id=$_GET['class_id'];
			$query.=" WHERE `class_id` = ". $class_id;
		}		
		else if(isset($_GET['course_faculty_year_id']) ) {
			$course_faculty_year_id=$_GET['course_faculty_year_id'];
			$query.=" WHERE `class_id` IN
			(SELECT `class_id` FROM `class` WHERE `course_faculty_year_id` = ". $course_faculty_year_id.")";
		}	
		else if(isset($_GET['course_id']) && isset($_GET['year'])) {
			$course_id=$_GET['course_id'];
			$year=$_GET['year'];
			$query.=" WHERE `class_id` IN
			 (SELECT `class_id` FROM `class` WHERE `course_faculty_year_id` IN 
			 (SELECT `course_faculty_year_id` FROM `teaches` 
			 	WHERE `course_id`= ".$course_id. " AND `year` = ". $year."))";
		}


		$result = $this->conn->query($query);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $tmp=array();
		  $tmp["rollno"] = $rs["rollno"];
		  $tmp["proxy"] = $rs["proxy"];
		  $tmp["class_id"] = $rs["class_id"];
		  array_push($data,$tmp);		
		}
		return $data;
	}	

/*	public function getStudentAttendace($rollno) {
		$result = $this->conn->query("SELECT `class_id`, `proxy` FROM `attendance` WHERE `rollno` = ". $rollno);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["class_id"]] = $rs["proxy"];		
		}
		return $data;
	}*/
	
/*	public function getStudentAttendace($rollno, $course_id) {
		$result = $this->conn->query("SELECT `attendance`.`class_id`, `class`.`date`, `class`.`start_time`, `class`.`end_time`, `attendance`.`proxy`, `teaches`.`course_id`, `teaches`.`year`, `course_component`.`type` FROM `attendance` JOIN `class` ON `attendance`.`class_id`= `class`.`class_id` JOIN `teaches` ON `class`.`course_faculty_year_id` = `teaches`.`course_faculty_year_id` JOIN `course_component` ON `course_component`.`course_faculty_year_id` = `class`.`course_faculty_year_id` WHERE `rollno` = ". $rollno. " AND `teaches`.`course_id` = ". $course_id ) ;
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["class_id"]]["proxy"] = $rs["proxy"];		
  		  $data[$rs["class_id"]]["date"] = $rs["date"];
  		  $data[$rs["class_id"]]["start_time"] = $rs["start_time"];
  		  $data[$rs["class_id"]]["end_time"] = $rs["end_time"];
		  $data[$rs["class_id"]]["type"] = $rs["type"];
		}
		return $data;
	}
	public function getStudentAttendaceAll($rollno) {
		$result = $this->conn->query("SELECT `attendance`.`class_id`, `class`.`date`, `class`.`start_time`, `class`.`end_time`, `attendance`.`proxy`, `teaches`.`course_id`, `teaches`.`year`, `course_component`.`type` FROM `attendance` JOIN `class` ON `attendance`.`class_id`= `class`.`class_id` JOIN `teaches` ON `class`.`course_faculty_year_id` = `teaches`.`course_faculty_year_id` JOIN `course_component` ON `course_component`.`course_faculty_year_id` = `class`.`course_faculty_year_id` WHERE `rollno` = ". $rollno);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["course_id"]][$rs["year"]]["class_id"]["proxy"] = $rs["proxy"];		
  		  $data[$rs["course_id"]][$rs["year"]]["class_id"]["date"] = $rs["date"];
  		  $data[$rs["course_id"]][$rs["year"]]["class_id"]["start_time"] = $rs["start_time"];
  		  $data[$rs["course_id"]][$rs["year"]]["class_id"]["end_time"] = $rs["end_time"];
  		  $data[$rs["course_id"]][$rs["year"]]["class_id"]["type"] = $rs["type"];
		}
		return $data;
	}*/

	public function addAttendace() {
		if(isset($_POST['class_id']) && isset($_POST['rollno']) && isset($_POST['proxy']) ) {

			$class_id = $_POST['class_id'];
			$rollno =   $_POST['rollno'];
			$proxy =  $_POST['proxy'];

			$query="INSERT INTO `attendance` (`class_id`, `rollno`, `proxy`) VALUES (
			". $class_id .", ". $rollno .", '". $proxy ."' )";

		// echo "<br>". $q ."<br>"; #debug	
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
	}

	public function updateAttendace() {
		if(isset($_POST['class_id']) && isset($_POST['rollno']) && isset($_POST['proxy'])) {
			$class_id=$_POST['class_id'];
			$rollno=$_POST['rollno'];
			$proxy=$_POST['proxy'];
			$query="UPDATE `attendance` SET `proxy` = '". $proxy .
		"' WHERE `class_id` = ". $class_id. " AND `rollno` = ".$rollno;
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}	
	}

	public function deleteAttendace() {
		if(isset($_POST['class_id']) && isset($_POST['rollno']) ) {
			$class_id=$_POST['class_id'];
			$rollno=$_POST['rollno'];

			$query="DELETE FROM `attendance` WHERE `class_id`= ". $class_id." AND `rollno` = ". $rollno;
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}		
	}

}

#Testing - debuging
/*		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$object = new Attendance($conn);
		var_dump( json_encode( $object->getClassAttendace(1) ) );
		echo "<br>";
		var_dump( json_encode( $object->getCourseAttendace(101,"2017")) );
		echo "<br>";
		var_dump( json_encode( $object->getCourseComponentAttendace(1)) );
		echo "<br>";
		var_dump( json_encode( $object->getStudentAttendace(111051, 101)) );
		echo "<br>";
		var_dump( json_encode( $object->getStudentAttendaceAll(111051)) );
		echo "<br>";
		echo $object->deleteAttendace(1, 111051);
		echo $object->setAttendace(1, 111051, "P");
		echo $object->updateAttendace(1, 111051, "A");*/

?>