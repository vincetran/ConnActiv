<? // Functions in this file for NETWORKS and SKILL LEVELS //

/*
*
** Networks
*
*/

function getAllNetworkNames() {
	
	$networks = array();
	$query = "SELECT * FROM networks";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$networks[] = $row['AREA'];
	}
	return $networks;
}

function getAllUniqueNetworks() {
	// returns row(unique_network_id, area, state, activity_name).
	$unique = array();
	$query = "SELECT unique_networks.unique_network_id, networks.area, networks.state, activities.activity_name"
	." FROM unique_networks, activities, networks"
	." WHERE unique_networks.network_id = networks.network_id"
	." AND unique_networks.activity_id = activities.activity_id"
	." ORDER BY unique_networks.unique_network_id";
	
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$unique[] = $row;
	}
	return $unique;
}

function getAllNetworkIDs() {
	$networks = array();
	$query = "SELECT * FROM networks";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$networks[] = $row['NETWORK_ID'];
	}
	return $networks;
}

function forceSubscribe($id, $unique_id){
//used in registering, since we can't call getUserID() at registration time (cookies not set)
	$query = "INSERT INTO user_networks(USER_ID, UNIQUE_NETWORK_ID) VALUES($id, $unique_id)";
	$result = mysql_query($query) or die(mysql_error());
	$act_id = forceGetActivityID($id, $unique_id);
	addUserActivity($id, $act_id);
}

function subscribeNetwork($unique_id) {
	$id = getUserID();
	$query = "INSERT IGNORE INTO user_networks(USER_ID, UNIQUE_NETWORK_ID) VALUES($id, $unique_id)";
	$result = mysql_query($query) or die(mysql_error());
	// newly-subscribed unique networks need to have by default "NULL" for the user's skill preferences.
	$act_id = getActivityIDFromUnique($unique_id);
	addUserActivity($id, $act_id);
}

function unsubscribeNetworks($unique_id) {
	$id = getUserID();
	$query = "DELETE FROM user_networks WHERE user_id = $id AND unique_network_id = $unique_id";
	// TODO: When we need to remove the activity from the user's skill preferences.
	$delete = mysql_query($query) or die(mysql_error());
	// Also delete from favorites
	$query = "DELETE FROM favorites WHERE user_id = $id AND unique_network_id = $unique_id";
	$delete = mysql_query($query) or die(mysql_error());
}

function getActivityNameFromUnique($unique_id){
//TODO (Kim) - does this actually work?
	$query = "SELECT activities.activity_name FROM unique_networks, activities"
	." WHERE unique_networks.activity_id = activities.activity_id AND unique_networks.unique_network_id = $unique_id";
	$result = mysql_query($query) or die(mysql_error());
	$name = mysql_fetch_array($result);
	return $name[0];
}

function forceGetActivityID($user_id, $unique_id) {
//used during registration since cookies aren't set (can't call getUserID())

	$query = "SELECT activities.activity_id FROM unique_networks, activities, user_networks"
	." WHERE unique_networks.activity_id = activities.activity_id"
	." AND unique_networks.unique_network_id = $unique_id"
	." AND unique_networks.unique_network_id = user_networks.unique_network_id "
	." AND user_networks.user_id = $user_id";
	
	$result = mysql_query($query) or die(mysql_error());
	$id = mysql_fetch_array($result);
	return $id[0];
}

function getNetworkIDFromUnique($unique_id){

	$user_id = getUserID();

	$query = "SELECT networks.network_id FROM unique_networks, networks, user_networks"
	." WHERE unique_networks.network_id = networks.network_id"
	." AND unique_networks.unique_network_id = $unique_id"
	." AND unique_networks.unique_network_id = user_networks.unique_network_id "
	." AND user_networks.user_id = $user_id";
	
	$result = mysql_query($query) or die(mysql_error());
	$id = mysql_fetch_array($result);
	return $id[0];
}

function getActivityIDFromUnique($unique_id){

	$user_id = getUserID();

	$query = "SELECT activities.activity_id FROM unique_networks, activities, user_networks"
	." WHERE unique_networks.activity_id = activities.activity_id"
	." AND unique_networks.unique_network_id = $unique_id"
	." AND unique_networks.unique_network_id = user_networks.unique_network_id "
	." AND user_networks.user_id = $user_id";
	
	$result = mysql_query($query) or die(mysql_error());
	$id = mysql_fetch_array($result);
	return $id[0];
}

