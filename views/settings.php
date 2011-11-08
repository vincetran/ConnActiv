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
			Settings
			</h3>
			<table style="border:1px solid #004a1e;">
			<tr style="border:1px solid #004a1e;"Align="Center"><td Colspan="3">Current Networks:</td></tr>
				<tr style="border:1px solid #004a1e;">
					<td>Area</td>
					<td>Activity</td>
					<td>Action</td>
				</tr>
			<?php 
				$networks = getNetworkNames();
				for($i = 0; $i < count($networks); $i++){
					?>
					<tr style="border:1px solid #004a1e;">
						<td><?php echo $networks[$i]; ?></td>
					</tr>
					<?php
					$activities = getUserNetworkActivities();
					for($k = 0; $k < count($activities); $k++){
						if($networks[$i] != $activities[$k]){
							?>
							<tr style="border:1px solid #004a1e;">
								<td></td>
								<td>
									<?php echo $activities[$k]; ?>
								</td>
								<td><input type="submit" name="remove" value="Remove"/></td>
							</tr>
							<?php 
						}
					}
					
				}
				
			?>
			</table>	
			</div>
			<?php
		}
 	//
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>