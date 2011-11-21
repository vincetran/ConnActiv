<?

function getFavoritexs() {
// Return a list of the user's favorited unique networks for display in the sidebar.

		$userID = getUserID();
		$networkName = array();
		$resourceID = getResourceIDs("user_networks", "user_id", $userID);
		while($info = mysql_fetch_array($resourceID)){
			$uniqueNetwork = getDatabaseInfo("unique_networks","unique_network_id", $info['UNIQUE_NETWORK_ID']);
			$networkID = $uniqueNetwork['NETWORK_ID'];
			$networkName[] = getNetworkName($networkID);
		}
		
		return $networkName;

}

function getFavorites(){

	$id = getUserID();
	$resourceID = getResourceIDs("user_networks", "user_id", $id);
	foreach($resourceID as $r) {
		echo $r;
	}



}
	




?>