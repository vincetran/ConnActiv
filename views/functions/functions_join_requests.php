<?

/* 
*
*** MESSAGES
*
* void message()
* void eventMessage($from, $event_id) 
* 
*** JOIN REQUESTS
*
* void joinRequest()
* int getApproval($connactionID, $from_user)
* array getIncRequests($userID)
* array getPendingRequests($userID)
*
*** FRIEND REQUESTS
*
* array getIncFriendRequests($userID)
* array getPendingFriendRequests($userID)
* bool isFriend($userID)
* bool requestIsActive($userid)
* void acceptRequest($reqID)
* void denyRequest($reqID)
** -----------------------------------*/


/* MESSAGES */

function message() {
	$query = "INSERT INTO messages VALUES(".getUserID().", ".$_POST['reply'][3].", '".str_replace("'", "''", $_POST['reply'][0])."', '".str_replace("'", "''", $_POST['reply'][1])."', now())";	
	mysql_query($query);	
}

function eventMessage($from, $event_id) { // goes to connactiv admin, always user_id 1
	//messages(from_user, to_user, subject, body, date)
	$subj = "New Event";
	$body = "Event $event_id is awaiting approval.";
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
	if(isset($_POST['releaseEmail'])){
		$releaseEmail = $_POST['releaseEmail'];
	}
	else{
		$releaseEmail = "off";
	}
	if(isset($_POST['releasePhone'])){
		$releasePhone = $_POST['releasePhone'];
	}
	else{
		$releasePhone = "off";
	}
	$body = '';
	if($releasePhone != "off" && $releaseEmail != "off"){
		$user = getDatabaseInfo("users", "user_id", getUserID());
		if($releaseEmail == "on"){
			$body .= "Email: ".$user['EMAIL']."\n";
		}
		if($releasePhone == "on"){
			$body .= "Phone: ".$user['PHONE']."\n";
		}

		$query = "insert into messages values (".getUserID().", ".$to_user.", 'Contact info', '".$body."', now())";
		
		mysql_query($query);
	}
	$query = sprintf("INSERT INTO connaction_requests (from_user, to_user, connaction_ID, message) values(%s,%s,%s,'%s')", $from_user, $to_user, $connactionID, $message);
	$insert = mysql_query($query) or die(mysql_error());
	echo "<div class='notice'>ConnAction request sent!</div>";
	
}
function getApproval($connactionID, $from_user){
	/*This checks the approval of a connaction
	* -1 means pending
	* 0 means the join request is not sent yet
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
function getHiddenRequestsForFrom($userID){
	//This function returns an array of Hidden request where user_id is the from user
	$hiddenRequests = array();
	$result = mysql_query("SELECT * FROM connaction_requests WHERE from_user = '$userID' AND hidden_for_from = 1")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$hiddenRequests[] = $info;
	}
	return $hiddenRequests;
}
function getHiddenRequestsForTo($userID){
	//This function returns an array of Hidden request where user_id is the to user
	$hiddenRequests = array();
	$result = mysql_query("SELECT * FROM connaction_requests WHERE to_user = '$userID' AND hidden_for_to = 1")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$hiddenRequests[] = $info;
	}
	return $hiddenRequests;
}
function getIncFriendRequests($userID){
	//This function returns an array of incoming requests
	$incRequests = array();
	$result = mysql_query("SELECT * FROM friend_requests WHERE to_user = ".$userID." and is_active = -1")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$incRequests[] = $info;
	}
	return $incRequests;
}
function getPendingFriendRequests($userID){
	//This function returns an array of incoming requests
	$incRequests = array();
	$result = mysql_query("SELECT * FROM friend_requests WHERE from_user = ".$userID." and is_active = -1")or die(mysql_error()); //returns true if you do not assign

	while($info = mysql_fetch_array($result)){
		$incRequests[] = $info;
	}
	return $incRequests;
}

function isFriend($userID){
	$query = "select * from friends where ((user1 = ".getUserID()." and user2 = ".$userID.") or (user1 = ".$userID." and user2 = ".getUserID()."))";
	$result = mysql_query($query);
	if(mysql_num_rows($result) != 0){return true;}
	else{return false;}
}
function requestIsActive($userid){
	$query = "select * from friend_requests where ((from_user = ".getUserID()." and to_user = ".$userid.") or (from_user = ".$userid." and to_user = ".getUserID().")) and is_active = -1";
	$result = mysql_query($query);
	if(mysql_num_rows($result) != 0){return true;}
	else{return false;}
}

function acceptRequest($reqID){
	//This accepts the connaction request
	$fromUser = strtok($reqID, " ");
	$connactionID = strtok(" ");
	
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("UPDATE connaction_requests SET APPROVED = 1 WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	mysql_query("insert into messages values(1, ".$fromUser.", 'Connaction Request', '".getUserName(getUserID())."' has accepted your request to join ', now())");
	$query = sprintf("INSERT INTO connaction_attending(USER_ID, CONNACTION_ID) values('%s', '%s')", $fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	
}
function acceptFriendRequest($reqID){
	//This accepts the friend request
	$fromUser = strtok($reqID, " ");
	$toUser = strtok(" ");
	echo $from_user."   ". $to_user;
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("UPDATE friend_requests SET IS_ACTIVE = 1 WHERE FROM_USER = '%s' AND TO_USER = '%s'",$fromUser, $toUser);
	$update = mysql_query($query) or die(mysql_error());
	mysql_query("insert into messages values(1, ".$fromUser.", 'Friend Request', '".getUserName(getUserID())."' has accepted your friend request ', now())");
	$query = sprintf("INSERT INTO friends(USER1, USER2) values('%s', '%s') ", $fromUser, $toUser);
	$update = mysql_query($query) or die(mysql_error());
	
}
function denyRequest($reqID){
	$fromUser = strtok($reqID, " ");
	$connactionID = strtok(" ");
	
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("UPDATE connaction_requests SET APPROVED = 2 WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	mysql_query("insert into messages values(1, ".$fromUser.", 'Connaction Request', '".getUserName(getUserID())."' has denied your request to join ', now())");
	
	//TODO
	//If we allow the user to change the status of a request we must then remove the user
	//from the connaction_attending table.
	
}
function denyFriendRequest($reqID){
	$fromUser = strtok($reqID, " ");
	$toUser = strtok(" ");
	
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("Delete from friend_requests WHERE FROM_USER = '%s' AND TO_USER = '%s'",$fromUser, $toUser);
	$update = mysql_query($query) or die(mysql_error());
	mysql_query("insert into messages values(1, ".$fromUser.", 'Friend Request', '".getUserName(getUserID())."' has denied your friend request ', now())");
	
	//TODO
	//If we allow the user to change the status of a request we must then remove the user
	//from the connaction_attending table.
	
}
function hideRequestForFrom($reqID){
	//This function will hide a connaction request for the user who sent the request
	$fromUser = strtok($reqID, " ");
	$connactionID = strtok(" ");
	
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("UPDATE connaction_requests SET HIDDEN_FOR_FROM = 1 WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	
}
function hideRequestForTo($reqID){
	//This function will hide a connaction request for the user who recieved the request
	$fromUser = strtok($reqID, " ");
	$connactionID = strtok(" ");
	$approved = strTok(" ");
	
	if($approved != -1){
		$query = sprintf("UPDATE connaction_requests SET HIDDEN_FOR_TO = 1 WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
		$update = mysql_query($query) or die(mysql_error());
	}	
}
function unhideRequestForFrom(){
	//This function will unhide a connaction request for the user who sent the request
	$fromUser = getUserID();
	
	$hiddenRequests = getHiddenRequestsForFrom($fromUser);
	if ($hiddenRequests) {
		
		foreach($hiddenRequests as $incoming){
			$connactionID = $incoming[2];
			$query = sprintf("UPDATE connaction_requests SET HIDDEN_FOR_FROM = 0 WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
			$update = mysql_query($query) or die(mysql_error());
		}
	}
}
function unhideRequestForTo(){
	//This function will unhide a connaction request for the user who recieved the request
	$toUser = getUserID();
	$hiddenRequests = getHiddenRequestsForTo($toUser);
	if ($hiddenRequests) {
		
		foreach($hiddenRequests as $incoming){
			$connactionID = $incoming[2];
			$query = sprintf("UPDATE connaction_requests SET HIDDEN_FOR_TO = 0 WHERE TO_USER = '%s' AND CONNACTION_ID = '%s'",$toUser, $connactionID);
			$update = mysql_query($query) or die(mysql_error());
		}
	}
}
function deleteRequest($reqID){
	$fromUser = strtok($reqID, " ");
	$connactionID = strtok(" ");
	
	//echo "Accept: ID: ".$fromUser." ConID: ".$connactionID;
	$query = sprintf("DELETE FROM connaction_requests WHERE FROM_USER = '%s' AND CONNACTION_ID = '%s'",$fromUser, $connactionID);
	$update = mysql_query($query) or die(mysql_error());
	
}

?>
