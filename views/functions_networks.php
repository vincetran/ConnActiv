<?

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


?>