<?php
require_once 'config.php'; //make the cofig file include
require_once 'utility.php';
global $details;

Class TClass{

	protected $conn=null;
	use DBhelper;

	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function getClasses() {
		$query="SELECT `class_id`, `course_faculty_year_id`, `date`, `start_time`, `end_time` FROM `class` ";
		//speacial internal
		if(isset($_POST['course_faculty_year_id']) && isset($_POST['date']) && isset($_POST['start_time']) && isset($_POST['end_time'])  ){
			$course_faculty_year_id = $_POST['course_faculty_year_id'];
			$date =   $_POST['date'];
			$start_time =  $_POST['start_time'];
			$end_time =   $_POST['end_time'];
			$query .= " WHERE `course_faculty_year_id` = ". $course_faculty_year_id. " AND `date` = '". $date. "' AND `start_time` = '". $start_time ."' AND `end_time` = '". $end_time."'";
		}
		//normal
		else if(isset($_GET["course_faculty_year_id"])){
			$course_faculty_year_id=$_GET["course_faculty_year_id"];
			$query .= " WHERE `course_faculty_year_id` = ". $course_faculty_year_id;
		}
		else if(isset($_GET["class_id"])){
			$class_id=$_GET["class_id"];
			$query .= " WHERE `class_id` = ". $class_id;
		}

		$result = $this->conn->query($query);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $tmp = array();
		  $tmp["class_id"] = $rs["class_id"];
		  $tmp["course_faculty_year_id"] = $rs["course_faculty_year_id"];
		  $tmp["date"] = $rs["date"];	
		  $tmp["start_time"] = $rs["start_time"];	
		  $tmp["end_time"] = $rs["end_time"];	
		  array_push($data, $tmp);
		}
		return $data;
	}

	public function addClass() {
		if(isset($_POST['course_faculty_year_id']) && isset($_POST['date']) && isset($_POST['start_time']) && isset($_POST['end_time'])  ) {

			$course_faculty_year_id = $_POST['course_faculty_year_id'];
			$date =   $_POST['date'];
			$start_time =  $_POST['start_time'];
			$end_time =   $_POST['end_time'];

			$q="INSERT INTO `class`(`course_faculty_year_id`, `date`, `start_time`, `end_time`) VALUES (
			". $course_faculty_year_id .",'". $date ."','". $start_time ."','". $end_time ."'	)";

			// // echo "<br>". $q ."<br>"; #debug

			// $result = $this->executeQuery($this->conn, $q);

			$result = $this->conn->query( $q);
			if(!$result) {
				//duplicate entry
				if($this->conn->errno == 1062) {
					$result=array();
					$result["class_id"]=$this->getClasses()[0]["class_id"];
					$result['success']=1;
					$result['res_status']="duplicate";
					return $result;
				}
				else {
					trigger_error(mysqli_error($this->conn), E_USER_NOTICE);
				}
			}
			else{
				$affectedRows = mysqli_affected_rows($this->conn);
				if( !empty($current_id) ){
					$result = array('success'=>1, 'class_id'=>$current_id, 'res_status'=>'created');
					return $result;
				}

				$current_id = $this->conn->insert_id;
				if($affectedRows != 0){
					$result=array();
					$result["class_id"]=$this->getClasses()[0]["class_id"];
					$result['success']=1;
					$result['res_status']="created";
					return $result;
				}  
			}
		} 
	}

	public function updateClass() {
		
		$query = "UPDATE `class` SET " ;

		if(isset($_POST['class_id'])) {
			$class_id=$_POST['class_id'];
			$count=0;
			if(isset($_POST['course_faculty_year_id'])) {
				$course_faculty_year_id=$_POST['course_faculty_year_id']; 
				$query .= " course_faculty_year_id = ". $course_faculty_year_id;
				$count++;
			}
			if(isset($_POST['date']) ){ 
				$date=$_POST['date']; 
				if($count > 0)
				$query .=" AND ";
				$query .= " date = '". $date. "' ";
				$count++;
			}
			if(isset($_POST['start_time']) ) { 
				$start_time=$_POST['start_time']; 
				if($count > 0)
				$query .=" AND ";
				$query .= " start_time = '". $start_time. "' ";
				$count++;
			}
			if(isset($_POST['end_time'])) { 
				$end_time=$_POST['end_time']; 
				if($count > 0)
				$query .=" AND ";
				$query .= " end_time = '". $end_time. "' ";
				$count++;
			}
			if($count==0)
				return ;

			$query .= "	WHERE `class_id` =". $class_id;

			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}			  		
		}
	}

	/*DELETE FROM `enrollment` WHERE `course_faculty_year_id` =*/
	public function deleteClass() {
		if(isset($_POST['class_id'])) {
			$class_id=$_POST('class_id');
			
			$query = "DELETE FROM `attendance` WHERE `class_id` = ". $class_id ;
			
			$result = $this->executeQuery($this->conn, $query);	
			if($result != 0){
				$query = "DELETE FROM `class` WHERE `class_id`= ". $class_id;
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
		// $conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		// $object = new TClass($conn);
		// // var_dump( json_encode( $object->getClasses(1) ) );
		// echo "<br>";
		// echo json_encode($object->addClass());//102, '2017-11-09', "07:00:00", "08:00:00");
				// echo "<br>";
		// echo $object->updateClass(4, 12 , '2016-11-09',"07:00:00", "08:00:00");
		// 		echo "<br>";
		// echo $object->deleteClass(8);
?>