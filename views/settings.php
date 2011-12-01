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
		else if (isset($_POST['saveInfo'])){
				saveInfo();
		}
		
			?>
	<script type="text/javascript">
		$(function() {
		
				$('.top_links').removeClass('active');
				$('#settings').addClass('active');
						
				 $('#addNetwork').dataTable( {
					"aaSorting": [[ 0, "asc" ]],
					"bPaginate": true,
					"bLengthChange": false,
					"bFilter": true,
					"bSort": true,
					"bInfo": true,
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
					 
					$('#defavTable').dataTable( {
					"aaSorting": [[ 0, "asc" ]],
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": true,
					"bSort": true,
					"bInfo": false,
					"bAutoWidth": false,
					"aoColumns": [ null, { "bSortable": false }]
				 });
				 
				 $('#skillsTable').dataTable( {
					"aaSorting": [[ 0, "asc" ]],
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": true,
					"bSort": true,
					"bInfo": false,
					"bAutoWidth": false
				 });
				 
				 
				 $('#expandNetworks').click(function(){
					$('#allNetworks').toggle();   		  		 	   		 
				 });
				 
				 $('#expandAddNewNetwork').click(function() {
					$('#hiddenNewNetwork').toggle();   		 
				 });
				
				$('.editExpander').click(function(){
					$(this).siblings('.expand').toggle();
				});
   		});
   		
   		</script>
			
			<div class="page">
			
			<h2>Your subscribed networks</h2>
			
			<form id="unsubNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="userNetworks" class="alternating regular_table">
				<thead>
				<tr>
					<th>Area</th>
					<th>Activity</th>
					<th>Unsubscribe<span id="unsubscribe" class="checkAll"></span><span id="_unsubscribe" class="uncheckAll"></th>
					<th>Favorite<span id="favorite" class="checkAll"></span><span id="_favorite" class="uncheckAll"></th>
				</tr>
				</thead>
				<tbody>
			<?
				$networks = getUserUniqueNetworks();
				$favs = getFavoriteIDs();	
					foreach($networks as $network) {
						echo "<tr>";
							echo "<td>".$network[1].", ".$network[2]."</td><td>".$network[3]."</td>";
							echo "<td><input type='checkbox' class='unsubscribe' value='".$network[0]."' name='unsubscribeTo[]' /></td>";
							in_array($network[0], $favs)? $checked="checked disabled" : $checked = "";  // if in $favs, checkbox "favorite" is checked
							echo sprintf("<td><input class='favorite' type='checkbox' %s value='%s' name='favorite[]' /></td>", $checked, $network[0]);
						echo "</tr>";
					} //end foreach
			?>
			</tbody>
			</table>
			
			<? if ($networks) { ?>
			<div class="below_table">
				<input style="float:right; margin-left:10px; margin-right:20px" type="submit" name="doFavorite" value="Favorite"/>
				<input style="float:right;" type="submit" name="doUnsubscribe" value="Unsubscribe"/>
			</div>
			<? } ?>
		</form>
			
			<span style="clear:both;<? if ($networks) echo 'margin-top:-1.5em' ?>" class="clickable below_table">Want more updates? <span id="expandNetworks" class="clickExpand">Subscribe to a new network&nbsp;&raquo;</span></span>
			<br/>
			<div class="doExpand" id="allNetworks" style="display:none"><br/>
			<form id="subscribeNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
					<table class="requests regular_table" id="addNetwork">
					<thead>
						<tr>
							<th>Area</th>
							<th>Activity</th>
							<th>Subscribe<span id="subscribe" class="checkAll"></span><span id="_subscribe" class="uncheckAll"></span></th>
						</tr>
					</thead>
					<tbody>
						
						<? $unique = getAllUniqueNetworks(); //row(unique_network_id, area, state, activity_name).
								foreach($unique as $un) {
									echo "<tr><td>". $un[1] .", ". $un[2] ."</td><td>". $un[3] ."</td><td><input class='subscribe' type='checkbox' value='".$un[0]."' name='subscribeTo[]' /></td></tr>";
								}
						?>
						</tbody>
					</table>
					<span class="clickable below_table">Can't find your network?&nbsp;<span class="clickExpand" id="expandAddNewNetwork">Add a new one&nbsp;&raquo;</span></span>
					<input style="float:right; margin-right:15px;margin-top:-1.2em;" class="below_table" type="submit" name="doSubscribe" value="Subscribe"/>
				</form>
				
				<div id="hiddenNewNetwork" style="display:none">
					<form id="createNetworkForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
						Area: <input class="medium_input" type="text" name="area" value="" placeholder="ex: Pittsburgh"/>
						State:  <? echo getStateDropdown() ?>
						Activity: <input class="large_input"type="text" name="activity" value="" placeholder="ex: being awesome"/>
						<input type="submit" name="doAddNetwork" value="Add"/>	
					</form>
				</div>
			
			</div><!-- end #allNetworks -->
			
			<br><br><br>
			<h2>Your skill level preferences</h2>
			<form id="subscribeNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="skillsTable" class="alternating regular_table">
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
				$index =0;
					foreach($levels as $level){
						echo "<tr>";
						echo "<td>$level[0]</td>";
						if($level[1] == NULL){
							echo "<td>
									<span class=\"clickable editExpander\"><span class='editIcon'></span></span>";
						}
						else{
							echo "<td>
									<span class=\"clickable editExpander\">$level[1]<span class='editIcon'></span></span>";
						}	
							echo	"<div class=\"expand\" style=\"display:none\">
											<select name=\"seekLvl$index\">
												<option value=\"-1\">Level</option>";
												for($i = 1; $i <= 10; $i++){
													// i = Row number
													echo "<option value=\"$i $level[0]\">$i</option>";
												}
									echo	"</select>
											<input class=\"button\" type=\"submit\" name=\"saveInfo\" value=\"Save\"/>
										</div>
								</td>";
						if($level[2] == NULL){
							echo "<td>
									<span class=\"clickable editExpander\"><span class='editIcon'></span></span>";
						}
						else{
							echo "<td>
									<span class=\"clickable editExpander\">$level[2]<span class='editIcon'></span> - </span>";
						}
							echo "<div class=\"expand\" style=\"display:none\">
										<select name=\"lowLvl$index\">
												<option value=\"-1\">Level</option>";
												for($i = 1; $i <= 10; $i++){
													echo "<option value=\"$i $level[0]\">$i</option>";
												}
									echo	"</select>
										<input class=\"button\" type=\"submit\" name=\"saveInfo\" value=\"Save\"/>
									</div>";
						if($level[3] == NULL){
							echo "	<span class=\"clickable editExpander\"><span class='editIcon'></span></span>";
						}
						else{
							echo "	<span class=\"clickable editExpander\">$level[3]<span class='editIcon'></span></span>";
						}
							echo " <div class=\"expand\" style=\"display:none\">
										<select name=\"highLvl$index\">
												<option value=\"-1\">Level</option>";
												for($i = 1; $i <= 10; $i++){
													echo "<option value=\"$i $level[0]\">$i</option>";
												}
									echo	"</select>
										<input class=\"button\" type=\"submit\" name=\"saveInfo\" value=\"Save\"/>
									</div>
								</td>";
						if($level[4] == NULL){
							echo "<td>
									<span class=\"clickable editExpander\"><span class='editIcon'></span></span>";
						}
						else{
							echo "<td>
									<span class=\"clickable editExpander\">$level[4]<span class='editIcon'></span></span>";
						}
							echo "<div class=\"expand\" style=\"display:none\">
											<select name=\"ownLvl$index\">
												<option value=\"-1\">Level</option>";
												for($i = 1; $i <= 10; $i++){
													echo "<option value=\"$i $level[0]\">$i</option>";
												}
									echo	"</select>
											<input class=\"button\" type=\"submit\" name=\"saveInfo\" value=\"Save\"/>
										</div>
								</td>";
					echo "</tr>";
					$index++;
					}//end foreach
				
				?>
			</tbody>
			
			
			</table>
			</form>
			<br/><br/>
			<h2>Your favorites</h2>
			
			<form id="deFavForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="defavTable" class="alternating regular_table">
				<thead>
					<tr>
						<th>Activity</th>
						<th>Unfavorite<span id="unfavorite" class="checkAll"></span><span id="_unfavorite" class="uncheckAll"></span></th>
					</tr>
				</thead>
				<tbody>
					<? $favs = getFavorites();
						foreach($favs as $fav):
					?>
							<tr>
								<td><? echo $fav ?></td>
								<td><input type='checkbox' class='unfavorite' value='<? echo $fav ?>' name='defavorite[]' /></td>
							</tr>
						<? endforeach; ?>
				</tbody>
			</table>
			
			<? if ($favs) { ?>
			<div class="below_table">
				<input style="float:right;margin-right:70px;" type="submit" name="doDefavorite" value="Remove"/>
			</div>
			<? } ?>
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