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
		$query="SELECT `course_id`,`title` FROM `course` ";

		if(isset($_GET['course_id']))	{
			$course_id=$_GET['course_id'];
			$query.=" WHERE `course_id` = ". $course_id;
		}	

		$result = $this->conn->query($query);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["course_id"]] = $rs["title"];		
		}
		return $data;
	}

	public function addCourse() {

		if(isset($_POST['title']) && isset($_POST['semester']) ) {

			$title = $_POST['title'];
			$semester =   $_POST['semester'];

			$query="INSERT INTO `course`(`title`, `semester`) VALUES (
			'". $title ."' , ". $semester ." )";

		// echo "<br>". $q ."<br>"; #debug	
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
	}

	public function updateCourse() {
		$query = "UPDATE `course` SET  " ;

		if(isset($_POST['course_id'])) {
			$course_id=$_POST['course_id'];
			$count=0;
			if(isset($_POST['title'])) {
				$title=$_POST['title']; 
				$query .= " title = '". $title."' ";
				$count++;
			}
			if(isset($_POST['semester']) ){ 
				$semester=$_POST['semester']; 
				if($count > 0)
				$query .=" AND ";
				$query .= " semester = '". $semester. "' ";
				$count++;
			}
			if($count==0)
				return ;

			$query .= "	WHERE `course_id` =". $course_id;

			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

///TODO: Dependent teacheces claass attendence enrollment needs to be deleted
	public function deleteCourse() {		
		if(isset($_POST['course_id'])) {
			$course_id=$_POST('course_id');
			
			$query = "DELETE FROM `course` WHERE `course_id`= ". $course_id ;
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

	public function getCourseEnrollment() {
			$query="SELECT `enrollment`.`rollno`,`student`.`name`, `student`.`gender` FROM `enrollment` JOIN `teaches` ON  `enrollment`.`course_faculty_year_id`= `teaches`.`course_faculty_year_id` JOIN `student` ON `student`.`rollno`= `enrollment`.`rollno` ";
			if(isset($_GET['course_faculty_year_id'])){
				$course_faculty_year_id= $_GET['course_faculty_year_id'];
				$query .= 	" WHERE `enrollment`.`course_faculty_year_id` = ". $course_faculty_year_id;
			}
			else if(isset($_GET['course_id'], $_GET['year'])){
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
	public function getStudentEnrollment() {
		if(isset($_POST['rollno']) ) {
			$rollno=$_POST['rollno'];
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
	}

	public function addCourseCEnrollment() {
		if(isset($_POST['rollno']) && isset($_POST['course_faculty_year_id']) ) {
			$rollno=$_POST['rollno'];
			$course_faculty_year_id=$_POST['course_faculty_year_id'];

			$query="INSERT INTO `enrollment`(`rollno`, `course_faculty_year_id`) VALUES  ( ".$rollno.", ".$course_faculty_year_id." )";
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

	public function deleteCourseCEnrollment() {
		if(isset($_POST['rollno']) && isset($_POST['course_faculty_year_id']) ) {
			$rollno=$_POST['rollno'];
			$rollno=$_POST['course_faculty_year_id'];
			$query="DELETE FROM `enrollment` WHERE `rollno`= ". $rollno. "AND `course_faculty_year_id` =". $course_faculty_year_id;
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