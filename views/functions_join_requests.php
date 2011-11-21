<?

/* I'm working on this stuff but wanted to push up in case someone
 * wanted to modify the requests page layout. -Kim
 */


function joinRequest(){
	echo 'testing';

	$id = getUserID();
	/*
						$userID = $post[1];
						$location = $post[2];
						$startTime = $post[3];
						$message = $post[4];
						$endTime = $post[5];
						$activityID = $post[6];
						$networkID = $post[7];
						$isPrivate = $post[8];
	*/
	
	$query = "INSERT INTO connaction_requests".
	" (from_user, to_user, connaction_ID, message, approved)".
	" VALUES(".$id.", '".$_POST['$userID']."', '".$_POST['connactionID']."', NULL, NULL)";
	$insert = mysql_query($query) or die(mysql_error());	
	header("Location: ../index.html");
}

/*


	//insert information into users tables.
	$query = "Insert into users(user_id, email,first_Name, last_Name, Street, city, state, zip, phone, interests, password) 
	values(".$userid2.",'".$_POST['username']."','".$_POST['firstName']."','".$_POST['lastName']."','".$_POST['street']."','".$_POST['city']."','".$_POST['state']."','".$_POST['zip']."','".$_POST['phone']."','".$_POST['interests']."','".md5($_POST['password'])."')";
	$insert = mysql_query($query) or die(mysql_error());
	
	*/



?>