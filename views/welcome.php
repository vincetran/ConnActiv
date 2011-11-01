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
	if (isset($_POST['login'])) { 
		// makes sure they filled it in
		if(!$_POST['username'] | !$_POST['pass']) {
			die('You did not fill in a required field.');
		}
		// checks it against the database
		//if (!get_magic_quotes_gpc()) {
		//	$_POST['email'] = addslashes($_POST['email']);		//I do not know where this came from. Did you add it dave?
		//}
		$check = mysql_query("SELECT * FROM Users WHERE email = '".$_POST['username']."'")or die(mysql_error());
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
			 $hour = time() + 100000; 
			setcookie(ID_my_site, $_POST['username'], $hour); 
			setcookie(Key_my_site, $_POST['pass'], $hour);	 
			//then redirect them to the members area 
			header("Location: ../index.html"); 
			} 
		} 
	} 
	else if (isset($_POST['register'])) {
		//check to make sure the required fields were filled in.
		if(!$_POST['username'] | !$_POST['password'] | !$_POST['confirm']) {
			die('You did not fill in a required field.');
		}
		//check to make sure the email is not already registered.
		$check = mysql_query("SELECT * FROM Users WHERE email = '".$_POST['username']."'")or die(mysql_error());
		$check2 = mysql_num_rows($check);
		
		
		//if email has not been registered before
		if($check2 == 0){
			//check to make sure the password was confirmed			
			if($_POST['password'] == $_POST['confirm']){			
				//check to make sure the password is longer than 6 characters, may want to use regexp to improve
				//security				
				if(strlen($_POST['password'] > 6)){
				//insert information into respective tables.
				$insert = mysql_query("Insert into Users(email,firstname, lastname, street, city, state, zip, phone, interests, 				password)  values('".$_POST['username']."','".$_POST['firstName']."','".$_POST['lastName']."','".
				$_POST['street']."','".$_POST['city']."','".$_POST['state']."','".$_POST['zip']."','".$_POST['phone']."','".
				$_POST['interests']."','".md5($_POST['password'])."'") or die(mysql_error());

				//get userid of new user since the user_id is auto incremented and will not be explicitly added.
				$userid = mysql_query("Select USER_ID where email = '".$_POST['username']."'");
				$userid1 = mysql_fetch_array($userid);
				
				//insert all of the user selected activities into the user_activities table.				
				foreach($_POST['activities'] as $act){
					$activityid = mysql_query("select ACTIVITY_ID from ACTIVITIES where ACTIVITY_NAME = '".$act."'");
					$activityid1 = mysql_fetch_array($activityid);

					$insert = mysql_query("Insert into USER_ACTIVITIES(USER_ID, ACTIVITY_ID) values('".$userid1['USER_ID']."','".
					$activityid1['ACTIVITY_ID']."'");
				}

				//create cookie
				$_POST['username'] = stripslashes($_POST['username']); 
				$hour = time() + 100000; 
				setcookie(ID_my_site, $_POST['username'], $hour); 
				setcookie(Key_my_site, $_POST['pass'], $hour);
				//redirect to home				
				header("Location: ../index.html");
				}
			}	
			//if the passwords do not match ask them to enter the information again
			else{ die("the passwords do not match, please re-enter your information");}
		}
		//if the email is already registered then display message
		else{
			die('This email has already been registered.  click here if you forgot your password.');
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
				<td><input id="username"  type="text" name="username" maxlength="25" <?php if(isset($_COOKIE['username'])){echo
				 "value='".$_POST['username']."'";}?>/><br/><br/></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input id="password" type="password" name="pass" maxlength="100"/></td>
			</tr>
			<tr>
				<input type="submit" name="login" value="Login"/>
			</tr>
		</table>
		</form>
	</div>
	
	<div id="new_user" style="display:none">
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
		<table>
			<!- dynamic post variables in case the user gets error, it will fill in the fields with previous data>		
			<tr>
				<td>Email(required):</td>
				<td><input id="username"  type="text" name="username" maxlength="25" <?php if(isset($_POST['username'])){echo
				 "value='".$_POST['username']."'";}?>/><br/><br/></td>
			</tr>
			<tr>
				<td>First Name:</td>
				<td><input id="firstName"  type="text" name="firstName" maxlength="20" <?php if(isset($_POST['firstName'])){echo
				 "value='".$_POST['firstName']."'";}?>/><br/><br/></td>
			</tr>
			<tr>
				<td>Last Name:</td>
				<td><input id="lastName" type="text" name="lastName" maxlength="20" <?php if(isset($_POST['lastName'])){echo "value='".
				$_POST['lastName']."'";}?>/></td>
			</tr>
			<tr>
				<td>Street:</td>
				<td><input id="street"  type="text" name="street" maxlength="25" <?php if(isset($_POST['street'])){echo "value='".
				$_POST['street']."'";}?>/><br/><br/></td>
			</tr>
			<tr>
				<td>City:</td>
				<td><input id="city" type="text" name="city" maxlength="25" <?php if(isset($_POST['city'])){echo "value='".
				$_POST['city']."'";}?>/></td>
			</tr>
			<tr>
				<td>State:</td>
				<td><input id="state"  type="text" name="state" maxlength="2" <?php if(isset($_POST['state'])){echo "value='".
				$_POST['state']."'";}?>/><br/><br/></td>
			</tr>
			<tr>
				<td>Zip:</td>
				<td><input id="zip" type="text" name="zip" maxlength="5" <?php if(isset($_POST['zip'])){echo "value='".
				$_POST['zip']."'";}?>/></td>
			</tr>
			<tr>
				<td>Phone:</td>
				<td><input id="phone"  type="text" name="phone" maxlength="25" <?php if(isset($_POST['phone'])){echo "value='".
				$_POST['phone']."'";}?>/><br/><br/></td>
			</tr>
			<tr>
				<td>Interests:</td>
				<td><input id="interests" type="text" name="interests" maxlength="4000" <?php if(isset($_POST['interests'])){echo "value='".$_POST['interests']."'";}?>/></td>
			</tr>
			<tr>
				<td>Activities:</td>
				<?php $activities = mysql_query("select * from ACTIVITIES");
					while($activities1 = mysql_fetch_array($activities)){
						echo "<td><input id='activities'  type='checkbox' name='activities' value=.".
						$activities1['ACTIVITY_NAME']."' /><br/></td>";
					}?>
			</tr>
			<tr>
				<td>Password(required):</td>
				<td><input id="password" type="password" name="password" maxlength="100"/></td>
			</tr>
			<tr>
				<td>Confirm Password(required):</td>
				<td><input id="confirm" type="password" name="confirm" maxlength="100"/></td>
			</tr>
			<tr>
				<input type="submit" name="register" value="Get ConnActed!"/>
			</tr>
		</table>
		</form>
	</div>
	
</center>
 <?php 
 } 
 ?>
