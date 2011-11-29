<? /*-----------------------------------
* Functions for FAVORITES and REVIEWS
*
** array(string) getFavorites()
** array(int) getFavoriteIDs()
** void favoriteNetwork($unique_id)
** int getUniqueNetworkIdByFav($fav_as_string)
** void defavoriteNetwork($unique_id)
** 
** int totalReviews($which)
** array getReviews($which)
* -----------------------------------*/

/*
*
** Favorites (Bookmarks)
*
*/

function getFavorites(){

	$id = getUserID();
	$query = "SELECT networks.area, networks.state, activities.activity_name FROM favorites, networks, activities, unique_networks WHERE user_id = ".$id.""
					." AND favorites.unique_network_id = unique_networks.unique_network_id"
					." AND unique_networks.activity_id = activities.activity_id"
					." AND unique_networks.network_id = networks.network_id";
	$result = mysql_query($query) or die(mysql_error());
	$favs = array();
	while($row = mysql_fetch_array($result)){
		$favs[] = $row['area']. ", ". $row['state']. " - " .$row['activity_name'];
	}
	return $favs;
}

function getFavoritesWithIDs(){
//unique id = 0, area = 1, state = 2, activity = 3

	$id = getUserID();
	$query = "SELECT unique_networks.unique_network_id, networks.area, networks.state, activities.activity_name FROM favorites, networks, activities, unique_networks WHERE user_id = ".$id.""
					." AND favorites.unique_network_id = unique_networks.unique_network_id"
					." AND unique_networks.activity_id = activities.activity_id"
					." AND unique_networks.network_id = networks.network_id";
	$result = mysql_query($query) or die(mysql_error());
	$favs = array();
	while($row = mysql_fetch_array($result)){
		$favs[] = $row;
	}
	return $favs;
}

function getFavoriteIDs(){
//returns array of unique_network_ids based on $user_id
	$id = getUserID();
	$query = "SELECT unique_network_id FROM favorites WHERE user_id = $id";
	$result = mysql_query($query) or die(mysql_error());
	$favIDs = array();
	while($row = mysql_fetch_array($result)){
		$favIDs[] = $row[0];// this is unique_network_id
	}
	return $favIDs;
}


function favoriteNetwork($unique_id) {
	$id = getUserID();
	$query = "INSERT IGNORE INTO favorites VALUES($id, $unique_id)";
	$insert = mysql_query($query) or die(mysql_error());
}

function getUniqueNetworkIdByFav($fav_as_string) {
	//This is kind of a ridiculous hack, but favs come passed in as <area>, <state> - <activity_name>
	$pieces = explode(",", $fav_as_string);
	$area = trim($pieces[0]);
	$pieces2 = explode("-", $pieces[1]);
	$state = trim($pieces2[0]);
	$act= trim($pieces2[1]);

	$query = sprintf("SELECT unique_networks.unique_network_id FROM unique_networks, activities, networks"
	." WHERE networks.area = '%s' AND networks.state = '%s' AND unique_networks.network_id = networks.network_id"
	." AND unique_networks.activity_id = activities.activity_id"
	." AND activities.activity_name = '%s'", $area, $state, $act);
	$result = mysql_query($query) or die(mysql_error());
	$id = mysql_fetch_array($result);
	return $id[0];	
}

function defavoriteNetwork($unique_id) {
	$id = getUserID();
	$query = sprintf("DELETE FROM favorites WHERE user_id = '%s' AND unique_network_id = '%s'", $id, $unique_id);
	$delete = mysql_query($query) or die(mysql_error());	
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
		$query = "SELECT * FROM reviews WHERE user_id = '".$id."' AND is_positive = '1'";
	} else {
		$query = "SELECT * FROM reviews WHERE user_id = '".$id."' AND is_positive = '0'";
	}
	
	$result = mysql_query($query) or die(mysql_error());
	return mysql_num_rows($result);
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

function getAllReviews($userid){
	$reviews = array();
	

		$query = "SELECT * FROM reviews WHERE user_id = ".$userid;

	
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$reviews[] = $row;
	}
	
	return $reviews;

}

function getReviewCountForUser($which, $id) {
	$reviews = array();
	
if ($which == 'positive') {
		$query = "SELECT * FROM reviews WHERE user_id = '".$id."' AND is_positive = '1'";
	} else {
		$query = "SELECT * FROM reviews WHERE user_id = '".$id."' AND is_positive = '0'";
	}
	
	$result = mysql_query($query) or die(mysql_error());
	return mysql_num_rows($result);
}


?>
