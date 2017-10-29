<?php
	require_once("SimpleRest.php");
	require_once('classes/Login.php');


class AuthRestHandler extends SimpleRest{
	use BasicEncoding;
	protected $conn=null;
	public function __construct()
	{
		include 'config.php'; //make the cofig file include
		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	

	}	

	public function __destruct()
	{
		$this->conn->close();
	}

	function authenticate($user, $pass){
/*		$this->conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
*/
		$auth = new Login($this->conn);
		$rawData = $auth->authenticate($user, $pass) ;

		return $this->restHandling($rawData);
	}

}

?>