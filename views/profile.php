<?php 
	// Connects to Database
	//mysql_connect("localhost", "xgamings_connact", "connactive123") or die(mysql_error()); //This is our database credentials
	mysql_connect("localhost", "root", "") or die(mysql_error()); 	//This is wamp database credentials
	mysql_select_db("xgamings_connactiv") or die(mysql_error()); 

	//Checks if there is a login cookie
	if(isset($_COOKIE['ID_my_site']))
	//if there is, it logs you in and directes you to the home page
	{ 
		$username = $_COOKIE['ID_my_site']; 
		$pass = $_COOKIE['Key_my_site'];
 	 	$check = mysql_query("SELECT * FROM users WHERE email = '$username'")or die(mysql_error());
		while($info = mysql_fetch_array( $check )) 	{
			if ($pass != $info['PASSWORD']) {
				//Cookie doesn't match password go to index";
				header("Location: ../index.html"); 
			}
			else{
				//Cookie matches, show what they want.";
				?>
				<div class="page">
				<h3>
				Profile
				</h3>
				
					
				</div>
				<?php
			}
 		}
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>