function getUserUniqueNetworks() {
// returns unique_network_id=row[0], area=row[1], state=row[2], activity_name=row[3]
	$id = getUserID();
	$query = "SELECT unique_networks.unique_network_id, networks.area, networks.state, activities.activity_name"
	." FROM user_networks, unique_networks, activities, networks"
	." WHERE unique_networks.network_id = networks.network_id"
	." AND unique_networks.unique_network_id = user_networks.unique_network_id"
	." AND user_networks.user_id = $id"
	." AND unique_networks.activity_id = activities.activity_id"
	." ORDER BY unique_networks.unique_network_id";
	
	$n = array();
	$result=mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$n[] = $row;
	}
	return $n;
}

/*
*
** Skill levels
*
*/

	function getUserActivityLevels(){
	
	$userID = getUserID();
	
	$query = "SELECT DISTINCT activities.activity_name, user_activities.preferred, user_activities.low_level, user_activities.high_level, user_activities.own_level"
	." FROM user_activities, activities WHERE user_activities.user_id = $userID AND user_activities.activity_id = activities.activity_id GROUP BY activities.activity_name";
	$levels = array();
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$levels[] = $row;
	}
	return $levels;
	
	}
	
	function addUserNetwork($userid, $uniqueID){
		$insert = mysql_query("INSERT INTO user_networks values(".$userid.",".$uniqueID.")") or die(mysql_error());
		return $insert;
	}

	function addUniqueNetwork($networkID, $activityID){
		$insertUN = mysql_query("INSERT INTO unique_networks VALUES('', '".$networkID."', '".$activityID."')") or die(mysql_error());
		$query = mysql_query("select max(unique_network_id) from unique_networks");
		$result = mysql_fetch_array($query);
		return $result[0];
	}	
	
	function addNetwork($area, $state){
		$insert = mysql_query("INSERT INTO networks(AREA, STATE) VALUES('$area', '$state')") or die(mysql_error());
		$query = mysql_query("select max(network_id) from networks");
		$result = mysql_fetch_array($query);
		return $result[0];
	}
	
	function networkExists($area, $state) {
		$query = "SELECT count(*) FROM networks WHERE area = '".$area."' AND state = '".$state."'";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) > 1) return true;
		else return false;
	}
	
	function activityExists($act) {
		$query = "SELECT count(activity_id) FROM activities WHERE activity_name = '$act'";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) > 1) return true;
		else return false;
	}
	
	function createUniqueNetwork($area, $state, $activity) {
		//first, check if the user's inputted activity is already in the db
		if (activityExists($activity)) $act_ID = getActivityID($activity);
		else $act_ID = addActivity($activity);
		if (networkExists($area, $state)) $net_ID = getNetworkWithStateID($area, $state);
		else $net_ID = addNetworkWithState($area, $state);
		
		return addUniqueNetwork($net_ID, $act_ID);		
	}
	
	function createAndSubscribeNetwork($area, $state, $activity) {
	//based on user-inputted text, create the network he/she is looking for and subscribe.
		$id = createUniqueNetwork($area, $state, $activity);
		$user_id = getUserID();
		subscribeNetwork($id);
	}
	
	function forceCreateAndSubscribeNetwork($user, $area, $state, $activity) {
	//the user is registering. use the user id passed in.
		$id = createUniqueNetwork($area, $state, $activity);
		forceSubscribe($user, $id);
	}
	
	function addActivity($name) {
		$query = "INSERT INTO activities(ACTIVITY_ID, ACTIVITY_NAME) VALUES('', '".$name."')";
		$insert = mysql_query($query) or die(mysql_error());
		return getActivityID($name); // return the ID of our activity
	}
	
	function addNetworkWithState($area, $state) {
		$query = "INSERT INTO networks VALUES('', '".$area."', '".$state."')";
		$insert = mysql_query($query) or die(mysql_error());
		return getNetworkWithStateID($area, $state); // return the ID of our newly-added network
	}
	
	function getNetworkWithStateID($area, $state) {
		$query = "SELECT network_id FROM networks WHERE area = '".$area."' AND state = '".$state."'";
		$result = mysql_query($query) or die(mysql_error());
		$id = mysql_fetch_array($result);
		return $id[0];
	}

?>
