<?

/* Actually, Rob this is listed as your action item. Feel free to take it away :)
 * What I've done here just links to the "Join" button in the user's ConnAction stream (home.php)
 * And also I broke your post connaction business, probably because I'm unsure how to link a form
 * to a specific function. So yeahhhh oops. Let me know if I can clarify anything else.
 * --Kim
 */


function joinRequest(){
	
	$from_user = getUserID();
	$to_user = $_POST['postingUserID'];
	$connactionID = $_POST['connactionID'];
	$message = $_POST['message'];
	
	$query = sprintf("INSERT INTO connaction_requests (from_user, to_user, connaction_ID, message) values(%s,%s,%s,'%s')", $from_user, $to_user, $connactionID, $message);
	$insert = mysql_query($query) or die(mysql_error());	
	header("Location: ../index.html");
	//echo $query;
	
}
function getApproval(){

}

?>