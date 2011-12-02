<? include('config.php');
	$username = $_POST['forgotPassUsername'];
	$username = 'test';
	return json_encode(array("pass"=>"This is returned from PHP : ".$username));  


?>