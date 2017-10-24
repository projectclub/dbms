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

Class TClass{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function getClasses() {
		$result = $this->conn->query("SELECT `class_id`, `course_faculty_year_id`, `date`, `start_time`, `end_time` FROM `class` ");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["class_id"]]["course_faculty_year_id"] = $rs["course_faculty_year_id"];		
		  $data[$rs["class_id"]]["date"] = $rs["date"];	
		  $data[$rs["class_id"]]["start_time"] = $rs["start_time"];	
		  $data[$rs["class_id"]]["end_time"] = $rs["end_time"];	
		}
		return $data;
	}

	public function getClass($class_id) {
		$result = $this->conn->query("SELECT `class_id`, `course_faculty_year_id`, `date`, `start_time`, `end_time` FROM `class` WHERE `class_id`=". $class_id);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["class_id"]]["course_faculty_year_id"] = $rs["course_faculty_year_id"];		
		  $data[$rs["class_id"]]["date"] = $rs["date"];	
		  $data[$rs["class_id"]]["start_time"] = $rs["start_time"];	
		  $data[$rs["class_id"]]["end_time"] = $rs["end_time"];	
		}
		return $data;
	}
	public function setClass( $course_faculty_year_id,  $date, $start_time, $end_time) {
		
		$q="INSERT INTO `class`(`course_faculty_year_id`, `date`, `start_time`, `end_time`) VALUES (
". nullHandler($course_faculty_year_id). ",
". nullHandler($date). ",
". nullHandler($start_time). ",
". nullHandler($end_time). "
		)";

		echo "<br>". $q ."<br>"; #debug
		
		$result = $this->conn->query( $q);
		$current_id = $this->conn->insert_id;
		if( !empty($current_id) )
			$message = "New Record Added Successfully";
		else
			$message = "Failed Adding New Record";
		return $message;
	}

	public function updateClass($class_id, $course_faculty_year_id,  $date, $start_time, $end_time) {
		
		$q="UPDATE `class` SET 
". nullHandler($course_faculty_year_id, "course_faculty_year_id"). "
". nullHandler($date, "date", ","). "
". nullHandler($start_time, "start_time", ","). "
". nullHandler($end_time, "end_time", ","). "
		WHERE `class_id` =". $class_id;
		
		echo "<br>". $q ."<br>";	#debug

		$result = $this->conn->query( $q);	
		if( $this->conn->affected_rows > 0 )
			$message = "Record Modified Successfully";
		else
			$message = "Failed Record Modification";
		return $message;
	}
/*DELETE FROM `enrollment` WHERE `course_faculty_year_id` =*/
	public function deleteClass($class_id) {
		$result = $this->conn->query("DELETE FROM `attendance` WHERE `class_id` = ". $class_id);
		$result = $this->conn->query("DELETE FROM `class` WHERE `class_id`= ". $class_id);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		return $message;			  		
	}
}

#Testing - debuging
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$object = new TClass($conn);
		var_dump( json_encode( $object->getClasses() ) );
		echo "<br>";
		var_dump( json_encode( $object->getClass(1)) );
		echo "<br>";
		echo $object->setClass(102, '2017-11-09', "07:00:00", "08:00:00");
				echo "<br>";
		echo $object->updateClass(4, 12 , '2016-11-09',"07:00:00", "08:00:00");
				echo "<br>";
		echo $object->deleteClass(8);


?>