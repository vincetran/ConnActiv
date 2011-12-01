<? 

/* 
*
*** VIEWING PROFILE
*
*  string getProfile($userID)
*  string getFormattedReviews($review)
* 
*
*** EVENTS
*
*  void postEvent()
*	 array getEventsForUniqueNetwork($unique_id)
*  array getAllWaitingEvents()
*  array getEventsForUniqueNetwork($unique_id)
*	 void approveEvent($event_id)
*  void denyEvent($event_id)
*
*
*** CONNACTIONS
*
*  void postConnaction()
*  array getPastConnactions($userid)
*  array getAllConnactions()
*  array reviewedByUser($connactionid, $userid)
*  array getConnactionsByUnique($unique_id)
*  array getConnactions($n_aID, $option)
*  activity name as string getConnactionActivity($connactionID)
*  string getConnactionNetwork($connactionID)
*  string getConnactionUniqueNetwork($connID)
*  string getConnactionDate($connactionID, $argument)
*  string getConnactionLocation($connactionID)
*
** -----------------------------------*/



/*
*
** Connactions
*
*/


	function getProfile($userID) {
	
		/* Grabbing all the information we want to associate with the user, 
		to be able to click the user's profile and see this in fancybox. 
		Renders in home.php when a user profile is clicked. */
		
	//First, get all the data we want to display as user's profile.
		 $src = getUserPic($userID);
		 $uname = getUserName($userID);
		 $reviewsPos = getReviewCountForUser('positive', $userID);
		 $reviewsNeg = getReviewCountForUser('negative', $userID);
		 $user = getDatabaseInfo("users", "user_id", $userID);
		 $city = $user['CITY'];
		 $state = $user['STATE'];
		 $about = $user['INTERESTS'];
		 $DOB = $user['DOB'];
		 $gender = $user['GENDER'];
	//Then append it all as raw markup for display. 
		 $details = "<div class='view_profile greyBorder'>"; // must be the first item appended to $details

		 $details .= "<img src=".$src." /><h2>$uname</h2>";
		 
		 $details.= "<table class='simple_table'>";
		 
		 if($about != '') $details .= "<tr><th>About</th><td>$about</td></tr>";
		 if ($city != '') $details .= "<tr><th>City</th><td>$city</td></tr>";
		 if ($state != '') $details .= "<tr><th>State</th><td>$state</td></tr>";
		 if($DOB != '') $details .= "<tr><th>Birthday</th><td>$DOB</td></tr>";
		 if($gender != '') $details .= "<tr><th>Gender</th><td>$gender</td></tr>";
		 $details .= "<tr><th>Positive reviews</th><td>$reviewsPos</td>";
		 $details .= "<tr><th>Negative reviews</th><td>$reviewsNeg</td>";
		 $details .= "</table>";
		 
	/*** Add other details for the user here */ 
		$review = getAllReviews($userID);
		$details .= getFormattedReviews($review);
			if(isFriend($userID)){
				$details .= "<br/>Send Message<td><form action = ".$_SERVER['PHP_SELF']." method = 'post'><input type = 'text' placeholder = 'Subject' name = 'reply[]'><input type= 'text' placeholder = 'Reply Here' name = 'reply[] /'><input type = 'submit' name = 'reply[]' value = 'Reply'/><input type = 'hidden' name = 'reply[]' value = '".$userID."'/></form>";
}
			elseif(requestIsActive($userID)){$details .= "<br/>Friend Request Pending";}
			elseif($userID != getUserID()){
				$details .= "<br/>Request to be Friends<td><form action = ".$_SERVER['PHP_SELF']." method = 'post'><input type= 'text' placeholder = 'Write a message' name = 'friend[]' /><input type = 'submit' name = 'friend[]' value = 'Submit'/><input type = 'hidden' name = 'friend[]' value = '".$userID."'/></form>";
			}
			else{$details .= "<br/>";}
		
		 $details .= "</div>"; // must be the final item appended to $details

		 return $details;
	}
		
	function getFormattedReviews($review) {
	
		$details = "";
	
		if(sizeof($review) > 0){		
			$details .= "<table id='selfReviews' class='alternating regular_table'>";
			$details .= "<thead><th>Reviewed</th><th>From</th><th>Connaction</th><th>Rating</th><th>Review</th></tr></thead>";
			$details .= "<tbody>";
			foreach($review as $rev){
				if($rev['IS_POSITIVE'] == 1){$posNeg = "<img src='../public/images/thumbs_up.png' height='30'/>";}
				else{$posNeg = "<img  src='../public/images/thumbs_down.png' height='30'/>";}

				if($rev['IS_ANONYMOUS'] == 1){$from = "Anonymous";}
				else{$from = getUserName($rev['FROM_USER']);}
			
				$connactInfo = getConnactionActivity($rev['CONNACTION_ID']);
				
				//getunique network id from connaction id
				$unique = getUniqueFromConnaction($rev['CONNACTION_ID']);
				$name = prettifyName($unique);
				$date = $rev['REVIEW_DATE'];
				
				$loc = getConnactionLocation($rev['CONNACTION_ID']);
				$date = getConnactionDate($rev['CONNACTION_ID'], "START");
				$connactInfo = '';
				if ($loc) $connactInfo .= $loc;
				if ($date) $connactInfo .= " on $date";
			
				$details .= "<tr><td>$date</td>";
				$details .= "<td>$from</td>";
				$details .= "<td>$name<br/>$connactInfo</td>";
				$details .= "<td>$posNeg</td>";
				$details .= "<td>".$rev['REVIEW']."</td></tr>";
			} //end foreach
			$details .= "</tbody></table>";
		} //end has reviews	
		
		return $details;
	
	}
	
	function getUniqueFromConnaction($id) {
		$events = array();
		$query = "SELECT unique_networks.unique_network_id FROM unique_networks, connactions"
		." WHERE connactions.connaction_id = unique_networks.unique_network_id";
		
		$result = mysql_query($query) or die(mysql_error());	
		$row = mysql_fetch_array($result);
		return $row[0];	
	}

	
