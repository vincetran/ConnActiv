<?php 
	include("config.php");

	//Checks if there is a login cookie
	if(cookieExists())
	//if there is a username cookie, we need to check it against our password cookie
	{ 
		if (!validCookie()) {
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
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>