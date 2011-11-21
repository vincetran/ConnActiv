<?

function getFavorites(){

	$id = getUserID();
	$query = "SELECT networks.area, activities.activity_name FROM favorites, networks, activities WHERE user_id = ".$id.
					" AND favorites.network_id = networks.network_id".
					" AND favorites.activity_id = activities.activity_id";
	$result = mysql_query($query) or die(mysql_error());
	$favs = array();
	while($row = mysql_fetch_array($result)){
		$favs[] = $row['area']. " ". $row['activity_name'];
	}
	return $favs;

}


?>