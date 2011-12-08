<?
	include_once('../views/functions/config.php'); 

	if(!$_POST['username'] | !$_POST['pass']) {
			die('Oops. You did not fill in a required field.');
		}
		// checks it against the database
		//if (!get_magic_quotes_gpc()) {
		//	$_POST['email'] = addslashes($_POST['email']);		//I do not know where this came from. Did you add it dave?
		//}
		$check = mysql_query("SELECT * FROM users WHERE email = '".$_POST['username']."'")or die(mysql_error());
		//Gives error if user dosen't exist
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) {
			echo '<div class="error">Sorry, that user does not exist in our database. Why don\'t you register?</div>';
		}
		while($info = mysql_fetch_array( $check )) 	
		{
			$_POST['pass'] = stripslashes($_POST['pass']);
			$info['PASSWORD'] = stripslashes($info['PASSWORD']);
			$_POST['pass'] = md5($_POST['pass']);
			//gives error if the password is wrong
			if ($_POST['pass'] != $info['PASSWORD']) {
				echo '<div class="error">Incorrect password, please try again.</div>';
			}
			else { 
			// if login is ok then we add a cookie 
			 $_POST['username'] = stripslashes($_POST['username']);
			 $hour = time() + 100000;
			setcookie('ID_my_site', $_POST['username'], $hour, '/');
			setcookie('Key_my_site', $_POST['pass'], $hour, '/');
			//then redirect them to the members area 
			$info = getDatabaseInfo("users", "email", $_POST['username']);
				echo $info['USER_ID'];
			} 
		}

	
?>
