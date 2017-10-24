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

Class Attendance{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function getClassAttendace($class_id) {
		$result = $this->conn->query("SELECT `rollno`, `proxy` FROM `attendance` WHERE `class_id` = ". $class_id);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["rollno"]] = $rs["proxy"];		
		}
		return $data;
	}
	public function getCourseAttendace($course_id, $year) {
		$result = $this->conn->query("SELECT `class_id`, `rollno`, `proxy` FROM `attendance` WHERE `class_id` IN (SELECT `class_id` FROM `class` WHERE `course_faculty_year_id` IN (SELECT `course_faculty_year_id` FROM `teaches` WHERE `course_id`= ".$course_id. " AND `year` = ". $year."))");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		 	/*$data[$rs["class_id"]]["rollno"] = $rs["rollno"];		
			$data[$rs["class_id"]]["proxy"] = $rs["proxy"];*/
		 	$data[$rs["class_id"]][$rs["rollno"]] = $rs["proxy"];		
		}
		return $data;
	}
	public function getCourseComponentAttendace($course_faculty_year_id) {
		$result = $this->conn->query("SELECT `class_id`, `rollno`, `proxy` FROM `attendance` WHERE `class_id` IN
			(SELECT `class_id` FROM `class` WHERE `course_faculty_year_id` = ". $course_faculty_year_id.")");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		 	$data[$rs["class_id"]][$rs["rollno"]] = $rs["proxy"];		
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
	
	public function getStudentAttendace($rollno, $course_id) {
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
	}

	public function setAttendace($class_id, $rollno, $proxy) {
		
		$q="INSERT INTO `attendance`(`class_id`, `rollno`, `proxy`) VALUES (
			". nullHandler($class_id). ",
			". nullHandler($rollno). ",
			". nullHandler($proxy). "
		)";

		echo "<br>". $q ."<br>"; #debug
		
		$result = $this->conn->query( $q);
		if( $this->conn->affected_rows > 0 )
			$message = "New Record Added Successfully";
		else
			$message = "Failed Adding New Record";
		return $message;
	}

	public function updateAttendace($class_id, $rollno, $proxy) {
		
		$q="UPDATE `attendance` SET 
		". nullHandler($proxy, "proxy") ."
		WHERE `class_id` = ". $class_id. " AND `rollno` = ".$rollno;		
		echo "<br>". $q ."<br>";	#debug

		$result = $this->conn->query( $q);	
		if( $this->conn->affected_rows > 0 )
			$message = "Record Modified Successfully";
		else
			$message = "Failed Record Modification";
		return $message;
	}

	public function deleteAttendace($class_id, $rollno) {
		$result = $this->conn->query("DELETE FROM `attendance` WHERE `class_id`= ". $class_id." AND `rollno` = ". $rollno);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		return $message;			  		
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