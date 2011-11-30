<? 
	include("header.php");

	if(cookieExists() && validCookie()):
	
		if (isset($_POST['postConnaction'])) {
			postConnaction();
		} else if (isset($_POST['joinRequest'])) { 
			joinRequest();
		} else if (isset($_POST['postEvent'])) {
			postEvent();
		} else if(isset($_POST['friend'])){
			$query = "insert into friend_requests values (".getUserID().", ".$_POST['friend'][2].", '".$_POST['friend'][0]."', 1)";
			mysql_query($query) or die(mysql_error());
		}	else if(isset($_POST['reply'])){
				message();	
		}
			
		
	?>
	<script type="text/javascript">
	
	$(document).ready(function(){
		$('#restOfBoxes').hide();
		
		$('#all').addClass('tab_active');
		$('#stream_all').show();
		
		$('.link_stream').click(function(e){
			e.preventDefault();
			var id=$(this).attr('id');
			var el=$('#'+id);
			$('.stream').hide();
			$('.link_stream').removeClass('tab_active');
			el.addClass('tab_active');
			$('#stream_' +id).show();
		});

		$('div.post-author').click(function() {
		author_display = $(this).children('.hidden').val();

		$.fancybox(author_display,
		{
      'autoDimensions'	: true,
			'width'         	: 450,
			'height'        	: 'auto',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		});

		});

		$('.top_links').removeClass('active');
		$('#home').addClass('active');

		$('.joinExpander').click(function(){
			$(this).siblings('.expand').toggle();
		});

		$('#messageBox').click(function(){
			$('#restOfBoxes').slideDown();
		});
		
		$('#eventExpander').click(function() {
			$('#createEvent').toggle();
		});
		
		$('#startDate').datepicker({ showButtonPanel: true, selectOtherMonths: true, changeMonth: true, changeYear: true, minDate: new Date(0) });
		$('#endDate').datepicker({ showButtonPanel: true, selectOtherMonths: true, changeMonth: true, changeYear: true, minDate: new Date(0) });
		
		$('#eventStartDate').datepicker({ showButtonPanel: true, selectOtherMonths: true, changeMonth: true, changeYear: true, minDate: new Date(0) });
		$('#eventEndDate').datepicker({ showButtonPanel: true, selectOtherMonths: true, changeMonth: true, changeYear: true, minDate: new Date(0) });

		
	});
	</script>
	
		<div class="page">
		
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<div class="greyBorder" id="postConnaction">
				<div id="postHeader">
					<h2>Post a ConnAction</h2>
				</div>
				<div id="postBoxes">
					<div id="messageBox">Message: <textarea id="message" name="message" placeholder="Say what you're up to!" maxlength="4000"></textarea></div>
					<div id="restOfBoxes">
						Location: <textarea class="small" id="location" placeholder="Where?" name="location" maxlength="255"></textarea><br/><br/>
						Starting: <input class="small_input" type="text" name="startDate" id="startDate"/> <select name="startHour">
							<option value="-1">Hour:</option><? for($i = 1; $i < 24; $i++) echo "<option value=\"",$i,"\">", $i, "</option>";	?>
							</select>:<select name="startMin"><option value="-1">Min:</option><? for($i = 0; $i < 60; $i++) echo "<option value=\"",$i,"\">", $i, "</option>";	?></select><br/><br/>
						Ending: <input type="text" class="small_input" name="endDate" id="endDate" /> <select name="endHour">
							<option value="-1">Hour:</option>
							<? for($i = 1; $i < 24; $i++) echo "<option value=\"",$i,"\">", $i, "</option>"; ?>
							</select>:<select name="endMin">
							<option value="-1">Min:</option><? for($i = 0; $i < 60; $i++) echo "<option value=\"",$i,"\">", $i, "</option>"; ?></select><br><br>
						<select name="network">
						<option value="-1">Network:</option>
							<?
								$networks = getNetworkNames();
								for($i = 0; $i < count($networks); $i++){
									echo "<option value=\"",getNetworkID($networks[$i]), "\">", $networks[$i], "</option>";
								}
							?>
						</select>
						<select name="activity">
							<option value="-1">Activity:</option>
							<?
								$activities = getUserActivities();
								for($i = 0; $i < count($activities); $i++){
									echo "<option value=\"",getActivityID($activities[$i]), "\">", $activities[$i], "</option>";
								}
							?>
						</select>
						<select name="private">
							<option value="-1">Private:</option>
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<input class="button" type="submit" name="postConnaction" value="Post this connaction!"/>
					</div>
				</div>
			</div>
			</form>
			
			<span id="eventExpander">Or <span class="clickExpand">create an event &raquo;</span></span>
			
			<div class="greyBorder" style="display:none" id="createEvent">
			
				<form id="createEventForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
				
				<span class="realgreen">Submit your event details.</span><br/>
				Once we verify that it is a legitimate event, we'll post it on your behalf.<br/><br/>
				
				Description: <textarea class="small" id="eventMsg" placeholder="Tell us a little about your event." name="eventMsg" maxlength="4000"></textarea><br/><br/>
				Location: <textarea class="small" id="eventLoc" placeholder="Where?" name="eventLoc" maxlength="255"></textarea><br/><br/>
				Starting: <input type="text" class="small_input" name="eventStartDate" id="eventStartDate"/> <select name="eventStartHour"><option value="-1">Hour:</option><? for($i = 1; $i < 24; $i++) echo "<option value=\"",$i,"\">", $i, "</option>";	?></select>
					:<select name="eventStartMin"><option value="-1">Min:</option><? for($i = 0; $i < 60; $i++) echo "<option value=\"",$i,"\">", $i, "</option>";	?></select><br/><br/>
				Ending: <input type="text" class="small_input" name="eventEndDate" id="eventEndDate" /> <select name="eventEndHour"><option value="-1">Hour:</option>
					<? for($i = 1; $i < 24; $i++) echo "<option value=\"",$i,"\">", $i, "</option>"; ?></select> :<select name="eventEndMin">
					<option value="-1">Min:</option><? for($i = 0; $i < 60; $i++) echo "<option value=\"",$i,"\">", $i, "</option>"; ?></select><br><br>	
					<select name="eventNetwork">
						<option value="-1">Network:</option>
							<?
								$networks = getNetworkNames();
								for($i = 0; $i < count($networks); $i++){
									echo "<option value=\"",getNetworkID($networks[$i]), "\">", $networks[$i], "</option>";
								}
							?>
						</select>
						<select name="eventActivity">
							<option value="-1">Activity:</option>
							<?
								$activities = getUserActivities();
								for($i = 0; $i < count($activities); $i++){
									echo "<option value=\"",getActivityID($activities[$i]), "\">", $activities[$i], "</option>";
								}
							?>
						</select>
								
				<input class="button" type="submit" name="postEvent" value="Submit"/>
				</form>
			
			</div>
				
				<br/><br/>
				<h2>Stream</h2>				
					
				<div class="main feeds-container">
					<ul class="feeds">
						
				<?  $names = getUserUniqueNetworks();
						foreach ($names as $network): 
						
						$displayName = "".$network[1].", ".$network[2]." - ".$network[3]."";
						
						?>
							<li id="<? echo $network[0]; ?>" class="link_stream"><a href="#"><? echo $displayName; ?></a></li>
							<? endforeach; ?>
						<li id="events" class="link_stream"><a href="#">Events</a></li>
						<li id="all" class="link_stream"><a href="#">All</a></li>
					</ul>
					
					<div class="stream" id="stream_events">
						<p><br/>No data yet.<br/></p>
					</div>
					
					<div class="stream" id="stream_all">
					
				<? $allConnactions = getAllConnactions();
				
				if ($allConnactions) {
					
					foreach($allConnactions as $post){
						$connactionID = $post[0];
						$postTime = $post[1];
						$userID = $post[2];
						$location = $post[3];
						$startTime = $post[4];
						$message = $post[5];
						$endTime = $post[6];
						$unique_network_ID = $post[7];
						$isPrivate = $post[8];
						$act = mysql_query("select activity_id from unique_networks where unique_network_id = ".$unique_network_ID);
						$net = mysql_query("select network_id from unique_networks where unique_network_id = ".$unique_network_ID);
						$net1 = mysql_fetch_array($net);
						$act1 = mysql_fetch_array($act);
						$networkID = $net1[0];
						$activityID = $act1[0];
					?>					
						<div class="post"> <!-- begin post -->
							<div class="post-author">
							
							<? 
							
								$details = getProfile($userID);
								$src = getUserPic($userID);
							  $uname = getUserName($userID);
							
							?>
								<input type="hidden" class="hidden" value="<? echo $details; ?>" />
								<img src="<? echo $src ?>" height="120"/><br/>
								<? echo $uname ?>
							</div>
							<div class="post-body"> <!-- begin post body -->
								<p class="quote"><? echo $message; ?></p>
								<? //echo date_format($startTime, 'l, F jS, Y h:i a'); 
									echo $startTime." - ".$endTime?>
							<div class="post-levels">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
							<?
							$self = getActivityLevel($userID,$activityID, 3);
							$prefer = getActivityLevel($userID,$activityID, 2);
							$accept_low = getActivityLevel($userID,$activityID, 0);
							$accept_high = getActivityLevel($userID,$activityID, 1);
							
							if ($self) echo "Level $self. ";
							if ($prefer) echo "Seeking level $prefer. ";
							if ($accept_low && $accept_high) echo "Cool with levels $accept_low - $accept_high.";
							?>
																
								<br/>
								Open to joiners&nbsp;&raquo;
										<?php 
											if($userID != getUserID()){ 
												if(getApproval($connactionID, getUserID()) == -1){
													echo "<span class='request_pending'>Request pending!</span>";
												}
												else if(getApproval($connactionID, getUserID()) == 2){
													//echo getApproval($connactionID, getUserID());
													echo "<span class='request_denied'>Request denied.</span>";
												}
												else if(getApproval($connactionID, getUserID()) == 1){
													echo "<span class='request_accepted'>Request accepted!</span>";
												}
												//else if(check cur date and end date){
												//	$echo "ConnAction Is Over!";
												//}
												else{?>
													<span class="clickable joinExpander">Ask to join</span>
													
													<div class="expand" style="display:none">
														<input type="hidden" name="connactionID" value="<?= $connactionID?>"/>
														<input type="hidden" name="postingUserID" value="<?= $userID?>"/>
														<textarea name="message" maxlength="255" style="width:80%;" class="small" placeholder="Hi! I was hoping to join your activity."></textarea><br/>
														<input type="checkbox" name="releaseEmail"/>Release Email to user<br/>
														<input type="checkbox" name="releasePhone"/>Release Phone Number to User		
														<input type="submit" class="join" name="joinRequest" value="Send"/>
													</div>
											<?php } ?>
										<?php } ?>
									</form>					
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li><?php echo getActivity($activityID); ?></li>
										<li><?php echo getNetworkName($networkID); ?></li>
									</ul><!-- end tags -->
							<br/>

							</div><!-- end post-body -->
						</div><!-- end post -->
		<?		}		//end foreach($post) ?>
	<?  } else echo "<br/>No connactions yet!<br/><br/>";
				
				?> 
				</div> <!-- end allConnactions -->


				 <? $names = getUserUniqueNetworks();
					foreach ($names as $network) { 
					?> 
					
					<div class="stream" id="stream_<? echo $network[0]; ?>"> 
					
				<? $connactions = getConnactionsByUnique($network[0]);
					
					if ($connactions) {
					
					foreach($connactions as $post){
						$connactionID = $post[0];
						$postTime = $post[1];
						$userID = $post[2];
						$location = $post[3];
						$startTime = $post[4];
						$message = $post[5];
						$endTime = $post[6];
						$unique_network_ID = $post[7];
						$isPrivate = $post[8];
						$act = mysql_query("select activity_id from unique_networks where unique_network_id = ".$unique_network_ID);
						$net = mysql_query("select network_id from unique_networks where unique_network_id = ".$unique_network_ID);
						$net1 = mysql_fetch_array($net);
						$act1 = mysql_fetch_array($act);
						$networkID = $net1[0];
						$activityID = $act1[0];
					?>					
						<div class="post"> <!-- begin post -->
							<div class="post-author">
							
							<? 
							
								$details = getProfile($userID);
								$src = getUserPic($userID);
							  $uname = getUserName($userID);
							
							?>
								<input type="hidden" class="hidden" value="<? echo $details; ?>" />
								<img src="<? echo getUserPic($userID); ?>" height="120"/><br/>
								<? echo getUserName($userID) ?>
							</div>
							<div class="post-body"> <!-- begin post body -->
								<p class="quote"><? echo $message; ?></p>
								<? //echo date_format($startTime, 'l, F jS, Y h:i a'); 
									echo $startTime." - ".$endTime?>
							<div class="post-levels">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
									<?
							$self = getActivityLevel($userID,$activityID, 3);
							$prefer = getActivityLevel($userID,$activityID, 2);
							$accept_low = getActivityLevel($userID,$activityID, 0);
							$accept_high = getActivityLevel($userID,$activityID, 1);
							
							if ($self) echo "Level $self. ";
							if ($prefer) echo "Seeking level $prefer. ";
							if ($accept_low && $accept_high) echo "Cool with levels $accept_low - $accept_high.";
							?>
								<br/>
								Open to joiners&nbsp;&raquo;
										<?php 
											if($userID != getUserID()){ 
												if(getApproval($connactionID, getUserID()) == -1){
													echo "<span class='request_pending'>Request pending!</span>";
												}
												else if(getApproval($connactionID, getUserID()) == 2){
													//echo getApproval($connactionID, getUserID());
													echo "<span class='request_denied'>Request denied.</span>";
												}
												else if(getApproval($connactionID, getUserID()) == 1){
													echo "<span class='request_accepted'>Request accepted!</span>";
												}
												//else if(check cur date and end date){
												//	$echo "ConnAction Is Over!";
												//}
												else{?>
													<span class="clickable joinExpander">Ask to join</span>
													
													<div class="expand" style="display:none">
														<input type="hidden" name="connactionID" value="<?= $connactionID?>"/>
														<input type="hidden" name="postingUserID" value="<?= $userID?>"/>
														<textarea name="message" maxlength="255" style="width:80%;" class="small" placeholder="Hi! I was hoping to join your activity."></textarea>
														<input type="submit" class="join" name="joinRequest" value="Send"/>
													</div>
											<?php } ?>
										<?php } ?>
									</form>					
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li><?php echo getActivity($activityID); ?></li>
										<li><?php echo getNetworkName($networkID); ?></li>
									</ul><!-- end tags -->
							<br/>

							</div><!-- end post-body -->
						</div><!-- end post -->
		<?		}		//end foreach($post) ?>
	<?  } else echo "<br/>No connactions yet!<br/><br/>"; ?>
	
	</div><!-- end stream for $network -->
	<? } // end foreach($network)
	echo "</div>"; // end main feeds-container
	echo "</div>"; // end page
	?> 
	
<? endif; ?>

<? include('footer.php'); ?>
