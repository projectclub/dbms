
<?php
require_once 'config.php'; //make the cofig file include
require_once 'utility.php';
Class Timetable{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function getFacultyTimetable($faculty_id) {
		$result = $this->conn->query("SELECT `timetable`.`course_faculty_year_id`, `day`, `start_time`, `end_time`, `teaches`.`course_id`, `teaches`.`year`,`course_component`.`type` FROM `timetable` JOIN `teaches` ON `timetable`.`course_faculty_year_id` =`teaches`.`course_faculty_year_id` JOIN `course_component` ON `timetable`.`course_faculty_year_id` =`course_component`.`course_faculty_year_id` WHERE `teaches`.`faculty_id`=". $faculty_id);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $tmp = array();
		  $tmp["course_faculty_year_id"] = $rs["course_faculty_year_id"];		
		  $tmp["day"] = $rs["day"];	
		  $tmp["start_time"] = strtotime($rs["start_time"])*1000;	
		  $tmp["end_time"] = strtotime($rs["end_time"])*1000;	
		  $tmp["year"] = $rs["year"];	
		  $tmp["type"] = $rs["type"];

		  array_push($data,$tmp);
		}
		return $data;
	}

	public function getSemTimetable($semester, $year) {
		$result = $this->conn->query("SELECT `timetable`.`course_faculty_year_id`, `day`, `start_time`, `end_time`, `teaches`.`course_id`, `teaches`.`year`,`course_component`.`type`, `course`.`title`, `faculty`.`faculty_id`,`faculty`.`faculty_name`  FROM `timetable` JOIN `teaches` ON `timetable`.`course_faculty_year_id` =`teaches`.`course_faculty_year_id` JOIN `course_component`  ON `timetable`.`course_faculty_year_id` =`course_component`.`course_faculty_year_id` JOIN `course` ON `teaches`.`course_id` = `course`.`course_id` JOIN `faculty` ON `faculty`.`faculty_id` = `teaches`.`faculty_id` WHERE `course`.`semester` = ". $semester. " AND `teaches`.`year` = ". $year);

		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $tmp = array();
		  $tmp["course_faculty_year_id"] = $rs["course_faculty_year_id"];		
		  $tmp["day"] = $rs["day"];	
		  $tmp["start_time"] = strtotime($rs["start_time"])*1000;	
		  $tmp["end_time"] = strtotime($rs["end_time"])*1000;	
		  $tmp["year"] = $rs["year"];	
		  $tmp["type"] = $rs["type"];
		  $tmp["title"] = $rs["title"];
		  array_push($data,$tmp);
		}
		return $data;
	}
	public function getStudentTimetable($rollno, $year) {
		$result = $this->conn->query("SELECT `timetable`.`course_faculty_year_id`, `day`, `start_time`, `end_time`, `teaches`.`course_id`, `teaches`.`year`, `course_component`.`type`, `course`.`title`, `course`.`semester`, `faculty`.`faculty_id`, `faculty`.`faculty_name`  FROM `timetable` JOIN `teaches` ON `timetable`.`course_faculty_year_id` = `teaches`.`course_faculty_year_id` JOIN `course_component`  ON `timetable`.`course_faculty_year_id` =`course_component`.`course_faculty_year_id` JOIN `course` ON `teaches`.`course_id` = `course`.`course_id` JOIN `faculty` ON `faculty`.`faculty_id` = `teaches`.`faculty_id` WHERE `timetable`.`course_faculty_year_id` IN (SELECT `course_faculty_year_id` FROM `enrollment` WHERE `rollno` = ". $rollno." AND `year` = ". $year ." )");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $tmp = array();
		  $tmp["course_faculty_year_id"] = $rs["course_faculty_year_id"];		
		  $tmp["day"] = $rs["day"];	
		  $tmp["start_time"] = $rs["start_time"];	
		  $tmp["end_time"] = $rs["end_time"];	
		  $tmp["year"] = $rs["year"];	
		  $tmp["type"] = $rs["type"];
		  $tmp["title"] = $rs["title"];
		  $tmp["semester"] = $rs["semester"];
		  array_push($data,$tmp);
		}
		return $data;
	}

	public function setTimetable( $course_faculty_year_id,  $date, $start_time, $end_time) {
		
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

	public function updateTimetable($class_id, $course_faculty_year_id,  $date, $start_time, $end_time) {
		
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

	public function deleteTimetable($class_id) {
		$result = $this->conn->query("DELETE FROM `class` WHERE `class_id`= ". $class_id);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		return $message;			  		
	}
}

#Testing - debuging
/*		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$object = new Timetable($conn);
		var_dump( json_encode( $object->getFacultyTimetable(111) ) );
		echo "<br>";
		var_dump( json_encode( $object->getSemTimetable(4,2017)) );
		echo "<br>";
		var_dump( json_encode( $object->getStudentTimetable(111051, 2017)) );
		echo "<br>";*/
/*		echo $object->setTimetable(102, '2017-11-09', "07:00:00", "08:00:00");
				echo "<br>";
		echo $object->updateTimetable(4, 12 , '2016-11-09',"07:00:00", "08:00:00");
				echo "<br>";
		echo $object->deleteTimetable(8);*/


?>