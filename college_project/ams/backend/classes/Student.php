<?php
require_once 'config.php'; //make the cofig file include
require_once 'utility.php';
global $details;

/*function nullHandler($atrib_name, $value, $cat="") {
	return  ((empty($value) or !isset($value))? "": 
				((is_string($value))? ($atrib_name." = '". $value. "'". $cat) : ($atrib_name. "=". $value. $cat)) ); 
}*/

Class Student{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{

		$this->conn =$conn;
	}

	public function getStudents() {
		$result = $this->conn->query("SELECT `rollno`, `name`, `gender` FROM `student` ");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["rollno"]]["name"] = $rs["name"];
  		  $data[$rs["rollno"]]["gender"] = $rs["gender"];			  		
		}
		return $data;
	}

	public function getStudent($rollno) {
		$result = $this->conn->query("SELECT `rollno`, `name`, `gender` FROM `student` WHERE `rollno`=". $rollno);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["rollno"]]["name"] = $rs["name"];	
  		  $data[$rs["rollno"]]["gender"] = $rs["gender"];	
		}
		return $data;
	}

	public function setStudent( $name , $gender , $department_id = 1,  $address = null, $date_of_birth = null, $phone_no = null, $email_id = null, $joining_year = null, $fathers_name = null, $mothers_name = null) {
		
		$q="INSERT INTO `student`(`name`, `department_id`, `address`, `gender`, `date_of_birth`, `phone_no`, `email_id`, `joining_year`, `fathers_name`, `mothers_name`) VALUES (
		". nullHandler($name). ",
		". nullHandler($department_id). ",
		". nullHandler($address). ",
		". nullHandler($gender). ",
		". nullHandler($date_of_birth). ",
		". nullHandler($phone_no). ",
		". nullHandler($email_id). ",
		". nullHandler($joining_year). ",
		". nullHandler($fathers_name). ",
		". nullHandler($mothers_name). "
		)";

/*		echo "<br>". $q ."<br>"; #debug
*/		
		$result = $this->conn->query( $q);
		$current_id = $this->conn->insert_id;
		if( !empty($current_id) )
			$message = "New Record Added Successfully";
		else
			$message = "Failed Adding New Record";
		return $message;
	}

	public function updateStudent($rollno, $name=null ,$gender=null , $department_id=null, $address = null, $date_of_birth = null, $phone_no = null, $email_id = null, $joining_year = null, $fathers_name = null, $mothers_name = null ) {
		
		$q="UPDATE `student` SET 
		". nullHandler($name, "name") ."
		". nullHandler($department_id, "department_id", ",") ."
		". nullHandler($address, "address", ",") ."
		". nullHandler($gender, "gender", ",") ."
		". nullHandler($date_of_birth, "date_of_birth", ",") ."
		". nullHandler($phone_no, "phone_no", ",") ."
		". nullHandler($email_id, "email_id", ",") ."
		". nullHandler($joining_year, "joining_year", ",") ."
		". nullHandler($fathers_name, "fathers_name", ",") ."
		". nullHandler($mothers_name, "mothers_name", ",") ."
		WHERE `rollno` =". $rollno;
		
/*		echo "<br>". $q ."<br>";	#debug
*/
		$result = $this->conn->query( $q);	
		if( $this->conn->affected_rows > 0 )
			$message = "Record Modified Successfully";
		else
			$message = "Failed Record Modification";
		return $message;
	}

	public function deleteStudent($rollno ) {
		$result = $this->conn->query("DELETE FROM `student` WHERE `rollno`= ". $rollno);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		return $message;			  		
	}

	public function getStudentEnrollment($rollno) {
		$result = $this->conn->query("SELECT `rollno`, `enrollment`.`course_faculty_year_id`, `course`.`title`, `course`.`semester`, `faculty`.`faculty_id`, `faculty`.`faculty_name` FROM `enrollment` JOIN `teaches` ON  `enrollment`.`course_faculty_year_id`= `teaches`.`course_faculty_year_id` JOIN `course` ON `teaches`.`course_id`= `course`.`course_id` JOIN `faculty` ON `teaches`.`faculty_id`= `faculty`.`faculty_id` WHERE `rollno` = ". $rollno);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["course_faculty_year_id"]]["title"] = $rs["title"];	
  		  $data[$rs["course_faculty_year_id"]]["semester"] = $rs["semester"];	
  		  $data[$rs["course_faculty_year_id"]]["faculty_id"] = $rs["faculty_id"];	
  		  $data[$rs["course_faculty_year_id"]]["faculty_name"] = $rs["faculty_name"];	
		}
		return $data;
	}

	public function setStudentEnrollment( $rollno, $course_faculty_year_id) {
		
		$q="INSERT INTO `enrollment`(`rollno`, `course_faculty_year_id`) VALUES  (
		". nullHandler($rollno). ",
		". nullHandler($course_faculty_year_id). ",
		)";

/*		echo "<br>". $q ."<br>"; #debug
*/		
		$result = $this->conn->query( $q);
		$current_id = $this->conn->insert_id;
		if( !empty($current_id) )
			$message = "New Record Added Successfully";
		else
			$message = "Failed Adding New Record";
		return $message;
	}

	public function deleteStudentEnrollment($rollno, $course_faculty_year_id ) {
		$result = $this->conn->query("DELETE FROM `enrollment` WHERE `rollno`= ". $rollno. "AND `course_faculty_year_id` =". $course_faculty_year_id);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		return $message;			  		
	}
}


#Testing - debuging
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$object = new Student($conn);
		var_dump( json_encode( $object->getStudents() ) );
		echo "<br>";
		var_dump( json_encode( $object->getStudent(111055)) );
		echo "<br>";
		var_dump( json_encode( $object->getStudentEnrollment(111055)) );
		echo "<br>";
		echo $object->setStudent(111052, 1);
		echo $object->deleteStudent(111052,1);
/*		echo $object->setStudent('Laximinarayan', 'm');
		echo $object->updateStudent(111068, 'Laxi');
		echo $object->deleteStudent(111068);*/

?>