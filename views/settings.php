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
			
			<h2>Your subscribed networks</h2>
			
			<table class="settings regular_table">
				<tr>
					<th>Area</th>
					<th>Activity</th>
					<th>Action</th>
				</tr>
			<?
				$networks = getNetworkNames();
				foreach($networks as $network){
			?>
					<tr>
						<td colspan="3" style="text-align:left"><? echo $network; ?></td>
					</tr>
					<?
					$activities = getUserNetworkActivities();
					for($k = 0; $k < count($activities); $k++){
						if($network != $activities[$k]){
							?>
							<tr>
								<td>&nbsp;</td>
								<td>
									<? echo $activities[$k]; ?>
								</td>
								<td><input type="submit" name="remove" value="Remove"/></td>
							</tr>
							<? 
						}
					}
					
				}
				
			?>
			</table>	
			
			<br/><br/>
			<h2>Your skill level preferences</h2>
			
			<table class="settings regular_table">
			
			<tr>
				<th>Activity</th>
				<th>Seeking level</th>
				<th>Acceptance range</th>
				<th>Your skill level</th>
			</tr>
			<tr>
				<td>asdf</td>
				<td>asdf</td>
				<td>asdf</td>
				<td>asdf</td>
			</tr>
			<tr>
				<td>asdf</td>
				<td>asdf</td>
				<td>asdf</td>
				<td>asdf</td>
			</tr>
			
			</table>
			
			
			
			
			</div><!-- /page -->
			<?php
		}
 	//
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>