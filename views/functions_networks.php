<?

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

function getAllNetworkIDs() {
	$networks = array();
	$query = "SELECT * FROM networks";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$networks[] = $row['NETWORK_ID'];
	}
	return $networks;
}

/*
*
** Skill levels
*
*/

	function getUserActivityLevels(){
	
	$userID = getUserID();
	
	$query = "SELECT *"
	." FROM user_activities, activities"
	." WHERE user_id = $userID"
	." ORDER BY activities.activity_name ASC";
	$levels = array();
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$levels[] = "<td>".$row['ACTIVITY_NAME']."</td><td>".$row['PREFERRED']."</td><td>".$row['LOW_LEVEL']."-".$row['HIGH_LEVEL']."</td><td>".$row['OWN_LEVEL']."</td>";
	}
	return $levels;
	
	}


?>