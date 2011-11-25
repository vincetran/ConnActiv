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
	//It's important that these stayed ordered by unique_network_ID in order to correspond at $i to partner function,
	// getAllUniqueNetworkIDs.
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

function subscribeNetworks($unique_id) {
	$id = getUserID();
	$query = "INSERT IGNORE INTO user_networks(USER_ID, UNIQUE_NETWORK_ID) VALUES($id, $unique_id)";
	// TODO (Kim) : newly-subscribed unique networks need to have by default "NULL" for the user's skill preferences.
	//$query2 = "INSERT INTO user_activities VALUES($id, $unique_id, 'NULL', 'NULL', 'NULL', 'NULL')";
	$insert = mysql_query($query) or die(mysql_error());
	//$insert2 = mysql_query($query2) or die(mysql_error());
	header("Location: ../index.html");
}

function unsubscribeNetworks($unique_id) {
	$id = getUserID();
	$query = "DELETE FROM user_networks WHERE user_id = $id AND unique_network_id = $unique_id";
	// TODO: When we need to remove the activity from the user's skill preferences.
	$delete = mysql_query($query) or die(mysql_error());
	header("Location: ../index.html");
}

function getUserUniqueNetworks() {
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
	." FROM user_activities, activities"
	." WHERE user_id = $userID"
	." GROUP BY activities.activity_name";
	$levels = array();
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$levels[] = $row;
	}
	return $levels;
	
	}


?>