<?

/* MESSAGES */

	function message() {
		$query = "INSERT INTO messages VALUES(".getUserID().", ".$_POST['reply'][3].", '".$_POST['reply'][0]."', '".$_POST['reply'][1]."', now())";	
		mysql_query($query);	
	}
	
	function eventMessage($from, $event_id) { // goes to connactiv admin, always user_id 1
	//messages(from_user, to_user, subject, body, date)
		$subj = "New Event";
		$body = "Event ID $event_id is awaiting approval.";
		$query = sprintf("INSERT INTO messages VALUES('%s', '1', '%s', '%s', now())", $from, $subj, $body);
		
		mysql_query($query) or die(mysql_error());
	}
	
 /* JOIN REQUESTS */

function joinRequest(){
	//This insert a join request into the datbase
	$from_user = getUserID();
	$to_user = $_POST['postingUserID'];
	$connactionID = $_POST['connactionID'];
	$message = $_POST['message'];
	$releaseEmail = $_POST['releaseEmail'];
	$releasePhone = $_POST['releasePhone'];
	
	$user = getDatabaseInfo("users", "user_id", getUserID());
	if($releaseEmail == "on"){
		$body .= "Email: ".$user['EMAIL']."\n";
	}
	if($releasePhone == "on"){
		$body .= "Phone: ".$user['PHONE']."\n";
	}

	$query = "insert into messages values (".getUserID().", ".$to_user.", 'Contact information for ".getName()."', '".$body."', now())";
				
	mysql_query($query);
	
	$query = sprintf("INSERT INTO connaction_requests (from_user, to_user, connaction_ID, message) values(%s,%s,%s,'%s')", $from_user, $to_user, $connactionID, $message);
	$insert = mysql_query($query) or die(mysql_error());
	echo "<div class='notice'>ConnAction request sent!</div>";
	
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
	$result = mysql_query("SELECT * FROM connaction_requests WHERE to_user = '$userID' ")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$incRequests[] = $info;
	}
	return $incRequests;
}
function getPendingRequests($userID){
	//This function returns an array of incoming requests
	$pendingRequests = array();
	$result = mysql_query("SELECT * FROM connaction_requests WHERE from_user = '$userID' ")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$pendingRequests[] = $info;
	}
	return $pendingRequests;
}
function getIncFriendRequests($userID){
	//This function returns an array of incoming requests
	$incRequests = array();
	$result = mysql_query("SELECT * FROM friend_requests WHERE to_user = ".$userID." and is_active = 1")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$incRequests[] = $info;
	}
	return $incRequests;
}
function getPendingFriendRequests($userID){
	//This function returns an array of incoming requests
	$incRequests = array();
	$result = mysql_query("SELECT * FROM friend_requests WHERE from_user = ".$userID." and is_active = 1")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$incRequests[] = $info;
	}
	return $incRequests;
}

function isFriend($userID){
	$query = "select * from friends where user_id = ".getUserID()." and friend_id = ".$userID;
	$result = mysql_query($query);
	if(mysql_num_rows($result) != 0){return true;}
	else{return false;}
}
function requestIsActive($userid){
	$query = "select * from friend_requests where (from_user = ".getUserID()." and to_user = ".$userid.") or (from_user = ".$userid." and to_user = ".getUserID().") and is_active = 1";
	$result = mysql_query($query);
	if(mysql_num_rows($result) != 0){return true;}
	else{return false;}
}

function acceptRequest($reqID){
	$fromUser = strtok($reqID, " ");
	$connactionID = strtok(" ");
	
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("UPDATE connaction_requests SET APPROVED = 1 WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	mysql_query("insert into messages values(1, ".$fromUser.", 'Connaction Request', '".getUserName(getUserID())."' has accepted your request to join ', now())");
	$query = sprintf("INSERT INTO connaction_attending(USER_ID, CONNACTION_ID) values('%s', '%s')", $fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	
	
}
function denyRequest($reqID){
	$fromUser = strtok($reqID, " ");
	$connactionID = strtok(" ");
	
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("UPDATE connaction_requests SET APPROVED = 2 WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	
	//TODO
	//If we allow the user to change the status of a request we must then remove the user
	//from the connaction_attending table.
	
}

?>
