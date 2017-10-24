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

/*function nullHandler($atrib_name, $value, $cat="") {
	return  ((empty($value) or !isset($value))? "": 
				((is_string($value))? ($atrib_name." = '". $value. "'". $cat) : ($atrib_name. "=". $value. $cat)) ); 
}*/

Class Faculty{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{

		$this->conn =$conn;
	}

	public function getFaculties() {
		$result = $this->conn->query("SELECT `faculty_id`,`faculty_name`,`gender` FROM `faculty`");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["faculty_id"]]["faculty_name"] = $rs["faculty_name"];
  		  $data[$rs["faculty_id"]]["gender"] = $rs["gender"];			  		
		}
		return $data;
	}

	public function getFaculty($faculty_id) {
		$result = $this->conn->query("SELECT `faculty_id`,`faculty_name`,`gender` FROM `faculty` WHERE `faculty_id`=". $faculty_id);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["faculty_id"]]["faculty_name"] = $rs["faculty_name"];	
  		  $data[$rs["faculty_id"]]["gender"] = $rs["gender"];	
		}
		return $data;
	}

	public function setFaculty( $faculty_name ,$gender , $department_id = 1, $faculty_office_phone = null, $faculty_mobile_no = null, $faculty_email = null, $joining_date = null, $birthdate = null, $teaching_exp = null, $industry_exp = null, $permannet_address = null, $local_address = null, $ug_university = null, $pg_university = null, $pan_card_no = null, $election_card_no = null ) {
		
		$q="INSERT INTO `faculty`(`faculty_name`, `department_id`, `faculty_office_phone`, `faculty_mobile_no`, `faculty_email`, `joining_date`, `gender`, `birthdate`, `teaching_exp`, `industry_exp`, `permannet_address`, `local_address`, `ug_university`, `pg_university`, `pan_card_no`, `election_card_no`) VALUES (
			". nullHandler($faculty_name). ",
			". nullHandler($department_id). ",
			". nullHandler($faculty_office_phone). ",
			". nullHandler($faculty_mobile_no). ",
			". nullHandler($faculty_email). ",
			". nullHandler($joining_date). ",
			". nullHandler($gender). ",
			". nullHandler($birthdate). ",
			". nullHandler($teaching_exp). ",
			". nullHandler($industry_exp). ",
			". nullHandler($permannet_address). ",
			". nullHandler($local_address). ",
			". nullHandler($ug_university). ",
			". nullHandler($pg_university). ",
			". nullHandler($pan_card_no). ",
			". nullHandler($election_card_no). "
		)";
		
		/*echo "<br>". $q ."<br>";	#debug*/

		$result = $this->conn->query( $q);
		$current_id = $this->conn->insert_id;
		if( !empty($current_id) )
			$message = "New Record Added Successfully";
		else
			$message = "Failed Adding New Record";
		return $message;
	}

	public function updateFaculty($faculty_id, $faculty_name=null ,$gender=null , $department_id=null, $faculty_office_phone = null, $faculty_mobile_no = null, $faculty_email = null, $joining_date = null, $birthdate = null, $teaching_exp = null, $industry_exp = null, $permannet_address = null, $local_address = null, $ug_university = null, $pg_university = null, $pan_card_no = null, $election_card_no = null ) {
		
		$q="UPDATE `faculty` SET 
		". nullHandler($faculty_name, "faculty_name") ."
		". nullHandler($department_id, "department_id", ",") ."
		". nullHandler($faculty_office_phone, "faculty_office_phone", ",") ."
		". nullHandler($faculty_mobile_no, "faculty_mobile_no", ",") ."
		". nullHandler($faculty_email, "faculty_email", ",") ."
		". nullHandler($joining_date, "joining_date", ",") ."
		". nullHandler($gender, "gender", ",") ."
		". nullHandler($birthdate, "birthdate", ",") ."
		". nullHandler($teaching_exp, "teaching_exp", ",") ."
		". nullHandler($industry_exp, "industry_exp", ",") ."
		". nullHandler($permannet_address, "permannet_address", ",") ."
		". nullHandler($local_address, "local_address", ",") ."
		". nullHandler($ug_university, "ug_university", ",") ."
		". nullHandler($pg_university, "pg_university", ",") ."
		". nullHandler($pan_card_no, "pan_card_no", ",") ."
		". nullHandler($election_card_no,"election_card_no", ",") ."
		WHERE `faculty_id` =". $faculty_id;
		
		/*echo "<br>". $q ."<br>";	#debug*/

		$result = $this->conn->query( $q);
		if( $this->conn->affected_rows > 0 )
			$message = "Record Modified Successfully";
		else
			$message = "Failed Record Modification";
		return $message;
	}

	public function deleteFaculty($faculty_id) {
		$result = $this->conn->query("DELETE FROM `faculty` WHERE `faculty_id`= ". $faculty_id);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		return $message;			  		
	}

	public function getTeachingCourse($faculty_id, $year) {
		$result = $this->conn->query("SELECT `teaches`.`course_faculty_year_id`, `teaches`.`course_id`, `course_component`.`type`, `course`.`title`, `course`.`semester` FROM `teaches` JOIN `course_component` ON `course_component`.`course_faculty_year_id` = `teaches`.`course_faculty_year_id` JOIN `course` ON `course`.`course_id` = `teaches`.`course_id` WHERE `teaches`.`faculty_id` = ". $faculty_id. " and `year` = ".$year);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
  		  $data[$rs["course_id"]]["course_faculty_year_id"] = $rs["course_faculty_year_id"];
  		  $data[$rs["course_id"]]["course_id"] = $rs["course_id"];
		  $data[$rs["course_id"]]["title"] = $rs["title"];
  		  $data[$rs["course_id"]]["type"] = $rs["type"];
  		  $data[$rs["course_id"]]["semester"] = $rs["semester"];
		}
		return $data;
	}

	public function setTeachingCourse($course_id, $faculty_id, $year, $type) {

		$q1="INSERT INTO `teaches`(`course_id`, `faculty_id`, `year`) VALUES (
		". nullHandler($course_id). ",
		". nullHandler($faculty_id). ",
		". nullHandler($year). "
		)";

		echo "<br>". $q1 ."<br>"; #debug
		
		$result = $this->conn->query( $q1);
		$current_id = $this->conn->insert_id;
		if( !empty($current_id) )
			{
				$message = "New Record Added Successfully";
				$q2="INSERT INTO `course_component`(`course_faculty_year_id`, `type`) VALUES(
				". nullHandler($current_id). ",
				". nullHandler($type). "		
				);";

				echo "<br>". $q2 ."<br>"; #debug
				$result = $this->conn->query( $q2);				
				if( $this->conn->affected_rows > 0 )
					$message .= " New Record component Added Successfully";
				else
					$message .= " Failed Adding New Record component";
			}
		else
			$message = "Failed Adding New Record";
		return $message;
	}
	public function updateTeachingCourse($course_faculty_year_id, $course_id=null, $faculty_id=null, $year=null) {		
		$q="UPDATE `teaches` SET 
		". nullHandler($course_id, "course_id") ."
		". nullHandler($faculty_id, "faculty_id") ."
		". nullHandler($year, "year") ."
		WHERE `course_faculty_year_id` =". $course_faculty_year_id;
		
		echo "<br>". $q ."<br>";	#debug

		$result = $this->conn->query( $q);	
		if( $this->conn->affected_rows > 0 )
			$message = "Record Modified Successfully";
		else
			$message = "Failed Record Modification";
		return $message;
	}

	public function updateCourseComponent($course_faculty_year_id, $type) {
		
		$q="UPDATE `course_component` SET 
		". nullHandler($type, "type") ."
		WHERE `course_faculty_year_id` =". $course_faculty_year_id;
		
		echo "<br>". $q ."<br>";	#debug

		$result = $this->conn->query( $q);	
		if( $this->conn->affected_rows > 0 )
			$message = "Record Modified Successfully";
		else
			$message = "Failed Record Modification";
		return $message;
	}

	public function deleteTeachingCourse($course_faculty_year_id) {
		$result = $this->conn->query("DELETE FROM `teaches` WHERE `course_faculty_year_id`= ". $course_faculty_year_id);
		
		if( $this->conn->affected_rows > 0 )
			$message = "Record Deleted Successfully";
		else
			$message = "Failed Record Deletion";
		$result = $this->conn->query("DELETE FROM `course_component` WHERE `course_faculty_year_id`= ". $course_faculty_year_id);
		
		if( $this->conn->affected_rows > 0 )
			$message .= "Record component Deleted Successfully";
		else
			$message .= "Failed Record component Deletion";

		return $message;			  		
	}	

	public function getCourseEnrollment($course_faculty_year_id) {
		$result = $this->conn->query("SELECT `rollno`, `enrollment`.`course_faculty_year_id`, `course`.`title`, `course`.`semester`, `faculty`.`faculty_id`, `faculty`.`faculty_name` FROM `enrollment` JOIN `teaches` ON  `enrollment`.`course_faculty_year_id`= `teaches`.`course_faculty_year_id` JOIN `course` ON `teaches`.`course_id`= `course`.`course_id` JOIN `faculty` ON `teaches`.`faculty_id`= `faculty`.`faculty_id` WHERE `enrollment`.`course_faculty_year_id` = ". $course_faculty_year_id);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["course_faculty_year_id"]]["title"] = $rs["title"];	
  		  $data[$rs["course_faculty_year_id"]]["semester"] = $rs["semester"];
  		  if(!isset($data[$rs["course_faculty_year_id"]]["students"]))
	  		  $data[$rs["course_faculty_year_id"]]["students"]=array();
  		  array_push($data[$rs["course_faculty_year_id"]]["students"], $rs["rollno"]);
		}
		return $data;
	}
}

#Testing - debuging
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$faculty = new Faculty($conn);
		var_dump( json_encode( $faculty->getFaculties() ) );
		echo "<br>";
		var_dump( json_encode( $faculty->getFaculty(111)) );
		echo "<br>";
		var_dump( json_encode( $faculty->getTeachingCourse(111, 2017)) );
		echo "<br>";
		var_dump( json_encode( $faculty->getCourseEnrollment(1)) );
		echo "<br>";
/*		echo $faculty->setFaculty('Laximinarayan', 'm');
		echo $faculty->updateFaculty(145, 'Laxi');
		echo $faculty->deleteFaculty(145);*/

#TODO: debug testing insert update delete 
?>