/** 
* EVENTS
*
*
*/
	
	function postEvent() {
	// Events(event_id, user_id, activity_id, network_id, message, start, end, location, recurrence, approved //
	
		$user = getUserID();
		$start = myDateParser($_POST['eventStartDate']);
		$end = myDateParser($_POST['eventEndDate']);
		$today = date("Y-m-d");
		$startTime = $start." ".$_POST['eventStartHour'].":".$_POST['eventStartMin'].":00";
		$endTime = $end." ".$_POST['eventEndHour'].":".$_POST['eventEndMin'].":00";
		$act_id = $_POST['eventActivity'];
		$net_id = $_POST['eventNetwork'];
		$loc = $_POST['eventLoc'];
		$msg = $_POST['eventMsg'];
		
		if (!$user || !$startTime || !$endTime || $act_id<0 || $net_id<0 || !$loc || !$msg) {
			echo "<div class='error'>Please fill in all event information.</div>";
		} else {
			$query = sprintf("INSERT INTO events(USER_ID, ACTIVITY_ID, NETWORK_ID, START, END, MESSAGE, LOCATION, RECURRENCE, APPROVED, REQUEST_DATE)
				VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', 0, -1, now())", $user, $act_id, $net_id, $startTime, $endTime, $msg, $loc); //waiting for admin approval
			$insert = mysql_query($query) or die(mysql_error());
			$new_event = mysql_insert_id();
			
			eventMessage($user, $new_event); //alert admin		
			
			echo "<div class='notice'>Event request sent! We'll keep you informed of its approval.</div>";
		}
		
	}
	
	
	function getAllWaitingEvents() {
	// For display in admin requests for approval. Events awaiting approval have approved=-1 by default.
	
		$events = array();
		$query = "SELECT * FROM events WHERE approved='-1'";
		
		$result = mysql_query($query) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
				$events[] = $row;
			}
		return $events;
	}
	
	function getEventsForUniqueNetwork($unique_id) {
		// Events(event_id, user_id, activity_id, network_id, message, start, end, location, recurrence, approved).
		// Events that have been approved have approved=1.
	
		$events = array();
		
		$act_id = getActivityIDFromUnique($unique_id);
		$net_id = getNetworkIDFromUnique($unique_id);
		$query = "SELECT * FROM events WHERE approved='1' AND activity_id = '".$act_id."' AND network_id = '".$net_id."'";
		
		$result = mysql_query($query) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
				$events[] = $row;
			}
		return $events;
		
		}
		
	function approveEvent($e_id) {
	//$e_id is event id
		$query = "UPDATE events SET approved = '1' WHERE event_id = '" .$e_id."'";
		mysql_query($query) or die(mysql_error());
		echo "<div class='notice'>Event(s) approved.</div>";
	}
	
	function denyEvent($e_id) {
	//$e_id is event id
		$query = "UPDATE events SET approved = '0' WHERE event_id = '" .$e_id."'";
		mysql_query($query) or die(mysql_error());
		echo "<div class='notice'>Event(s) denied.</div>";
	}
		
