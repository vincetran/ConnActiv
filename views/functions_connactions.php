<?

/*
*
** Connactions
*
*/

	function postConnaction(){
	
	/*
	**
	* HEY ROBBBBBER ROB can you fix this so it takes the date the way datepicker inputs it? KCOOOOOL -Kim
	*
	**
	*/
	
		//This function will post the connaction to the database!
		$startTime = getCurYear()."-".getCurMonth(1)."-".$_POST['startDay']." ".$_POST['startHour'].":".$_POST['startMin'].":00";
		$endTime = getCurYear()."-".getCurMonth(1)."-".$_POST['endDay']." ".$_POST['endHour'].":".$_POST['endMin'].":00";
		
		
		$query = "INSERT INTO connactions(USER_ID, LOCATION, START_TIME, MESSAGE, END_TIME, ACTIVITY_ID, NETWORK_ID, IS_PRIVATE)
			VALUES ('".getUserID()."', '".$_POST['location']."', '".$startTime."', '".$_POST['message']."', '".$endTime."'
					, '".$_POST['activity']."', '".$_POST['network']."', '".$_POST['private']."')";
					
		$insert = mysql_query($query) or die(mysql_error());
		header("Location: ../index.html");
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
			$result = mysql_query("SELECT * FROM connactions WHERE network_id = '$n_aID' ORDER BY connaction_id DESC")or die(mysql_error()); //returns true if you do not assign

			while($info = mysql_fetch_array($result)){
				$connactionUsers[] = $info;
			}
			return $connactionUsers;
		}
		else{
			return "error";
		}
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