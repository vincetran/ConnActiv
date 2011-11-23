<?

/* Actually, Rob this is listed as your action item. Feel free to take it away :)
 * What I've done here just links to the "Join" button in the user's ConnAction stream (home.php)
 * And also I broke your post connaction business, probably because I'm unsure how to link a form
 * to a specific function. So yeahhhh oops. Let me know if I can clarify anything else.
 * --Kim
 */


function joinRequest(){

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
	
	
	$query = "INSERT INTO connaction_requests".
	" (from_user, to_user, connaction_ID, message, approved)".
	" VALUES(".$id.", '".$_POST['$userID']."', '".$_POST['connactionID']."', NULL, NULL)";
	$insert = mysql_query($query) or die(mysql_error());	
	header("Location: ../index.html");
	*/
	//echo $_POST['message'];
	header("Location: ../index.html");
	
}


?>