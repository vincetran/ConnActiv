<?

/* Actually, Rob this is listed as your action item. Feel free to take it away :)
 * What I've done here just links to the "Join" button in the user's ConnAction stream (home.php)
 * And also I broke your post connaction business, probably because I'm unsure how to link a form
 * to a specific function. So yeahhhh oops. Let me know if I can clarify anything else.
 * --Kim
 */


function joinRequest(){
	//This insert a join request into the datbase
	$from_user = getUserID();
	$to_user = $_POST['postingUserID'];
	$connactionID = $_POST['connactionID'];
	$message = $_POST['message'];
	
	$query = sprintf("INSERT INTO connaction_requests (from_user, to_user, connaction_ID, message) values(%s,%s,%s,'%s')", $from_user, $to_user, $connactionID, $message);
	$insert = mysql_query($query) or die(mysql_error());	
	header("Location: ../index.html");
	//echo $query;
	
}
function getApproval($connactionID, $from_user){
	/*This checks the approval of a connaction
	* -1 means pending
	* 0 means the join request is not sent yet, Sorry that is what the database returns when it doesn't exist
	* 1 means approved
	* 2 means denied
	*/
	$status;
	//while($info = getDatabaseInfo("connaction_requests", "connaction_id", $connactionID)){
	//	echo $info['APPROVED'];
	//}
	$resourceID = getResourceIDs2("connaction_requests", "connaction_id", $connactionID, "from_user", $from_user);
	$info = mysql_fetch_array($resourceID);
	$status = $info['APPROVED'];
	
	//echo $status;
	return $status;
}
function getIncRequests($userID){
	//This function returns an array of incoming requests
	$incRequests = array();
	$result = mysql_query("SELECT * FROM connaction_requests WHERE to_user = '$userID' ORDER BY date DESC")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$incRequests[] = $info;
	}
	return $incRequests;
}
function getPendingRequests($userID){
	//This function returns an array of incoming requests
	$pendingRequests = array();
	$result = mysql_query("SELECT * FROM connaction_requests WHERE from_user = '$userID' ORDER BY date DESC")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$pendingRequests[] = $info;
	}
	return $pendingRequests;
}

?>