<?

/*
* USERS
*
*/

/*
	  Getting an ID:	
		$row = mysql_fetch_array($result);
		return $row[0];	
		
		Getting a row:
		while($row = mysql_fetch_array($result)){
				$events[] = $row;
			}
		return $events;
	
*/


	function cell($content) {
		return "<td>$content</td>";
	}

	function getAllUsers() {
		$users = array();
		$query = "SELECT * FROM users";
		$result = mysql_query($query) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
				$users[] = $row;
			}
		return $users;		
	}
	
	function totalUsers() {
		$query = "SELECT count(*) FROM users";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
		return $row[0] - 1;
	}
	
	function deleteUser($id) {
		$query = "DELETE FROM users WHERE user_id = '".$id."'";
		mysql_query($query) or die(mysql_error());
	}
	
	
	function getFormattedUsers() {
		
		$users = getAllUsers();
		
		$table = "";
		$table .= "<table id='usersTable' class='regular_table admin'><thead><tr>";
		$table .= "<th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Street</th>";
		$table .= "<th>City</th><th>State</th><th>Zip</th><th>Phone</th><th>Interests</th><th>DOB</th><th>M/F</th>";
		$table .= "<th><span id='event' class='checkAll'></span><span id='_event' class='uncheckAll'></th></tr></thead><tbody>";
	
		foreach($users as $u) {
			$table .= "<tr>";
				$user_id = $u['USER_ID'];
			$table .= cell($user_id);
			$table .= cell($u['EMAIL']);
			$table .= cell($u['FIRST_NAME']);
			$table .= cell($u['LAST_NAME']);
			$table .= cell($u['STREET']);
			$table .= cell($u['CITY']);
			$table .= cell($u['STATE']);
			$table .= cell($u['ZIP']);
			$table .= cell($u['PHONE']);
			$table .= cell($u['INTERESTS']);
			$table .= cell($u['DOB']);
			$table .= cell($u['GENDER']);
			$table .= "<td><input class='event' type = 'checkbox' name = 'userID[]' value = '".$user_id."' /></td></tr>";			
		
		} //end foreach
	
		$table .= "</tbody></table>";
		return $table;
	}
	
	function messageUser($to_user) {
		
	}


/*
*	EVENTS
*
*/

	
	function deleteEvent($id) {
		$query = "DELETE FROM events WHERE event_id = '".$id."'";
		mysql_query($query) or die(mysql_error());
	}

	function totalAllEvents() {
	// $which is -1, 0, or 1 depending on the status of events to count	
		$users = array();
		$query = "SELECT COUNT(*) from events";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
		return $row[0];
	}
	

	function totalEvents($which) {
	// $which is -1, 0, or 1 depending on the status of events to count	
		$users = array();
		$query = "SELECT COUNT(*) from events WHERE approved = '".$which."'";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
		return $row[0];
	}
	
	
	function getAllEvents() {
		$events = array();
		$query = "SELECT * FROM events";
		
		$result = mysql_query($query) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
				$events[] = $row;
			}
		return $events;
	} // end getAllEvents
	
	
	function getFormattedEvents() {
		
		$table = "";
		$table .= "<table id='eventsTable' class='regular_table admin'><thead><tr>";
		$table .= "<th>ID</th><th>Requester</th><th>Activity</th><th>Network</th><th>Location</th><th>Details</th>";
		$table .= "</th><th>Starting</th><th>Ending</th><th>Status</th><th>Requested</th>";
		$table .= "<th><span id='event' class='checkAll'></span><span id='_event' class='uncheckAll'></th></tr></thead><tbody>";
		
		$events = getAllEvents();
			
			foreach($events as $e) {
				$table .= "<tr>";
				$eventID = $e['EVENT_ID'];
				$table .= cell($eventID);
				$table .= cell(getUserName($e[1]));
				$table .= cell($e['ACTIVITY_ID']); 
				$table .= cell($e['NETWORK_ID']);
				$table .= cell($e['MESSAGE']);
				$table .= cell($e['LOCATION']);
				
				$start = new DateTime($e['START']);
				$startDate = $start->format('m-d-y H:i a');
				$table .= cell($startDate);
				
				$end = new DateTime($e['END']);
				$endDate = $start->format('m-d-y H:i a');
				$table .= cell($endDate);
				
				$appr = $e['APPROVED'];
				$appr == 0 ? $status = "denied" : ($appr = 1 ? $status = "approved" : $status = "awaiting approval");
				
				$start = new DateTime($e['START']);
				$startDate = $start->format('m-d-y H:i:s');
				$startYear = $start->format('y');
				$startMon = $start->format('m');
				$startDay = $start->format('d');
				
				$year = Date('y');
				$mon = Date('m');
				$day = Date('d');
				if (($year > $startYear)) $status = "expired";
				
				$table .= cell($status);
				
				$request = new DateTime($e['REQUEST_DATE']);
				$requestDate = $start->format('m-d-y H:i a');
				$table .= cell($requestDate);
			
				$table .= "<td><input class='event' type = 'checkbox' name = 'eventID[]' value = '".$eventID."' /></td>";	
				$table .= "</tr>";
			} //end foreach
				$table .= "</tbody></table>";
		
		return $table;
	
		} //end getFormattedEvents

	function approveEvent($e_id) {
	//$e_id is event id
		$query = "UPDATE events SET approved = '1' WHERE event_id = '" .$e_id."'";
		mysql_query($query) or die(mysql_error());
		echo "<div class='adminAction'>Event(s) approved.</div>";
	}
	
	function denyEvent($e_id) {
	//$e_id is event id
		$query = "UPDATE events SET approved = '0' WHERE event_id = '" .$e_id."'";
		mysql_query($query) or die(mysql_error());
		echo "<div class='adminAction'>Event(s) denied.</div>";
	}


/*
* CONNACTIONS
*
*/


	function getFormattedConnactions() {
	
	}
	
	


?>