/*
*
*
** end EVENTS */



	function postConnaction(){
	//This function will post the connaction to the database!
	
	if ( (!(isset($_POST['startDate']))) || (!isset($_POST['endDate'])) || (!isset($_POST['activity'])) 
		|| ($_POST['network'] == -1) || ($_POST['location'] == -1) ) {
		echo "<div class='error'>Please fill in all ConnAction data.</div>";
	} else {
	
		$start = myDateParser($_POST['startDate']);
		$end = myDateParser($_POST['endDate']);
		$today = date("Y-m-d");
		$startTime = $start." ".$_POST['startHour'].":".$_POST['startMin'].":00";
		$endTime = $end." ".$_POST['endHour'].":".$_POST['endMin'].":00";
		$getun = "select unique_network_id from unique_networks where activity_id = ".$_POST['activity']." and network_id = ".$_POST['network'];
		
		$stuff = mysql_query($getun);		
		$un = mysql_fetch_array($stuff);
		$unID = $un[0];		
		
		$query = "INSERT INTO connactions(POST_TIME, USER_ID, LOCATION, START_TIME, MESSAGE, END_TIME, UNIQUE_NETWORK_ID, IS_PRIVATE)
			VALUES ('".$today."', '".getUserID()."', '".$_POST['location']."', '".$startTime."', '".$_POST['message']."', '".$endTime."', '".$unID."', '".$_POST['private']."')";
					
		$insert = mysql_query($query) or die(mysql_error());
		echo "<div class='notice'>ConnAction posted!</div>";
	}

}
	
	/*		///This function was replaced by the getConnactions functions
	function getConnactionUsers($n_aID, $option){
		//The option is whether the ID is network_ID or Activity_ID
		//0 = Activity_ID, 1 = network_ID
		//This function returns an array of all users names who posted a connaction
		$connactionUsers = array();
		
		if($option == 0){
			//ID is activity
			$resourceID = getResourceIDs("connactions", "activity_id", $n_aID);
			while($info = mysql_fetch_array($resourceID)){
				$connactionUsers[] = $info["USER_ID"];
			}
			return $connactionUsers;
		}
		else if($option == 1){
			//ID is network
			//print $n_aID;
			$resourceID = getResourceIDs("connactions", "network_id", $n_aID);
			while($info = mysql_fetch_array($resourceID)){
				$connactionUsers[] = $info["USER_ID"];
			}
			return $connactionUsers;
		}
		else{
			return "error";
		}
		
	}*/
	

	function getPastConnactions($userid){
		$pastcon = array();		
		$query = "select c.connaction_id, c.user_id, un.activity_id, c.start_time, c.message from connactions c, connaction_attending ca, unique_networks un where ca.user_id = ".$userid." and c.end_time < now() and c.connaction_id = ca.connaction_id and un.unique_network_id = c.unique_network_id" ;
		$past = mysql_query($query) or die(mysql_error());
		while($info = mysql_fetch_array($past)){
			$pastcon[] = $info;
		}
		return $pastcon;
		
	}


	function getAllConnactions(){
		$userid = getUserID();
		$connactions = "";
	
		$query = "select unique_network_id from user_networks where user_id = ".$userid;
		$result = mysql_query($query);
		while($info = mysql_fetch_array($result)){
			$unique_network_id = $info[0];
			$result1 = mysql_query("select * from connactions where unique_network_id = ".$unique_network_id);
			while($info1 = mysql_fetch_array($result1)){
				$connactions[] = $info1;
			}
			
		}
		return $connactions;
	}
	function reviewedByUser($connactionid, $userid){
		$query = "select * from reviews where from_user = ".$userid." and connaction_id = ".$connactionid;
		$result = mysql_query($query);
		if(mysql_num_rows($result) == 0){return false;}
		else{return true;}
	}
	
	function getConnactionsByUnique($unique_id) {
		$userid = getUserID();
		$connactions = array();
	
		$query = mysql_query("select * from connactions where unique_network_id = ".$unique_id);
		while($row = mysql_fetch_array($query)){
			$connactions[] = $row;
		}
	return $connactions;
	}
	
	function getConnactions($n_aID, $option){
		//The option is whether the ID is network_ID or Activity_ID
		//0 = Activity_ID, 1 = network_ID
		//This function returns an array of all users names who posted a connaction
		$connactionUsers = array();
		
		if($option == 0){
			//ID is activity
			//$resourceID = getResourceIDs("connactions", "activity_id", $n_aID);
			$result = mysql_query("SELECT * FROM connactions WHERE activity_id = '$n_aID' ORDER BY connaction_id DESC")or die(mysql_error()); //returns true if you do not assign

			while($info = mysql_fetch_array($result)){
				$connactionUsers[] = $info;
			}
			return $connactionUsers;
		}
		else if($option == 1){
			//$resourceID = getResourceIDs("connactions", "network_id", $n_aID);
			$getsubscract = "select distinct un.activity_id from user_networks usn, unique_networks un where usn.user_id = ".getUserID()." and un.network_id = ".$n_aID." and usn.unique_network_id = un.unique_network_id";
			$string = "";

			$stuff = mysql_query($getsubscract);		
			while($info = mysql_fetch_array($stuff)){
				$string = $string."'".$info[0]."',";
			}			
			$string = substr($string, 0, strlen($string)-1);

			$getun = "select unique_network_id from unique_networks where network_id = ".$n_aID." and activity_id in(".$string.")";

			$string1 ="";

			$stuff = mysql_query($getun);		
			while($info = mysql_fetch_array($stuff)){
				$string1 = $string1."'".$info[0]."',";
			}
			$string1 = substr($string1, 0, strlen($string1)-1);
			$query = "SELECT * FROM connactions WHERE unique_network_id in (".$string1.") ORDER BY connaction_id DESC";
			
			$result = mysql_query($query)or die(mysql_error()); //returns true if you do not assign

			while($info = mysql_fetch_array($result)){
				$connactionUsers[] = $info;
			}
			return $connactionUsers;
		}
		else{
			return "error";
		}
	}
	function getConnactionActivity($connactionID){
		//This function will return the activity of connaction
		$activityID = getDatabaseInfo("connactions", "connaction_id", $connactionID);
		$act = getDatabaseInfo("unique_networks", "unique_network_id", $activityID['UNIQUE_NETWORK_ID']);
		$activity = getDatabaseInfo("activities", "activity_id", $act['ACTIVITY_ID']);	
		$activityName = $activity['ACTIVITY_NAME'];
		
		return $activityName;
	}
	function getConnactionNetwork($connactionID){
		//This function will return the network of connaction
		$networkID = getDatabaseInfo("connactions", "connaction_id", $connactionID);
		$net = getDatabaseInfo("unique_networks", "unique_network_id", $networkID['UNIQUE_NETWORK_ID']);
		$network = getDatabaseInfo("networks", "network_id", $net['NETWORK_ID']);	
		$networkName = $network['AREA'] .", ". $network['STATE'];
		
		return $networkName;
	}
	
	function getConnactionUniqueNetwork($connID){
	// return as a string the unique network as "<area>, <state> - <activity>"	
		$act = getConnactionActivity($connID);
		$net = getConnactionNetwork($connID);
		
		$whole = $net ." - " . $act;
		return $whole;
	
	}
	
	function getConnactionDate($connactionID, $argument){
		//This function will return the date of connaction
		//Argument should be POST, START or END
		$dateID = getDatabaseInfo("connactions", "connaction_id", $connactionID);	
		$date = $dateID[$argument.'_TIME'];
		$dateParsed = date_parse($date);
		$newDate = $dateParsed["month"].'/'.$dateParsed["day"].'/'.$dateParsed["year"];
		$finalDate =  date('m/d/Y',strtotime($newDate));
		return $newDate;
	}
	function getConnactionDateTime($connactionID, $argument){
		//This function will return the date of connaction
		//Argument should be POST, START or END
		$dateID = getDatabaseInfo("connactions", "connaction_id", $connactionID);	
		$date = $dateID[$argument.'_TIME'];
		$dateParsed = date_parse($date);
		$newDate = $dateParsed["month"].'/'.$dateParsed["day"].'/'.$dateParsed["year"]." ".$dateParsed["hour"].":".$dateParsed["minute"];
		$finalDate =  date('m/d/Y H:i:s',strtotime($newDate));
		return $finalDate;
	}
	function getConnactionLocation($connactionID){
		//This function will return the Location of connaction
		
		$connaction = getDatabaseInfo("connactions", "connaction_id", $connactionID);
		$location = $connaction['LOCATION'];	
		return $location;
	}
	function printArray($array){
		//This function echos the passed in array
		for($i = 0; $i < count($array); $i++){
			echo $array[$i];
		}
	}
	function getCurYear(){
		$today = getdate();
		
		return $today["year"];
	}
	function getCurMonth($condition){
		//This function returns the current month
		// 0 = the word
		// 1 = the number
		$today = getdate();
		
		//return $today;
		if($condition == 0){
			return $today["month"];
		}
		else if($condition == 1){
			return $today["mon"];
		}
		else{
			return -1;
		}
	}
	function getCurDay(){
		//This function returns the current day
		$today = getdate();
		
		return $today["mday"];
	}
	function getCurHour(){
		//This function returns the current hour
		$today = getdate();
		
		return $today["hours"];
	}
	function getCurMin(){
		//This function returns the current hour
		$today = getdate();
		
		return $today["minutes"];
	}
	function getDays($month){
		//This function returns the total days in a month
		//30 sept april june nov
		if($month == 1){
			return 31;
		}
		else if($month == 2){
			return 28;
		}
		else if($month == 3){
			return 31;
		}
		else if($month == 4){
			return 30;
		}
		else if($month == 5){
			return 31;
		}
		else if($month == 6){
			return 30;
		}
		else if($month == 7){
			return 31;
		}
		else if($month == 8){
			return 31;
		}
		else if($month == 9){
			return 31;
		}
		else if($month == 10){
			return 31;
		}
		else if($month == 11){
			return 30;
		}
		else if($month == 12){
			return 31;
		}
		else{
			return -1;
		}
	}


?>
