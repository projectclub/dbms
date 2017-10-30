<?php
require_once 'config.php'; //make the cofig file include
require_once 'utility.php';

/*require_once('utility.php');*/

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
		$query = "SELECT `faculty_id`,`faculty_name`,`gender` FROM `faculty` ";

		if(isset($_GET['faculty_id']))	{
			$faculty_id=$_GET['faculty_id'];
			$query.=" WHERE `faculty_id` = ". $faculty_id;
		}	

		$result = $this->conn->query($query);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["faculty_id"]]["faculty_name"] = $rs["faculty_name"];
  		  $data[$rs["faculty_id"]]["gender"] = $rs["gender"];			  		
		}
		return $data;
	}

	public function addFaculty() {		
		if(isset($_POST['faculty_name']) && isset($_POST['gender']) ) {
			$faculty_name = $_POST['faculty_name'];
			 $department_id = 1;
			 $faculty_office_phone = '';
			 $faculty_mobile_no = '';
			 $faculty_email = '';
			 $joining_date = '';
			$gender =   $_POST['gender'];
			 $birthdate = '';
			 $teaching_exp = '';
			 $industry_exp = '';
			 $permannet_address = '';
			 $local_address = '';
			 $ug_university = '';
			 $pg_university = '';
			 $pan_card_no = '';
			 $election_card_no = '';

			if(isset($_POST['department_id'])) { $department_id = $_POST['department_id'];}
			if(isset($_POST['faculty_office_phone'])) { $faculty_office_phone = $_POST['faculty_office_phone'];}
			if(isset($_POST['faculty_mobile_no'])) { $faculty_mobile_no = $_POST['faculty_mobile_no'];}
			if(isset($_POST['faculty_email'])) { $faculty_email = $_POST['faculty_email'];}
			if(isset($_POST['joining_date'])) { $joining_date = $_POST['joining_date'];}
			if(isset($_POST['birthdate'])) { $birthdate = $_POST['birthdate'];}
			if(isset($_POST['teaching_exp'])) { $teaching_exp = $_POST['teaching_exp'];}
			if(isset($_POST['industry_exp'])) { $industry_exp = $_POST['industry_exp'];}
			if(isset($_POST['permannet_address'])) { $permannet_address = $_POST['permannet_address'];}
			if(isset($_POST['local_address'])) { $local_address = $_POST['local_address'];}
			if(isset($_POST['ug_university'])) { $ug_university = $_POST['ug_university'];}
			if(isset($_POST['pg_university'])) { $pg_university = $_POST['pg_university'];}
			if(isset($_POST['pan_card_no'])) { $pan_card_no = $_POST['pan_card_no'];}
			if(isset($_POST['election_card_no'])) { $election_card_no = $_POST['election_card_no'];}


			$query = "INSERT INTO `faculty`(`faculty_name`, `department_id`, `faculty_office_phone`, `faculty_mobile_no`, `faculty_email`, `joining_date`, `gender`, `birthdate`, `teaching_exp`, `industry_exp`, `permannet_address`, `local_address`, `ug_university`, `pg_university`, `pan_card_no`, `election_card_no`) VALUES (
			'". $faculty_name. "',
			". $department_id. ",
			". $faculty_office_phone. ",
			". $faculty_mobile_no. ",
			'". $faculty_email. "',
			'". $joining_date. "',
			'". $gender. "',
			'". $birthdate. "',
			". $teaching_exp. ",
			". $industry_exp. ",
			'". $permannet_address. "',
			'". $local_address. "',
			'". $ug_university. "',
			'". $pg_university. "',
			'". $pan_card_no. "',
			'". $election_card_no. "'
		)";

		// echo "<br>". $q ."<br>"; #debug	
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
	}
	protected function andAddIfIsset(&$query, $varString, &$count, $q=False){
		if(isset($_POST[$varString]) ){ 
			$val=$_POST[$varString]; 
			if($count > 0)
				$query .=" AND ";
			if($q)
				$query .= " ". $varString. " = '". $val. "' ";
			else
				$query .= " ". $varString. " = ". $val. " ";

		}
	}
	public function updateFaculty() {
		$query = "UPDATE `faculty` SET " ;

		if(isset($_POST['faculty_id'])) {
			$faculty_id=$_POST['faculty_id'];
			$count=0;

			$this->andAddIfIsset($query,"faculty_name " , $count, True);
			$this->andAddIfIsset($query,"department_id " , $count);
			$this->andAddIfIsset($query,"faculty_office_phone " , $count);
			$this->andAddIfIsset($query,"faculty_mobile_no " , $count);
			$this->andAddIfIsset($query,"faculty_email " , $count, True);
			$this->andAddIfIsset($query,"joining_date " , $count, True);
			$this->andAddIfIsset($query,"gender " , $count, True);
			$this->andAddIfIsset($query,"birthdate " , $count, True);
			$this->andAddIfIsset($query,"teaching_exp " , $count);
			$this->andAddIfIsset($query,"industry_exp " , $count);
			$this->andAddIfIsset($query,"permannet_address " , $count, True);
			$this->andAddIfIsset($query,"local_address " , $count, True);
			$this->andAddIfIsset($query,"ug_university " , $count, True);
			$this->andAddIfIsset($query,"pg_university " , $count, True);
			$this->andAddIfIsset($query,"pan_card_no " , $count, True);
			$this->andAddIfIsset($query,"election_card_no " , $count, True);

			if($count==0)
				return ;

			$query .= "	WHERE `faculty_id` =". $faculty_id;

			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

	public function deleteFaculty() {
		if(isset($_POST['faculty_id']) ) {
			$faculty_id=$_POST['faculty_id'];

			$query="DELETE FROM `faculty` WHERE `faculty_id`= ". $faculty_id;
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}			  		
	}

	public function getTeachingCourse() {
		$query="SELECT `teaches`.`course_faculty_year_id`, `teaches`.`course_id`, `course_component`.`type`, `course`.`title`,`year`, `course`.`semester` FROM `teaches` JOIN `course_component` ON `course_component`.`course_faculty_year_id` = `teaches`.`course_faculty_year_id` JOIN `course` ON `course`.`course_id` = `teaches`.`course_id` ";

		if(isset($_GET['faculty_id']) && isset($_GET['year']) )	{
			$faculty_id=$_GET['faculty_id'];
			$year=$_GET['year'];
			$query.="WHERE `teaches`.`faculty_id` = ". $faculty_id. " and `year` = ". $year;
		}	

		$result = $this->conn->query($query);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
  		  $data[$rs["course_id"]]["components"][$rs["course_faculty_year_id"]] = $rs["type"];
  		  $data[$rs["course_id"]]["course_id"] = $rs["course_id"];
		  $data[$rs["course_id"]]["title"] = $rs["title"];
		  /*$data[$rs["course_id"]]["type"] = [];
  		  array_push($data[$rs["course_id"]]["type"],$rs["type"]);*/
  		  $data[$rs["course_id"]]["semester"] = $rs["semester"];
		  $data[$rs["course_id"]]["year"] = $rs["year"];
		}
		return $data;
	}

	public function addTeachingCourse() {		
		if(isset($_POST['course_id']) && isset($_POST['faculty_id']) && isset($_POST['year']) && isset($_POST['type'])) {

			$course_id =   $_POST['course_id'];
			$faculty_id = $_POST['faculty_id'];
			$year = $_POST['year'];
			$type =   $_POST['type'];

			$query="INSERT INTO `teaches`(`course_id`, `faculty_id`, `year`) VALUES (
			". $course_id ." , ". $faculty_id .", ". $year ." )";

		// echo "<br>". $q ."<br>"; #debug	
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0) {
				$current_id = $this->conn->insert_id;
				if( !empty($current_id) ) {
					$query="INSERT INTO `course_component`(`course_faculty_year_id`, `type`) VALUES( ". $current_id ." , '". $type ."' )";	

					$result = $this->executeQuery($this->conn, $query);	
					if($result != 0) {
						$result = array('success'=>2);
						return $result;
					}				
				}
				$result = array('success'=>1);
				return $result;
			}
		}
	}
	public function updateTeachingCourse() {
		$query = "UPDATE `teaches` SET  " ;

		if(isset($_POST['course_faculty_year_id'])) {
			$course_faculty_year_id=$_POST['course_faculty_year_id'];
			
			$count=0;
			if(isset($_POST['course_id'])) {
				$course_id=$_POST['course_id']; 
				$query .= " course_id = ". $course_id;
				$count++;
			}
			if(isset($_POST['faculty_id']) ){ 
				$faculty_id=$_POST['faculty_id']; 
				if($count > 0)
				$query .=" AND ";
				$query .= " faculty_id = ". $faculty_id. " ";
				$count++;
			}
			if(isset($_POST['year']) ) { 
				$year=$_POST['year']; 
				if($count > 0)
				$query .=" AND ";
				$query .= " year = ". $year. " ";
				$count++;
			}
			if($count==0)
				return ;

			$query .= "	WHERE `course_faculty_year_id` =". $course_faculty_year_id;

			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}	
		}
		$this->updateCourseComponent();		  		
	}

	public function updateCourseComponent() {
		if(isset($_POST['course_faculty_year_id']) && isset($_POST['type'])) {
			$course_faculty_year_id=$_POST['course_faculty_year_id'];
			$type=$_POST['type'];
			
			$query = "UPDATE `course_component` SET type = '". $type. "' ";
			$query .= "	WHERE `course_faculty_year_id` =". $course_faculty_year_id;

			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

	public function deleteTeachingCourse() {
		if(isset($_POST['course_faculty_year_id'])) {
			$course_faculty_year_id=$_POST('course_faculty_year_id');
			
			$query = "DELETE FROM `course_component` WHERE `course_faculty_year_id`= ". $course_faculty_year_id ;
			
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$query = "DELETE FROM `teaches` WHERE `course_faculty_year_id`= ". $course_faculty_year_id;
				$result = $this->executeQuery($this->conn, $query);	

				if($result != 0){					
					$result = array('success'=>2);
					return $result;
				}	
				$result = array('success'=>1);
				return $result;
			}		  
		}		  		
	}	

}

#Testing - debuging
/*		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$faculty = new Faculty($conn);
		var_dump( json_encode( $faculty->getFaculties() ) );
		echo "<br>";
		var_dump( json_encode( $faculty->getFaculty(111)) );
		echo "<br>";
		var_dump( json_encode( $faculty->getTeachingCourse(111, 2017)) );
		echo "<br>";
		var_dump( json_encode( $faculty->getCourseEnrollment(1)) );
		echo "<br>";*/
/*		echo $faculty->setFaculty('Laximinarayan', 'm');
		echo $faculty->updateFaculty(145, 'Laxi');
		echo $faculty->deleteFaculty(145);*/

#TODO: debug testing insert update delete 
?>