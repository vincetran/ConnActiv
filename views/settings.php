<?php 
	include("config.php");

	//Checks if there is a login cookie
	if(cookieExists() && validCookie())
	//if there is a username cookie, we need to check it against our password cookie
	{
		
		if (isset($_POST['doSubscribe'])) {
			$newSubscriptions = $_POST['subscribeTo'];
			if ($newSubscriptions) {
				foreach($newSubscriptions as $s) {
					echo 'TODO: subscribing user to network ID='.$s. ", ";
					//call to subscribe function - KIM TODO
				} //endforeach				
			} //endif
		}
		
			?>
			<script type="text/javascript">
			
			
			 $('#addNetwork').dataTable( {
        "aaSorting": [[ 0, "asc" ]],
        "bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false
   		 });
   		 
   		 $('.clickExpand').click(function(){
   		 
   		 	$plusMinus = $(this).html();
   		 	if ($plusMinus == '[ + ]') {
   		 		$('div.doExpand').show();
   		 		$(this).html('[ - ]');
   		 	} else {
   		 		$('div.doExpand').hide();
   		 		$(this).html('[ + ]');
   		 	}
   		 	   		 
   		 });
   		 
   		 
			</script>
			
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
			<h3>Subscribe to a new network <span class="clickable clickExpand">[ + ]</span></h3>
			
			<div class="doExpand" id="allNetworks" style="display:none">
			<form id="addNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
					<table class="requests regular_table" id="addNetwork">
					<thead>
						<tr>
							<th>Network ID</th>
							<th>Network name</th>
							<th>Add Network</th>
						</tr>
					</thead>
					<tbody>
						
						<? $networkNames = getAllNetworkNames();	
							 $networkIDs = getAllNetworkIDs();
								
								for($i = 0; $i < count($networkNames); $i++){
									echo "<tr><td>$networkIDs[$i]</td><td>$networkNames[$i]</td><td><input type='checkbox' value='$networkIDs[$i]' name='subscribeTo[]' /></td></tr>";
								}
						?>
						</tbody>
					</table>
					<input style="float:right; margin-right:20px; margin-top: 5px;" type="submit" name="doSubscribe" value="Subscribe to Selected"/>
				</form>
			</div>			
			
			<br/><br/>
			<h2>Your skill level preferences</h2>
			
			<table class="settings regular_table">
			<thead>
				<tr>
					<th>Activity</th>
					<th>Seeking level</th>
					<th>Acceptance range</th>
					<th>Your skill level</th>
				</tr>
			</thead>
			<tbody>
				<?
				$levels = getUserActivityLevels();
				foreach($levels as $level){
					echo "<tr>$level</tr>";
				}
				
				?>
			</tbody>
			
			
			</table>
			
			<br/><br/>
			<h2>Your favorites</h2>
			
			<table class="settings regular_table">
			
			<tr>
				<th>Activity</th>
				<th>Action</th>
			</tr>
			<? $favs = getFavorites(); 
				if (!$favs): ?>
				<tr>
					<td colspan="2">You haven't selected any favorites!</td>
				</tr>
			<? else: 
				foreach($favs as $fav):
			?>
					<tr>
						<td><? echo $fav ?></td> <!-- Rob can you make the remove work for these? -->
						<td><input type="submit" name="remove" value="Remove"/></td>
					</tr>
				<? endforeach; ?>
			<? endif; ?>
			
			</table>
			<div id="footer">&copy; 2011; Kim Cooperrider &middot; Rob Filippi &middot; Dave Johnson &middot; Vince Tran &middot; Ray Wang</div>			
			</div><!-- /page -->
			<?php
		}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>