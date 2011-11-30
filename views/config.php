<?php
	//var_dump($_POST);
	// Connects to Database
	//mysql_connect("localhost", "xgamings_connact", "connactive123") or die(mysql_error()); //This is our database credentials
	mysql_connect("localhost", "root", "") or die(mysql_error()); 	//This is wamp database credentials
	mysql_select_db("xgamings_connactiv") or die(mysql_error()); 


include("functions_connactions.php");
include("functions_recommendations.php");
include("functions_networks.php");
include("functions_join_requests.php");
include("upload_file.php");

	function cookieExists(){
		//Check to see if user ID cookie exists
		if(isset($_COOKIE['ID_my_site']))
			return TRUE;
		else
			return FALSE;
	}
	function validCookie(){
		//Check to make sure the user ID cookie matches the password cookie
		$username = $_COOKIE['ID_my_site']; 
		$pass = $_COOKIE['Key_my_site'];
		$info = getDatabaseInfo("users", "email", $username);
		//while($info = getDatabaseInfo("users", "email", $username)) 	{ 		//Since we have unique cookies I do not think we need to have this
																//loop. Can anyone confirm?
			if ($pass != $info['PASSWORD']) {
				//ID cookie doesn't match password cookie
				return FALSE;
			}
			else{
				//ID cookie matches, password cookie
				return TRUE;
 			}
		//}
	}
	
	
	function isAdmin(){
	
		$id = getUserID();
		return $id == 1; // admin is user 1
		
	}
	
	
	function login(){
		//This function logs in the user when they press the login button
		// makes sure they filled it in
		if(!$_POST['username'] | !$_POST['pass']) {
			die('Oops. You did not fill in a required field.');
		}
		// checks it against the database
		//if (!get_magic_quotes_gpc()) {
		//	$_POST['email'] = addslashes($_POST['email']);		//I do not know where this came from. Did you add it dave?
		//}
		$check = mysql_query("SELECT * FROM users WHERE email = '".$_POST['username']."'")or die(mysql_error());
		//Gives error if user dosen't exist
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) {
			echo '<div class="error">Sorry, that user does not exist in our database. Why don\'t you register?</div>';
		}
		while($info = mysql_fetch_array( $check )) 	
		{
			$_POST['pass'] = stripslashes($_POST['pass']);
			$info['PASSWORD'] = stripslashes($info['PASSWORD']);
			$_POST['pass'] = md5($_POST['pass']);
			//gives error if the password is wrong
			if ($_POST['pass'] != $info['PASSWORD']) {
				echo '<div class="error">Incorrect password, please try again.</div>';
			}
			else { 
			// if login is ok then we add a cookie 
			 $_POST['username'] = stripslashes($_POST['username']);
			 $hour = time() + 100000;
			setcookie('ID_my_site', $_POST['username'], $hour);
			setcookie('Key_my_site', $_POST['pass'], $hour);
			//then redirect them to the members area 
			header("Location: views/home.php");
			} 
		}
	}
	function register(){
	//This function registers the user when they press the register button
	//check to make sure the required fields were filled in.
		if(!$_POST['username'] || !$_POST['password'] || !$_POST['confirm']) {
			echo '<div class="error">You did not fill in a required field. Required fields include: email, password, and confirm password.</div>';
		}
		//check to make sure the email is not already registered.
		$check = mysql_query("SELECT * FROM users WHERE email = '".$_POST['username']."'")or die(mysql_error());
		$check2 = mysql_num_rows($check);
		
		//if email has not been registered before
		if($check2 == 0){
			//check to make sure the password was confirmed			
			if(strcmp($_POST['password'], $_POST['confirm'])==0){			
				//check to make sure the password is longer than 6 characters, may want to use regexp to improve
				//security
							
				//insert information into users tables.
				$query = "Insert into users(email,first_Name, last_Name, Street, city, state, zip, phone, interests, profile_pic, password) values('".$_POST['username']."','".$_POST['firstName']."','".$_POST['lastName']."','".$_POST['street']."','".$_POST['city']."','".$_POST['state']."','".$_POST['zip']."','".$_POST['phone']."','".$_POST['interests']."','../public/images/avatar.png','".md5($_POST['password'])."')";
				$insert = mysql_query($query) or die(mysql_error());
				$id = mysql_query("select max(user_id) from users");
				$id1 = mysql_fetch_array($id);
				$userid2 = $id1[0];
			
				if ($_POST['city'] && $_POST['state']) {
					//If the network doesn't already exist, add it to the networks table.
					$query = sprintf("SELECT network_id FROM networks WHERE area = '%s' AND state = '%s'", $_POST['city'], $_POST['state']);
					$checkNetwork = mysql_query($query) or die(mysql_error());				
					$checkNetwork1 = mysql_fetch_array($checkNetwork);
					$networkid = (int)$checkNetwork1[0];
					if(mysql_num_rows($checkNetwork) == 0){
						$networkid = addNetworkWithState($_POST['city'], $_POST['state']);
					}	
				} //end if $city and $state
				
				//subscribe the user to all of the user-selected unique networks
				if (isset($_POST['activity'])) {
					$acts = $_POST['activity'];				
						foreach($acts as $act) {
								forceSubscribe($userid2, $act); //where $userid2 is the user id
							}//end foreach($act)
					} //end if ($_POST['activity'])
					
				//or if the user is creating his own unique network
				if ($_POST['area'] && $_POST['state'] && $_POST['newActivity']) {
					$area = $_POST['area'];
					$state = $_POST['state'];
					$activity = $_POST['newActivity'];
					forceCreateAndSubscribeNetwork($userid2, $area, $state, $activity);
				}
					
				// Now, create the cookie
				$_POST['username'] = stripslashes($_POST['username']); 
				$hour = time() + 100000; 
				setcookie('ID_my_site', $_POST['username'], $hour); 
				setcookie('Key_my_site', md5($_POST['password']), $hour);
				header("Location: views/home.php");
			}	
			//if the passwords do not match ask them to enter the information again
			else{ die("the passwords do not match, please re-enter your information");}
		}
		//if the email is already registered then display message
		else{
			echo '<div class="error">This email has already been registered.</div>';
		}
	}


	function addUserActivity($userid, $activityid){
		$insert = mysql_query("INSERT IGNORE INTO user_activities(user_id, activity_id) values($userid, $activityid)") or die(mysql_error());
	}
	/*function getUserName($userid){
		$query = "select first_name, last_name from users where users_id = ".$userid;
		$person = mysql_query($query);
		$names = mysql_fetch_array($person);
		$name = $names['first_name']." ".$names['last_name'];
		return $name;
	}*/
	function getConnactionAttendees($connactionid, $userid){
		$query = "select user_id from connaction_attending where connaction_id = ".$connactionid." and user_id <> ".$userid;
		$attendees = mysql_query($query);

		while($info = mysql_fetch_array($attendees)){
			$connactionattendees[] = $info;
		}

		return $connactionattendees;
	}

	function isAttending($connactionid, $userid){
		$query = "select * from connaction_attending where user_id = ".$userid." and connaction_id = ".$connactionid;
		$isattending = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($isattending) == 0){return false;}
		else if(mysql_num_rows($isattending) == 1){return true;}	
	}
		
	function getDatabaseInfo($table, $attribute, $value){
		//Returns an array of strings that corresponds to the fetched row
		$check = getResourceIDs($table, $attribute, $value); 
		
		return mysql_fetch_array($check);
	}
	function getResourceIDs($table, $attribute, $value){
		//This function returns resource IDs
		
		$check = mysql_query("SELECT * FROM $table WHERE $attribute = '$value'")or die(mysql_error()); //retuns true if you do not assign
		return $check;																				   //mysql_query() to a variable
	}
	function getResourceIDs2($table, $attribute1, $value1, $attribute2, $value2){
		//This function returns resource IDs
		
		$check = mysql_query("SELECT * FROM $table WHERE $attribute1 = '$value1' AND $attribute2 = '$value2'")or die(mysql_error()); //retuns true if you do not assign
		return $check;																				   //mysql_query() to a variable
	}
	function getName(){
		//This function returns the users First and Last name
		if(cookieExists())
		//if there is a username cookie, we need to check it against our password cookie
		{
			if (validCookie()) {
				//Cookie matches display their name
				$username = $_COOKIE['ID_my_site'];
				$info = getDatabaseInfo("users", "email", $username);
				return $info['FIRST_NAME'] . " " . $info['LAST_NAME'];
			}
		}
	}
	function getUserID(){
		//This function retusn the users ID
		if(cookieExists())
		//if there is a username cookie, we need to check it against our password cookie
		{
			if (validCookie()) {
				//Cookie matches display their name
				$username = $_COOKIE['ID_my_site'];
				$info = getDatabaseInfo("users", "email", $username);
				return $info['USER_ID'];
			}
		}
	}
	function getUserName($userID){
		//This function returns the user's name
		$info = getDatabaseInfo("users", "user_id", $userID);
		return $info['FIRST_NAME'] . " " . $info['LAST_NAME'];
	}
	function getUserPic($userID){
		//This function returns the user's profile pic
		$info = getDatabaseInfo("users", "user_id", $userID);
		return $info['PROFILE_PIC'];
	}
	function getAboutMe($userID){
		//This function returns the user's interests
		$info = getDatabaseInfo("users", "user_id", $userID);
		if($info['INTERESTS'])
			return $info['INTERESTS'];
		else
			return "Click to specify";
	}
	function getUserLocation($userID){
		//This function returns the user's location
		$location;
		$city;
		$state;
		$info = getDatabaseInfo("users", "user_id", $userID);
		$city = $info['CITY'];
		$state = $info['STATE'];
		$location = $city.", ".$state;
		return $location;
	}
	function getUserGender($userID){
		//This function returns the user's gender
		$gender;
		$info = getDatabaseInfo("users", "user_id", $userID);
		if($info['GENDER'] == 'M')
			$gender = "Male";
		else if($info['GENDER'] == 'F')
			$gender = "Female";
		else
			$gender = "Click to specify";
		return $gender;
	}
	function getAge($userID){
		//This function returns the user's Age
		$DOB;
		$age;
		$today = getDate();
		$info = getDatabaseInfo("users", "user_id", $userID);
		if($info['DOB']){
			//DOB has been set
			$DOB = date_parse($info['DOB']);
			$age = $today["year"] - $DOB["year"];
			if(($today["mon"] - $DOB["month"]) < 0)
				return $age - 1;	//Birthday hasn't happened yet minus 1
			else if(($today["mon"] - $DOB["month"]) > 0)
				return $age;		//Birthday already happened 
			else{
				//Birth month
				if(($today["mday"] - $DOB["day"]) < 0)
						return $age - 1;	//Birthday hasn't happened yet minus 1
				//else if(($today["mday"] - $DOB["mday"]) > 0)
				//	return $age;		//Birthday already happened
				else
					return $age; 
			}
		}
		else
			return "Click to specify";	//No DOB set
	}
	
	function getUserState($userID) {
		$info = getDatabaseInfo("users", "user_id", $userID);
		$state = $info['STATE'];
		return $state;
	}
	
	function getUserCity($userID) {
		$info = getDatabaseInfo("users", "user_id", $userID);
		$city = $info['CITY'];
		return $city;
	}

	function getIncMessages($userid){
		$incMessages = array();		
		$query = "select * from messages where to_user = ".$userid;
		
		$result = mysql_query($query);
		while($info = mysql_fetch_array($result)){
			$incMessages[] = $info;
		}
		return $incMessages;
	}

	function getSentMessages($userid){
		$incMessages = array();		
		$query = "select * from messages where from_user = ".$userid;
		
		$result = mysql_query($query);
		while($info = mysql_fetch_array($result)){
			$incMessages[] = $info;
		}
		return $incMessages;
	}
	
	function saveInfo(){
		//This function sends the my info to the database
		if(isset($_POST['about_me'])){
			echo "about me";
			$interests = $_POST['about_me']; 
			$query = "UPDATE users SET INTERESTS = '".$interests."' WHERE USER_ID = '".getUserID()."'";
			$update = mysql_query($query) or die(mysql_error());

		}
		if(isset($_POST['gender'])){
			echo "gender";
			$gender = $_POST['gender'];
			$query = "UPDATE users SET GENDER = '".$gender."' WHERE USER_ID = '".getUserID()."'";
			$update = mysql_query($query) or die(mysql_error());
		}
		if (isset($_POST['DOB'])){
			$DOB = myDateParser($_POST['DOB']);
			$query = "UPDATE users SET DOB = '".$DOB."' WHERE USER_ID = '".getUserID()."'";
			$update = mysql_query($query) or die(mysql_error());
		}
		
		if (isset($_POST['city'])) {
			$city = $_POST['city'];
			$query = "UPDATE users SET CITY = '".$city."' WHERE USER_ID = '".getUserID()."'";
			$update = mysql_query($query) or die(mysql_error());

		}
		
		if (isset($_POST['state'])) {
			$st = $_POST['state'];
			$query = "UPDATE users SET STATE = '".$st."' WHERE USER_ID = '".getUserID()."'";
			$update = mysql_query($query) or die(mysql_error());

		}
		
		for($i = 0; $i < count(getUserActivityLevels()); $i++){
			if((isset($_POST['seekLvl'.$i])) && ($_POST['seekLvl'.$i] != -1)){
				$type = "PREFERRED";
				//echo "TODO: Update ".$type;
				$seekID = $_POST['seekLvl'.$i];
				$level = strtok($seekID, " ");
				$activity = strtok(" ");
				$activityID = getActivityID($activity);
				
				$query = sprintf("UPDATE user_activities SET %s = '%s' WHERE USER_ID = '%s' AND ACTIVITY_ID = '%s'",$type, $level, getUserID(), $activityID);
				$update = mysql_query($query) or die(mysql_error());
				
			}
			if((isset($_POST['lowLvl'.$i])) && ($_POST['lowLvl'.$i] != -1)){
				$type = "LOW_LEVEL";
				$seekID = $_POST['lowLvl'.$i];
				$level = strtok($seekID, " ");
				$activity = strtok(" ");
				$activityID = getActivityID($activity);
				
				$query = sprintf("UPDATE user_activities SET %s = '%s' WHERE USER_ID = '%s' AND ACTIVITY_ID = '%s'",$type, $level, getUserID(), $activityID);
				$update = mysql_query($query) or die(mysql_error());
			}
			else if((isset($_POST['highLvl'.$i])) && ($_POST['highLvl'.$i] != -1)){
				$type = "HIGH_LEVEL";
				$seekID = $_POST['highLvl'.$i];
				$level = strtok($seekID, " ");
				$activity = strtok(" ");
				$activityID = getActivityID($activity);
				
				$query = sprintf("UPDATE user_activities SET %s = '%s' WHERE USER_ID = '%s' AND ACTIVITY_ID = '%s'",$type, $level, getUserID(), $activityID);
				$update = mysql_query($query) or die(mysql_error());
			}
			else if((isset($_POST['ownLvl'.$i])) && ($_POST['ownLvl'.$i] != -1)){
				$type = "OWN_LEVEL";
				$seekID = $_POST['ownLvl'.$i];
				$level = strtok($seekID, " ");
				$activity = strtok(" ");
				$activityID = getActivityID($activity);
				
				$query = sprintf("UPDATE user_activities SET %s = '%s' WHERE USER_ID = '%s' AND ACTIVITY_ID = '%s'",$type, $level, getUserID(), $activityID);
				$update = mysql_query($query) or die(mysql_error());
			}
		}
	}
	function myDateParser($dateToParse){
		//This function takes a string date in the format of mm/dd/yyyy
		//and returns a string date in the format of yyyy-mm-dd
		$DOB = array(); // array to store each name
		$date;
			if (is_int(strpos($dateToParse, '/'))){
				$DOB = explode('/', $dateToParse); // Multiple names
				//index 0 is month
				//index 1 is day of the month
				//index 2 is the year
				$date =$DOB[2]."-".$DOB[0]."-".$DOB[1];
				return $date;
			}
			else{
				return "Error";
			}
	}
	function datePassed($checkDate){
		//This function checks the inputed date with the current date
		//if the checkDate has passed it will return true if the check
		//date is in the future it return false
		$newDate = date_parse($checkDate);
		$today = getDate();
		if($today["year"] > $newDate["year"]){
			return true;
		}
		else if($today["mon"] > $newDate["month"] && $today["year"] >= $newDate["year"]){
			return true;
		}
		else if($today["mday"] > $newDate["day"] && $today["mon"] >= $newDate["month"] && $today["year"] >= $newDate["year"]){
			return true;
		}
		else{
			return false;
		}
	}
	function getActivity($activityID){
		//This function returns the name of the inputed activity ID
		
		$activity = getDatabaseInfo("activities","activity_id", $activityID);
		$activityName = $activity['ACTIVITY_NAME'];
		
		return $activityName;
	}
	function getActivityID($activityName){
		//This function returns the ID value of the activity name that is inputed
		
		$activity = getDatabaseInfo("activities","activity_name", $activityName);
		$activityID = $activity['ACTIVITY_ID'];
		
		return $activityID;
	}
	function getActivityLevel($userID, $activityID, $num){
		//This returns an activity level of the given user in a given activity based on num
		//		0 = low level
		//		1 = high level
		//		2 = preferred
		//		3 = own level
		//		4 = all
		$activityLevels = array();
		
		$resourceID = getResourceIDs2("user_activities", "user_id", $userID, "activity_id", $activityID);
		$info = mysql_fetch_array($resourceID);
		$activityLevels[] = $info["LOW_LEVEL"];
		$activityLevels[] = $info["HIGH_LEVEL"];
		$activityLevels[] = $info["PREFERRED"];
		$activityLevels[] = $info["OWN_LEVEL"];
		if($num == 0){
			//return low level
			return $activityLevels[0];
		}
		else if($num == 1){
			//return high level
			return $activityLevels[1];
		}
		else if($num == 2){
			//return preferred
			return $activityLevels[2];
		}
		else if($num == 3){
			//return own level
			return $activityLevels[3];
		}
		else if($num == 4){
			//return all
			return $activityLevels;
		}
		else{
			//return error
			return "error";
		}
	}
	function getNetworkID($networkName){
		//This function returns the ID value of the network name that is inputed
		
		$network = getDatabaseInfo("networks","area", $networkName);
		$networkID = $network['NETWORK_ID'];
		
		return $networkID;
	}
	function getNetworkName($networkID){
		//This function retuns the network name of the network ID that is inputed
		
		$network = getDatabaseInfo("networks", "network_id", $networkID);
		$networkName = $network['AREA'];
		
		return $networkName;
	}
	function getNetworkNames(){
		//This function returns an array of user's network names
		$userID = getUserID();
		$networkName = array();
		$index = 0;
		$previousID;
		$resourceID = getResourceIDs("user_networks", "user_id", $userID);
		while($info = mysql_fetch_array($resourceID)){
			$uniqueNetwork = getDatabaseInfo("unique_networks","unique_network_id", $info['UNIQUE_NETWORK_ID']);
			$networkID = $uniqueNetwork['NETWORK_ID'];
			if($index == 0){
				$previousID = $networkID;
				$index++;
				$networkName[] = getNetworkName($networkID);
			}
			else{
				//Need to see if we have the same network ID
				if($previousID != $networkID){
					//yay not the same
					$previousID = $networkID;
					$networkName[] = getNetworkName($networkID);
				}
			}
		}
		
		return $networkName;
	}
	function getAllNetworkActivites(){
		//This function returns an array of all network activities
		$networkNames = getNetworkNames();
		$networkActivities = array();
		
		for($i = 0; $i < count($networkNames); $i++){
			$networkID = $networkNames[$i];
			$resourceID = getResourceIDs("unique_networks", "network_id", $networkID);
			while($info = mysql_fetch_array($resourceID)){
				$activity = getDatabaseInfo("activities","activity_id", $info['ACTIVITY_ID']);
				$networkActivities[] = $activity['ACTIVITY_NAME'];
			}
		}
		return $networkActivities;
	}
	function getNetworkActivites($networkName){
		//This function returns an array of activities in a given network
		$networkActivities = array();
		$networkID = $networkName;
		$resourceID = getResourceIDs("unique_networks", "network_id", $networkID);
		while($info = mysql_fetch_array($resourceID)){
			$activity = getDatabaseInfo("activities","activity_id", $info['ACTIVITY_ID']);
				$networkActivities[] = $activity['ACTIVITY_NAME'];
		}
		return $networkActivities;
	}
	function getUserNetworkActivities(){
		//This function returns an array of the user's networks and activites
		$userID = getUserID();
		$userActivities = array();
		$oldNetwork = null;
		
		$resourceID = getResourceIDs("user_networks", "user_id", $userID);
		while($info = mysql_fetch_array($resourceID)){
			$uniqueNetworkID = getDatabaseInfo("unique_networks","unique_network_id", $info['UNIQUE_NETWORK_ID']);
			$networkID = $uniqueNetworkID['NETWORK_ID'];
			$network = getNetworkName($networkID);
			$activityID = $uniqueNetworkID['ACTIVITY_ID'];
			$activity = getActivity($activityID);
			if($oldNetwork != $network){
				//this prevents multiple network names to be stored in the array.
				$UsersNetworkActivities[] = $network;
			}
			$UsersNetworkActivities[] = $activity;
			
			$oldNetwork = $network;
			
		}
		return $UsersNetworkActivities;
		
	}
	function getUserActivities(){
		//This function returns an array of all the activities a user has
		$userID = getUserID();
		$userActivities = array();
		
		$resourceID = getResourceIDs("user_activities", "user_id", $userID);
		while($info = mysql_fetch_array($resourceID)){
			$activity = getDatabaseInfo("activities", "activity_id", $info['ACTIVITY_ID']);
			$userActivities[] = $activity['ACTIVITY_NAME'];
		}
		return $userActivities;
	}
		
	
	function getStateDropdown() {
	
	$states = '
	
	<select name="state">
	<option value="AL">AL</option>
	<option value="AK">AK</option>
	<option value="AZ">AZ</option>
	<option value="AR">AR</option>
	<option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DE">DE</option>
	<option value="DC">DC</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="IA">IA</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="ME">ME</option>
	<option value="MD">MD</option>
	<option value="MA">MA</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MS">MS</option>
	<option value="MO">MO</option>
	<option value="MT">MT</option>
	<option value="NE">NE</option>
	<option value="NV">NV</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NY">NY</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VT">VT</option>
	<option value="VA">VA</option>
	<option value="WA">WA</option>
	<option value="WV">WV</option>
	<option value="WI">WI</option>
	<option value="WY">WY</option>
	</select>';
	return $states;

	}
	
	
	
	function getStateDropdownLong() {
	//Don't edit this! Call wherever we need a state dropdown.
	
	$states = '
	
	<select name="state">
		<option value="AL">Alabama</option>
		<option value="AK">Alaska</option>
		<option value="AZ">Arizona</option>
		<option value="AR">Arkansas</option>
		<option value="CA">California</option>
		<option value="CO">Colorado</option>
		<option value="CT">Connecticut</option>
		<option value="DE">Delaware</option>
		<option value="DC">District of Columbia</option>
		<option value="FL">Florida</option>
		<option value="GA">Georgia</option>
		<option value="HI">Hawaii</option>
		<option value="ID">Idaho</option>
		<option value="IL">Illinois</option>
		<option value="IN">Indiana</option>
		<option value="IA">Iowa</option>
		<option value="KS">Kansas</option>
		<option value="KY">Kentucky</option>
		<option value="LA">Louisiana</option>
		<option value="ME">Maine</option>
		<option value="MD">Maryland</option>
		<option value="MA">Massachusetts</option>
		<option value="MI">Michigan</option>
		<option value="MN">Minnesota</option>
		<option value="MS">Mississippi</option>
		<option value="MO">Missouri</option>
		<option value="MT">Montana</option>
		<option value="NE">Nebraska</option>
		<option value="NV">Nevada</option>
		<option value="NH">New Hampshire</option>
		<option value="NJ">New Jersey</option>
		<option value="NM">New Mexico</option>
		<option value="NY">New York</option>
		<option value="NC">North Carolina</option>
		<option value="ND">North Dakota</option>
		<option value="OH">Ohio</option>
		<option value="OK">Oklahoma</option>
		<option value="OR">Oregon</option>
		<option value="PA">Pennsylvania</option>
		<option value="RI">Rhode Island</option>
		<option value="SC">South Carolina</option>
		<option value="SD">South Dakota</option>
		<option value="TN">Tennessee</option>
		<option value="TX">Texas</option>
		<option value="UT">Utah</option>
		<option value="VT">Vermont</option>
		<option value="VA">Virginia</option>
		<option value="WA">Washington</option>
		<option value="WV">West Virginia</option>
		<option value="WI">Wisconsin</option>
		<option value="WY">Wyoming</option>
	</select>';

	return $states;

	}
	
	
?>
