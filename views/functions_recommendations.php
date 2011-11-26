<? //FAVORITES and REVIEWS //

/*
*
** Favorites (Bookmarks)
*
*/

function getFavorites(){

	$id = getUserID();
	$query = "SELECT networks.area, activities.activity_name FROM favorites, networks, activities, unique_networks WHERE user_id = ".$id.""
					." AND favorites.unique_network_id = unique_networks.unique_network_id"
					." AND unique_networks.activity_id = activities.activity_id"
					." AND unique_networks.network_id = networks.network_id";
	$result = mysql_query($query) or die(mysql_error());
	$favs = array();
	while($row = mysql_fetch_array($result)){
		$favs[] = $row['area']. " ". $row['activity_name'];
	}
	return $favs;
}


function favoriteNetwork($unique_id) {
	$id = getUserID();
	$query = "INSERT IGNORE INTO favorites VALUES($id, $unique_id)";
	$insert = mysql_query($query) or die(mysql_error());
}


/*
*
** Reviews
*
*/

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
	
	return $reviews;
}

/*
*
** Work in progress - Kim
*
*/

function getUpcoming($network_id, $activity_id) {
//Return the number of notifications for a certain unique network ($unique) since the user's last login
		
	$upcoming = 0;
	$connactions = array();
		
	$query = "SELECT * FROM connactions"
	." WHERE network_id = $network_id AND activity_id = $activity_id";
	
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		if( $row['start_time'] > currDate()) {
			$notifications++;
		}
	}//end while
		
	return $upcoming;
}



?>