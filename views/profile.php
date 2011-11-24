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
			
			//if (name is clicked)
				//viewing someones profile
				//$userID = $_POST['userID']
			//else
				//viewing our profile
				$userID = getUserID();
			?>
			<script type="text/javascript">
			//KIM MY ATTEMPT AT GETTING THIS TO WORK. HEADING TO BED.
			//IF YOU LOOK AT THIS BEFORE I DO THAT IS WHY THIS IS HERE. IT DOESN'T WORK BTW
			$('.edit_about_me').click(function() {
					$('div.about_me').contentEditable="true";
			});
	
			</script>
			
			<div class="page">
			<h2>Your Profile:</h2>
			
			<table class="regular_table" id="myInfo" >
				<tr>
					<td colspan="3">
						<h2>My Info</h2>
					</td>
				</tr>
				<tr>
					<td>About Me:</td>
					<td width="400"><div class="about_me"><?php echo getAboutMe($userID);?></div></td>
					<td class="edit_about_me clickable"><b>Edit</b></td>
				</tr>
				<tr>
					<td>Gender:</td>
					<td><?php echo getUserGender($userID);?></td>
					<td>Edit</td>
				</tr>
				<tr>
					<td>Location:</td>
					<td><?php echo getUserLocation($userID);?></td>
					<td>Edit</td>
				</tr>
				<tr>
					<td>Age:</td>
					<td><?php echo getAge($userID);?></td>
					<td>Edit</td>
				</tr>
			</table>
			
				
			</div>
			<?php
		}
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>