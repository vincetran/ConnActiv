<?

function joinRequest(){
	//This insert a join request into the datbase
	$from_user = getUserID();
	$to_user = $_POST['postingUserID'];
	$connactionID = $_POST['connactionID'];
	$message = $_POST['message'];
	
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
