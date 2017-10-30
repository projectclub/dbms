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
		$query="SELECT `rollno`, `name`, `gender` FROM `student` ";

		if(isset($_GET['rollno']))	{
			$rollno=$_GET['rollno'];
			$query.=" WHERE `rollno` = ". $rollno;
		}	
		$result = $this->conn->query($query);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data[$rs["rollno"]]["name"] = $rs["name"];
  		  $data[$rs["rollno"]]["gender"] = $rs["gender"];			  		
		}
		return $data;
		}

	public function addStudent() {
		if(isset($_POST['name']) && isset($_POST['gender']) ) {
			$name = $_POST['name'];
			 $department_id = 1;
			$address = '';
			$gender =   $_POST['gender'];
			$date_of_birth = '';
			$phone_no = '';
			$email_id = '';
			$joining_year = '';
			$fathers_name = '';
			$mothers_name = '';

			if(isset($_POST['department_id'])) { $department_id = $_POST['department_id']; }
			if(isset($_POST['address'])) { $address = $_POST['address']; }
			if(isset($_POST['date_of_birth'])) { $date_of_birth = $_POST['date_of_birth']; }
			if(isset($_POST['phone_no'])) { $phone_no = $_POST['phone_no']; }
			if(isset($_POST['email_id'])) { $email_id = $_POST['email_id']; }
			if(isset($_POST['joining_year'])) { $joining_year = $_POST['joining_year']; }
			if(isset($_POST['fathers_name'])) { $fathers_name = $_POST['fathers_name']; }
			if(isset($_POST['mothers_name'])) { $mothers_name = $_POST['mothers_name']; }

			$query = "INSERT INTO `student`(`name`, `department_id`, `address`, `gender`, `date_of_birth`, `phone_no`, `email_id`, `joining_year`, `fathers_name`, `mothers_name`) VALUES (
			'". $name ."'
			". $department_id ."
			'". $address ."'
			'". $gender ."'
			'". $date_of_birth ."'
			". $phone_no ."
			'". $email_id ."'
			". $joining_year ."
			'". $fathers_name ."'
			'". $mothers_name ."'
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
	public function updateStudent() {
		
		$query="UPDATE `student` SET "

		if(isset($_POST['rollno'])) {
			$rollno=$_POST['rollno'];
			$count=0;
			$this->andAddIfIsset($query,"name" , $count);
			$this->andAddIfIsset($query,"department_id" , $count);
			$this->andAddIfIsset($query,"address" , $count, True);
			$this->andAddIfIsset($query,"gender" , $count, True);
			$this->andAddIfIsset($query,"date_of_birth" , $count, True);
			$this->andAddIfIsset($query,"phone_no" , $count);
			$this->andAddIfIsset($query,"email_id" , $count, True);
			$this->andAddIfIsset($query,"joining_year" , $count);
			$this->andAddIfIsset($query,"fathers_name" , $count, True);
			$this->andAddIfIsset($query,"mothers_name" , $count, True);

			if($count==0)
				return ;

			$query .= "	WHERE `rollno` =". $rollno;

			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

	public function deleteStudent() {
		if(isset($_POST['rollno']) ) {
			$rollno=$_POST['rollno'];

			$query="DELETE FROM `student` WHERE `rollno`= ". $rollno;
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
		$object = new Student($conn);
		var_dump( json_encode( $object->getStudents() ) );
		echo "<br>";
		var_dump( json_encode( $object->getStudent(111055)) );
		echo "<br>";
		var_dump( json_encode( $object->getStudentEnrollment(111055)) );
		echo "<br>";
		echo $object->setStudent(111052, 1);
		echo $object->deleteStudent(111052,1);*/
/*		echo $object->setStudent('Laximinarayan', 'm');
		echo $object->updateStudent(111068, 'Laxi');
		echo $object->deleteStudent(111068);*/

?>