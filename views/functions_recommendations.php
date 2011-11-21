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

function totalReviews($which) {
//$which tells which reviews to return (positive or negative)

	$id = getUserID();
	
	if ($which == 'positive') {
		$query = "SELECT COUNT(user_id) FROM reviews WHERE reviews.user_id = ".$id." AND reviews.is_positive";
	} else {
		$query = "SELECT COUNT(user_id) FROM reviews WHERE reviews.user_id = ".$id." AND !reviews.is_positive";
	}
	
	$result = mysql_query($query) or die(mysql_error());
	return mysql_num_rows($result) -1;
}


function getReviews($which) {
//$which tells which reviews to return (positive or negative)

	$id = getUserID();
	$reviews = array();
	
	if ($which == 'positive') {
		$query = "SELECT * FROM reviews WHERE reviews.user_id = ".$id." AND reviews.is_positive";
	} else {
		$query = "SELECT * FROM reviews WHERE reviews.user_id = ".$id." AND !reviews.is_positive";
	}
	
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$reviews[] = $row;
	}
}


?>