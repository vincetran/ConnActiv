<?php 
	include("config.php");

	//Checks if there is a login cookie
	if(cookieExists() && validCookie())
	//if there is a username cookie, we need to check it against our password cookie
	{
		
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
   		 	
   		 	$('#addNetworksForm').submit( function() {
					var sData = $('input', oTable.fnGetNodes()).serialize();
					alert( "The following data would have been submitted to the server: \n\n"+sData );
					return false;
				});
   		 	
   		 
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
			<h3>New network subscription <span class="clickable clickExpand">[ + ]</span></h3>
			
			<!-- submission doesn't work yet - Kim -->
			<div class="doExpand" id="allNetworks" style="display:none">
			<form id="addNetworksForm" method="post" action="../index.html">
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
									echo "<tr><td>$networkIDs[$i]</td><td>$networkNames[$i]</td><td><input type='checkbox' name='$networkIDs[$i]' value='Add' /></td></tr>";
								}
						?>
						</tbody>
					</table>	
					<br/>
					<input style="float:right; margin-right:40px" type="submit" name="addNetworks" value="Add Selected"/>
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
						
			</div><!-- /page -->
			<?php
		}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>