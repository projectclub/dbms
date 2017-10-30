
<?php
require_once 'config.php'; //make the cofig file include
require_once 'utility.php';
Class Timetable{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function getFacultyTimetable() {
		if(isset($_GET['faculty_id']) && isset($_GET['year']) ) {
			$faculty_id=$_GET['faculty_id'];
			$year=$_GET['year'];		
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
	}

	public function getSemTimetable() {
		if(isset($_GET['semester']) && isset($_GET['year']) ) {
			$semester=$_GET['semester'];
			$year=$_GET['year'];
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
	}
	public function getStudentTimetable() {
		if(isset($_GET['rollno']) && isset($_GET['year']) ) {
			$rollno=$_GET['rollno'];
			$year=$_GET['year'];

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
	}

	public function addTimetable() {
		if( isset($_POST['course_faculty_year_id']) && isset($_POST['day'])&& isset($_POST['start_time']) && isset($_POST['end_time']) ) {
			$course_faculty_year_id=$_POST('course_faculty_year_id');
			$day=$_POST('day');
			$start_time=$_POST('start_time');
			$end_time=$_POST('end_time');
			$query = "INSERT INTO `timetable`(`course_faculty_year_id`, `day`, `start_time`, `end_time`) VALUES (".$course_faculty_year_id.", ".$day.", ".$start_time. ", ".$end_time.")";

			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

	public function deleteTimetable() {			  		
		if( isset($_POST['course_faculty_year_id']) && isset($_POST['day'])&& isset($_POST['start_time']) && isset($_POST['end_time']) ) {
			$course_faculty_year_id=$_POST('course_faculty_year_id');
			$day=$_POST('day');
			$start_time=$_POST('start_time');
			$end_time=$_POST('end_time');
			$query = "DELETE FROM `timetable` WHERE `course_faculty_year_id` = ".$course_faculty_year_id." AND `day` = '".$day."' AND `start_time` = '".$start_time."' AND `end_time` = '".$end_time. "' ";
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