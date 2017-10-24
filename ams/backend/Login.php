<?php
require_once 'config.php'; //make the cofig file include
global $details;

Class Login{

	protected $conn=null;

	public function __construct(mysqli $conn)
	{
		$this->conn =$conn;
	}

	public function authenticate($username, $password) {
		$result = $this->conn->query("SELECT  `id`, `account_type` FROM `login` WHERE id= ". $username. " and pass = '". $password. "'");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		  $data["username"] = $username ;
		  $data["account_type"] = $rs["account_type"] ;
		}
		return $data;
	}
}
#Testing - debuging
/*		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$object = new Login($conn);
		var_dump( json_encode( $object->authenticate(111051,"shiv") ) );
		var_dump( json_encode( $object->authenticate(111055,"shiv") ) );
		var_dump( json_encode( $object->authenticate(111,"kavi") ) );
		var_dump( json_encode( $object->authenticate(000,"admin") ) );*/
?>