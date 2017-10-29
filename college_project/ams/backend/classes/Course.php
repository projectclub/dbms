<?php
require_once 'config.php'; //make the cofig file include
require_once 'utility.php';
global $details;

/*require_once('utility.php');*/

Class Course{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function getCourses() {
		$result = $this->conn->query("SELECT `course_id`,`title` FROM `course`");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["course_id"]] = $rs["title"];		
		}
		return $data;
	}

	public function getCourse($course_id) {
		$result = $this->conn->query("SELECT `course_id`,`title` FROM `course` WHERE `course_id`=". $course_id);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["course_id"]] = $rs["title"];		
		}
		return $data;
	}

	public function setCourse( $title,  $semester) {
		
		$q="INSERT INTO `course`(`title`, `semester`) VALUES (
". nullHandler($title). ",
". nullHandler($semester). "
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

	public function updateCourse($course_id, $title = null,  $semester = null) {
		
		$q="UPDATE `course` SET 
". nullHandler($title, "title") ."
". nullHandler($semester, "semester", ",") ."
		WHERE `course_id` =". $course_id;
		
		echo "<br>". $q ."<br>";	#debug

		$result = $this->conn->query( $q);	
		if( $this->conn->affected_rows > 0 )
			$message = "Record Modified Successfully";
		else
			$message = "Failed Record Modification";
		return $message;
	}

	public function deleteCourse($course_id) {
		$result = $this->conn->query("DELETE FROM `course` WHERE `course_id`= ". $course_id);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		return $message;			  		
	}

		public function getCourseEnrollment() {
			$query="SELECT `enrollment`.`rollno`,`student`.`name`, `student`.`gender` FROM `enrollment` JOIN `teaches` ON  `enrollment`.`course_faculty_year_id`= `teaches`.`course_faculty_year_id` JOIN `student` ON `student`.`rollno`= `enrollment`.`rollno` ";
			if(isset($course_faculty_year_id)){
				$course_faculty_year_id= $_GET['course_faculty_year_id'];
				$query .= 	" WHERE `enrollment`.`course_faculty_year_id` = ". $course_faculty_year_id;
			}
			else if(isset($course_id, $year)){
				$course_id= $_GET['course_id'];
				$year= $_GET['year'];
				$query .= 	" WHERE `enrollment`.`course_faculty_year_id` IN (SELECT `course_faculty_year_id` FROM `teaches` 
			 	WHERE `course_id`= ".$course_id. " AND `year` = ". $year."))";
			}
			$result = $this->conn->query($query);
			$data=array();
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {	
			  $tmp=array();
			  $tmp["rollno"]=$rs["rollno"];
			  $tmp["name"] = $rs["name"];	
	  		  $tmp["gender"] = $rs["gender"];
	  		  array_push($data,$tmp);	
			}
			return $data;
	}
}

#Testing - debuging
/*		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$object = new Course($conn);
		var_dump( json_encode( $object->getCourses() ) );
		echo "<br>";
		var_dump( json_encode( $object->getCourse(101)) );
		echo "<br>";
		echo $object->setCourse("oprating System", 5);
		echo $object->updateCourse(106, 'mpmc');
		echo $object->deleteCourse(106);
*/

?>