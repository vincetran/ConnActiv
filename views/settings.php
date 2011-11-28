<? include("header.php");

	//Checks if there is a login cookie
	if(cookieExists() && validCookie())
	//if there is a username cookie, we need to check it against our password cookie
	{
		
		if (isset($_POST['doSubscribe'])) {
			if ($_POST['subscribeTo']) {
				$newSubscriptions = $_POST['subscribeTo'];
				foreach($newSubscriptions as $s) { //$ is passed in as unique_network_id
					subscribeNetwork($s);
				} // end foreach
			} //end if ($_POST[subscribeTo])
		} else if (isset($_POST['doUnsubscribe'])) {
			if ($_POST['unsubscribeTo']) {
				$unsubscrips = $_POST['unsubscribeTo'];
				foreach($unsubscrips as $u) {
					unsubscribeNetworks($u);
				} // end foreach
			} //end if ($_POST[unsubscribeTo])
		} else if (isset($_POST['doFavorite'])) {
			if ($_POST['favorite']) {
				$favs = $_POST['favorite'];
				foreach($favs as $f) {
					favoriteNetwork($f);
				} // end foreach
			} //end if ($_POST[favorite])
		} else if (isset($_POST['doAddNetwork'])) {
				$area = $_POST['area'];
				$state = $_POST['state'];
				$activity = $_POST['activity'];
				createAndSubscribeNetwork($area, $state, $activity);
		} else if (isset($_POST['doDefavorite'])) {
			if ($_POST['defavorite']) {
				$defavs = $_POST['defavorite'];
				foreach($defavs as $d) {
					$defav_id = getUniqueNetworkIdByFav($d);
					defavoriteNetwork($defav_id);
				} // end foreach
			} //end if ($_POST[defavorite])
		}
		
			?>
	<script type="text/javascript">
		$(function() {
		
				$('.top_links').removeClass('active');
				$('#settings').addClass('active');
						
				 $('#addNetwork').dataTable( {
					"aaSorting": [[ 0, "asc" ]],
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": true,
					"bSort": true,
					"bInfo": false,
					"bAutoWidth": false,
					"aoColumns": [ null, null, { "bSortable": false }]
				 });
				 
				  $('#userNetworks').dataTable( {
						"aaSorting": [[ 0, "asc" ]],
						"bPaginate": false,
						"bLengthChange": false,
						"bFilter": true,
						"bSort": true,
						"bInfo": false,
						"bAutoWidth": false,
					  "aoColumns": [ null, null, { "bSortable": false }, { "bSortable": false }	]
					 });
				 
				 $('#expandNetworks').click(function(){
					$('#allNetworks').toggle();   		  		 	   		 
				 });
				 
				 $('#expandAddNewNetwork').click(function() {
					$('#hiddenNewNetwork').toggle();   		 
				 });
					 
   		});
   		
   		</script>
			
			<div class="page">
			
			<h2>Your subscribed networks</h2>
			
			<form id="unsubNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="userNetworks" class="regular_table">
				<thead>
				<tr>
					<th>Area</th>
					<th>Activity</th>
					<th>Unsubscribe</th>
					<th>Favorite</th>
				</tr>
				</thead>
				<tbody>
			<?
				$networks = getUserUniqueNetworks();
				$favs = getFavoriteIDs();
				if ($networks) {				
					foreach($networks as $network) {
						echo "<tr>";
							echo "<td>".$network[1].", ".$network[2]."</td><td>".$network[3]."</td>";
							echo "<td><input type='checkbox' value='".$network[0]."' name='unsubscribeTo[]' /></td>";
							in_array($network[0], $favs)? $checked="checked disabled" : $checked = "";  // if in $favs, checkbox "favorite" is checked
							echo sprintf("<td><input type='checkbox' %s value='%s' name='favorite[]' /></td>", $checked, $network[0]);
						echo "</tr>";
					} //end foreach
			} else echo "<tr><td colspan='4'>You aren't subscribed to any networks yet!<br/>Click below to get started.</td></tr>";
			?>
			</tbody>
			</table>
			<div class="below_table">
				<input style="float:right; margin-left:10px; margin-right:20px" type="submit" name="doFavorite" value="Favorite"/>
				<input style="float:right;" type="submit" name="doUnsubscribe" value="Unsubscribe"/>
			</div>
		</form>
			
			<span style="clear:both;margin-top:-1.5em;" class="clickable below_table">Want more updates? <span id="expandNetworks" class="clickExpand">Subscribe to a new network&nbsp;&raquo;</span></span>
			<br/>
			<div class="doExpand" id="allNetworks" style="display:none"><br/>
			<form id="subscribeNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
					<table class="requests regular_table" id="addNetwork">
					<thead>
						<tr>
							<th>Area</th>
							<th>Activity</th>
							<th>Subscribe</th>
						</tr>
					</thead>
					<tbody>
						
						<? $unique = getAllUniqueNetworks(); //row(unique_network_id, area, state, activity_name).
								foreach($unique as $un) {
									echo "<tr><td>". $un[1] .", ". $un[2] ."</td><td>". $un[3] ."</td><td><input type='checkbox' value='".$un[0]."' name='subscribeTo[]' /></td></tr>";
								}
						?>
						</tbody>
					</table>
					<span class="clickable below_table">Can't find your network?&nbsp;<span class="clickExpand" id="expandAddNewNetwork">Add a new one&nbsp;&raquo;</span></span>
					<input style="float:right; margin-right:30px;" class="below_table" type="submit" name="doSubscribe" value="Subscribe"/>
				</form>
				
				<div id="hiddenNewNetwork" style="display:none">
					<form id="createNetworkForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
						Area: <input class="medium_input" type="text" name="area" value="" placeholder="ex: Pittsburgh"/>
						State:  <input class="small_input" type="text" name="state" maxlength="2" value="" placeholder="PA"/>
						Activity: <input class="medium_input"type="text" name="activity" value="" placeholder="ex: being awesome"/>
						<input type="submit" name="doAddNetwork" value="Add"/>	
					</form>
				</div>
			
			</div><!-- end #allNetworks -->
			
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
				if ($levels) {
					foreach($levels as $level){
						echo "<tr>";
						/* Null values come up as 0. TODO.
						*
							$level[0]? echo "<td>$level[0]</td>" : echo "<td>Not set.</td>";
							$level[1]? echo "<td>$level[1]</td>" : echo "<td>Not set.</td>";
							($level[2] && $level[3])? echo "<td>$level[2] - $level[3]</td>" : echo "<td>Not set.</td>";
							$level[4]? echo "<td>$level[4]</td>" : echo "<td>Not set.</td>";
						*/
						
						echo "<td>$level[0]</td>";
						echo "<td>$level[1]</td>";
						echo "<td>$level[2] - $level[3]</td>";
						echo "<td>$level[4]</td>";
					echo "</tr>";
					}//end foreach
					} else {
					echo "<tr><td colspan='4'>You're missing some skill levels. Subscribe to networks to get started.</td></tr>";
				}//endif
				
				?>
			</tbody>
			
			
			</table>
			
			<br/><br/>
			<h2>Your favorites</h2>
			
			<form id="deFavForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table class="settings regular_table">
			
			<tr>
				<th>Activity</th>
				<th>Unfavorite</th>
			</tr>
			<? $favs = getFavorites(); 
				if (!$favs) 
					echo "<tr><td colspan='2'>Favorite networks to bookmark them in your sidebar.</td></tr>";
				else
				foreach($favs as $fav):
			?>
					<tr>
						<td><? echo $fav ?></td>
						<td><input type='checkbox' value='<? echo $fav ?>' name='defavorite[]' /></td>
					</tr>
				<? endforeach; ?>
			
			</table>
			<div class="below_table">
				<input style="float:right;margin-right: 100px;" type="submit" name="doDefavorite" value="Remove"/>
			</div>
			</form>
			
			</div><!-- /page -->
			<?php
		}
	else {	 
		//if they are not logged in";
		header("Location: ");
	}
	
	include('footer.php');
?>