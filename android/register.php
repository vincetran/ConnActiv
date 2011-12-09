<?php
	mysql_connect("connactiv.db", "connactiv_site", "connactiv123") or die(mysql_error()); 
	mysql_select_db("connactiv") or die(mysql_error()); 

	include("../views/functions/config.php");
	
	if(!$_POST['username'] || !$_POST['password'] || !$_POST['confirm']) {
		echo 'You did not fill one of the required fields: email, password, or confirm password.';
	}
	//check to make sure the email is not already registered.
	$check = mysql_query("SELECT * FROM users WHERE email = '".$_POST['username']."'")or die(mysql_error());
	$check2 = mysql_num_rows($check);
	
	//if email has not been registered before
	if($check2 == 0){
		//check to make sure the password was confirmed			
		if(strcmp($_POST['password'], $_POST['confirm'])==0){			
			//check to make sure the password is longer than 6 characters, may want to use regexp to improve
			//security
						
			//insert information into users tables.
			$query = "Insert into users(email,first_Name, last_Name, city, state, zip, phone, interests, profile_pic, password) values('".mysql_real_escape_string($_POST['username'])."','".mysql_real_escape_string($_POST['firstName'])."','".mysql_real_escape_string($_POST['lastName'])."','".mysql_real_escape_string($_POST['city'])."','".mysql_real_escape_string($_POST['state'])."','".mysql_real_escape_string($_POST['zip'])."','".mysql_real_escape_string($_POST['phone'])."','".mysql_real_escape_string($_POST['interests'])."','../public/images/avatar.png','".md5($_POST['password'])."')";
			$insert = mysql_query($query) or die(mysql_error());
			$id = mysql_query("select max(user_id) from users");
			$id1 = mysql_fetch_array($id);
			$userid2 = $id1[0];
		
			if ($_POST['city'] && $_POST['state']) {
				//If the network doesn't already exist, add it to the networks table.
				$query = sprintf("SELECT network_id FROM networks WHERE area = '%s' AND state = '%s'", $_POST['city'], $_POST['state']);
				$checkNetwork = mysql_query($query) or die(mysql_error());				
				$checkNetwork1 = mysql_fetch_array($checkNetwork);
				$networkid = (int)$checkNetwork1[0];
				if(mysql_num_rows($checkNetwork) == 0){
					$networkid = addNetworkWithState($_POST['city'], $_POST['state']);
				}	
			} //end if $city and $state
			
			$info = getDatabaseInfo("users", "email", $_POST['username']);
				echo $info['USER_ID'];
		}	
		//if the passwords do not match ask them to enter the information again
		else{ die("The passwords do not match, please re-enter your information");}
	}
	//if the email is already registered then display message
	else{
		echo 'This email has already been registered.';
	}
?>
