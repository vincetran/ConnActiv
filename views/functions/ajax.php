<?

	
	$email = $_POST['forgotPassUser'];
	
	$query = "SELECT password FROM users WHERE email = '".$email."'";
	$result = mysql_query($query) or die(mysql_error());
	$username = "kim";
	
	return json_encode(array("pass"=>"This is returned from PHP : ".$username));  
	

	function test{
	
		$arr = array("x"=>"x", "y"=>"y");
		return json_encode($arr);  

	
	}


?>