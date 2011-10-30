<?php 
	// Connects to Database
	//mysql_connect("localhost", "xgamings_connact", "connactive123") or die(mysql_error()); //This is our database credentials
	mysql_connect("localhost", "root", "") or die(mysql_error()); 	//This is wamp database credentials
	mysql_select_db("xgamings_connactiv") or die(mysql_error()); 

	//Checks if there is a login cookie
	if(isset($_COOKIE['ID_my_site']))
	//if there is, it logs you in and directes you to the home page
	{ 
		$username = $_COOKIE['ID_my_site']; 
		$pass = $_COOKIE['Key_my_site'];
 	 	$check = mysql_query("SELECT * FROM users WHERE email = '$username'")or die(mysql_error());
		while($info = mysql_fetch_array( $check )) 	{
			if ($pass != $info['PASSWORD']) {
				//Cookie doesn't match password go to index";
				header("Location: ../index.html"); 
			}
			else{
				//Cookie matches, show what they want.";
				header("Location: home.html");
 			}

 		}

	}
	
	//if the login form is submitted i.e. the user supplies login credentials
	// if form has been submitted
	if (isset($_POST['submit'])) { 
		// makes sure they filled it in
		if(!$_POST['username'] | !$_POST['pass']) {
			die('You did not fill in a required field.');
		}
		// checks it against the database
		if (!get_magic_quotes_gpc()) {
			$_POST['email'] = addslashes($_POST['email']);		//I do not know where this came from. Did you add it dave?
		}
		$check = mysql_query("SELECT * FROM users WHERE email = '".$_POST['username']."'")or die(mysql_error());
		//Gives error if user dosen't exist
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) {
			die('That user does not exist in our database. <a href=registration.php>Click Here to Register</a>');
		}
		while($info = mysql_fetch_array( $check )) 	
		{
			$_POST['pass'] = stripslashes($_POST['pass']);
			$info['PASSWORD'] = stripslashes($info['PASSWORD']);
			$_POST['pass'] = md5($_POST['pass']);
			//gives error if the password is wrong
			if ($_POST['pass'] != $info['PASSWORD']) {
				die('Incorrect password, please try again.');
			}
			else { 
			// if login is ok then we add a cookie 
			 $_POST['username'] = stripslashes($_POST['username']); 
			 $hour = time() + 3600; 
			setcookie(ID_my_site, $_POST['username'], $hour); 
			setcookie(Key_my_site, $_POST['pass'], $hour);	 
			//then redirect them to the members area 
			header("Location: ../index.html"); 
			} 
		} 
	} 
	else {	 
	// if they are not logged in";
	//header("Location: ../index.html");
	?> 
<script type="text/javascript">
	
	$('#login').click(function(e) {
		e.preventDefault();
		$('#credentials').slideDown();
	});
	
	$('#signup').click(function(e) {
		e.preventDefault();
		$('#new_user').slideDown();
	});
	
</script>

<center>
	<h1 class="welcome">Welcome to ConnActiv!</h1>
	
	<a class="welcome" id="login" href="#login">Log in</a>
	<a class="welcome" id="signup" href="#signup">Sign up</a>
	
	<div id="credentials" style="display:none">
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
		<table>
			<tr>
				<td>Email:</td>
				<td><input id="username"  type="text" name="username" maxlength="25"/><br/><br/></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input id="password" type="password" name="pass" maxlength="100"/></td>
			</tr>
			<tr>
				<input type="submit" name="submit" value="Login"/>
			</tr>
		</table>
		</form>
	</div>
	
	<div id="new_user" style="display:none">
		<table>
			<tr>
				<td>Enter your email (will be used as your username):</td> 
				<td><input type="text"/><br/><br/></td>
			</tr>
			<tr>
				<td>Select your password. Should be between x and y characters:</td> 
				<td><input type="password"/></td>
			</tr>
		</table>
	</div>
	
</center>
 <?php 
 } 
 ?>