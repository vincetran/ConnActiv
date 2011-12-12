<? 
	include("header.php");

	if(cookieExists() && validCookie()):
	
		if (isset($_POST['postConnaction'])) {
			if(getUserID() != "2"){
				postConnaction();
			}
			else{echo "<div class = 'demo'>You are unable to post connactions in Demo mode.</div>";}

		} else if (isset($_POST['joinRequest'])) { 
			if(getUserID() != "2"){
				joinRequest();
			}
			else{echo "<div class = 'demo'>You are unable to join connactions in Demo mode.</div>";}
		} else if (isset($_POST['postEvent'])) {
			if(getUserID() != "2"){
				postEvent();
			}
			else{echo "<div class = 'demo'>You are unable to post events in Demo mode.</div>";}
		} else if(isset($_POST['friend'])){
			if(getUserID() != "2"){

				$query = "insert into friend_requests values (".getUserID().", ".mysql_real_escape_string($_POST['friend'][2]).", '".mysql_real_escape_string($_POST['friend'][0])."', -1)";

				mysql_query($query) or die(mysql_error());
			}

			else{echo "<div class = 'demo'>You are unable to request friends in Demo mode.</div>";}

		

		}	else if(isset($_POST['reply'])){
				if(getUserID() != "2"){
					message();	
				}
				else{echo "<div class = 'demo'>You are unable to reply to messages in Demo mode.</div>";}	
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
			'autoDimensions': true,
			'transitionIn': 'none',
			'transitionOut': 'none'
		});

		});

		$('.top_links').removeClass('active');
		$('#home').addClass('active');

		$('.joinExpander').click(function(){
			$(this).siblings('.expand').toggle();
		});
		
		$('.expander').click(function(){
			$(this).siblings('.expand').toggle();
		});

		$('#messageBox').click(function(){
			$('#restOfBoxes').slideDown();
		});
		
		$('#eventExpander').click(function() {
			$('#createEvent').toggle();
		});
		
		$('#startDate').datepicker({ 
			showOtherMonths:true, 
			selectOtherMonths: true, 
			changeMonth: true, 
			changeYear: true, 
			minDate: 0,
			yearRange: "-0:+1"
		});
		
		$('#endDate').datepicker({ 
			showOtherMonths:true, 
			selectOtherMonths: true, 
			changeMonth: true, 
			changeYear: true, 
			minDate: 0 ,
			yearRange: "-0:+1"
		});
		
		$('#eventStartDate').datepicker({ 
			showOtherMonths:true, 
			selectOtherMonths: true, 
			changeMonth: true, 
			changeYear: true, 
			minDate: 0,
			yearRange: "-0:+1" 
		});
		
		$('#eventEndDate').datepicker({ 
			showOtherMonths:true, 
			selectOtherMonths: true, 
			changeMonth: true, 
			changeYear: true, 
			minDate: 0,
			yearRange: "-0:+1" 
		});


		$('#opts input').click(function() {
			el = $(this);
			id = el.attr('id');
			corresponding = $('li.' +id);
			if (el.is(':checked')) {
				corresponding.show();
			} else {
				corresponding.hide();
			}			
		});		
	
	close_details = $("<span class='clickable close'></span>").click(function() {
		$(this).parent('.details_question').fadeOut();
	});
	
	$('div.question').click(function() {
		$('div.details_question').fadeOut('slow');
		id = $(this).attr('id');
		$('#details_'+id).append(close_details).fadeIn('slow');
	});

	});
	</script>
	
		<div class="page">
		
<? if (isDemo()): ?>		
	<div id="demoConnaction" class="question" style="right:-560px;top:50px"></div>
	<div id="details_demoConnaction" class="details_question" style="display:none;right:10px;top:50px">Feel like going for a run but want a running buddy? Or do you want to go rock climbing but you're new in town? Go ahead and <span class="blue">post a connaction!</span> A ConnAction is an activity. When you want to do something in a particular area, post a connaction to let other people know about it. Tag your connaction so that the people who are interested in similar things will be able to view it. Make it open to joiners if you'd like company!</div>
<? endif; ?>

			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<div class="greyBorder" id="postConnaction">
				<div id="postHeader">
					<h2>Post a ConnAction</h2>
				</div>
				<div id="postBoxes">
					<div id="messageBox">Message: <textarea id="message" name="message" placeholder=" Say what you're up to!" maxlength="4000"></textarea></div>
					<div id="restOfBoxes">
						Location: <textarea class="small" id="location" placeholder=" Where?" name="location" maxlength="255"></textarea><br/><br/>
						Starting: <input class="small_input" type="text" name="startDate" id="startDate"/> <select name="startHour">
							<option value="-1">Hour</option>
								<? for($i = 1; $i < 24; $i++)
									if( $i < 10){
										echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
									}
									else{
										echo "<option value=\"",$i,"\">", $i, "</option>";
									}
								?>
							</select> : <select name="startMin"><option value="-1">Min</option>
								<? for($i = 0; $i < 60; $i+=15)
									if( $i < 10){
										echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
									}
									else{
										echo "<option value=\"",$i,"\">", $i, "</option>";
									}
								?>
							</select><br/><br/>
						Ending: <input type="text" class="small_input" name="endDate" id="endDate" /> <select name="endHour">
							<option value="-1">Hour</option>
							<? for($i = 1; $i < 24; $i++)
									if( $i < 10){
										echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
									}
									else{
										echo "<option value=\"",$i,"\">", $i, "</option>";
									}
								?>
							</select> : <select name="endMin">
							<option value="-1">Min</option>
								<? for($i = 0; $i < 60; $i+=15)
									if( $i < 10){
										echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
									}
									else{
										echo "<option value=\"",$i,"\">", $i, "</option>";
									}
								?>
							</select><br><br>
						<? echo getUniqueAsSelect() ?>
						<select name="private">
							<option value="-1">Private</option>
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<input class="button" type="submit" name="postConnaction" value="Submit"/>
					</div>
				</div>
			</div>
			</form>
			
			<span id="eventExpander">Or <span class="clickExpand">create an event &raquo;</span></span>
			
			<div class="greyBorder" style="display:none" id="createEvent">
			
				<form id="createEventForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
				
				<span class="realgreen">Submit your event details.</span><br/>
				Once we approve your event, we'll post it on your behalf.<br/><br/>
				Name: <input type="text" class="small" id="eventName" placeholder="Give it a name!" name="eventName" maxlength="255"><br/><br/>
				Description: <textarea class="small" id="eventMsg" placeholder=" Tell us a little about your event." name="eventMsg" maxlength="4000"></textarea><br/><br/>
				Location: <textarea class="small" id="eventLoc" placeholder=" Where?" name="eventLoc" maxlength="255"></textarea><br/><br/>
				Starting: <input type="text" class="small_input" name="eventStartDate" id="eventStartDate"/> <select name="eventStartHour"><option value="-1">Hour</option>
				<? for($i = 1; $i < 24; $i++)
					if( $i < 10){
						echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
					}
					else{
						echo "<option value=\"",$i,"\">", $i, "</option>";
					}	
				?></select>
					: <select name="eventStartMin"><option value="-1">Min</option>
					<? for($i = 0; $i < 60; $i+=15)
						if( $i < 10){
							echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
						}
						else{
							echo "<option value=\"",$i,"\">", $i, "</option>";
						}
					?></select><br/><br/>
				Ending: <input type="text" class="small_input" name="eventEndDate" id="eventEndDate" /> <select name="eventEndHour"><option value="-1">Hour</option>
					<? for($i = 1; $i < 24; $i++)
						 if( $i < 10){
							echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
						}
						else{
							echo "<option value=\"",$i,"\">", $i, "</option>";
						}
					?></select> : <select name="eventEndMin">
					<option value="-1">Min</option>
					<? for($i = 0; $i < 60; $i+=15)
					 	if( $i < 10){
							echo "<option value=\"0",$i,"\">", "0".$i, "</option>";
						}
						else{
							echo "<option value=\"",$i,"\">", $i, "</option>";
						}
					 ?></select><br><br>	
				<? //eventNetwork, eventActivity as IDs
					
					echo getUniqueAsSelect() ?>
								
				<input class="button" type="submit" name="postEvent" value="Submit"/>
				</form>
			
			</div>
				
				<br><br>
				<h2>Stream</h2>
				
				<? if (isDemo()): ?>	
					<div id="stream" class="question" style="left:50px;top:0px"></div>
					<div id="details_stream" class="details_question" style="left:0px;display:none">Your <span class="blue">stream</span> is where you'll find the most recent connaction posts from all of your subscribed networks. To see more posts,<br>subscribe to more networks (under Settings).</div>
				<? endif; ?>
				
				<div class="main feeds-container">
					<ul class="feeds">
						
				<?  $networkNames = array();
						$networkIDs = array();
				
						$names = getUserUniqueNetworks();
					foreach ($names as $network): 
						
						$displayName = "".$network[1].", ".$network[2]." - ".$network[3]."";
						
						$networkNames[] = $displayName;
						$networkIDs[] = $network[0];
						
						?>
							<li id="<? echo $network[0]; ?>" class="link_stream displayUnique"><a href="#"><? echo $displayName; ?></a></li>
							<? endforeach; ?>
						<li id="events" class="link_stream displayEvents"><a href="#">Events</a></li>
						<li id="all" class="link_stream displayAll"><a href="#">All</a></li>
					</ul>
					
					<div class="stream displayEvents" id="stream_events">
						<?
							for($i=0; $i<count($networkIDs); $i++) {
								
								$name = $networkNames[$i]; 
								$n_id = $networkIDs[$i]; //these are unique network ids
								
								$networkEvents= getEventsForUniqueNetwork($n_id);
								
								if (count($networkEvents)>0) {
									foreach($networkEvents as $e) {
									
										$start = new DateTime($e[5]);
										$startDate = $start->format('l, m-d-y H:i a');
										$end = new DateTime($e[6]);
										$endDate = $end->format('l, m-d-y H:i a');
									
										echo "<div class='post'>";
										echo "<h3>".$e['NAME']."</h3>";
										echo "$startDate until $endDate<br>";
										echo "Location: $e[7]<br>";
										echo "Details: $e[4]<br>";
										echo "</div>";
									}
								} else {
									echo "<div class='post'>No events for network $name.</div>";
								}
							
								
							}
						?>
					</div>
					
					<div class="stream displayAll" id="stream_all">
					
				<? $allConnactions = getAllConnactions();
				
				if ($allConnactions) {
					
					foreach($allConnactions as $post){
						$connactionID = $post[0];
						$postTime = $post[1];
						$userID = $post[2];
						$location = $post[3];
						//$startTime = $post[4];
						$startTime = getConnactionDateTime($connactionID, "START");
						$message = $post[5];
						//$endTime = $post[6];
						$endTime = getConnactionDateTime($connactionID, "END");
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
								<img src="<? echo $src ?>" height="90"/><br/>
								<? echo $uname ?>
							</div>
							<div class="post-body"> <!-- begin post body -->
								<p class="quote"><? echo $message; ?></p>
								<? echo $startTime." - ".$endTime ?><br>
								<? echo $location ?><br/>
							<div class="post-levels">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
							<?
							$self = getActivityLevel($userID,$activityID, 3);
							$prefer = getActivityLevel($userID,$activityID, 2);
							$accept_low = getActivityLevel($userID,$activityID, 0);
							$accept_high = getActivityLevel($userID,$activityID, 1);
							
							if ($self) echo "Level $self. ";
							if ($accept_low && $accept_high) echo "Seeking levels $accept_low - $accept_high.&nbsp";
							if ($prefer) echo "$prefer preferred. ";
							?>
								Open to joiners&nbsp;&raquo;
										<?php 
											if($userID != getUserID()){// && !datePassed($post[6])){ 
												if(datePassed($post[6])){
													echo "<span class='request_denied'>ConnAction ended.</span>";
												}
												else if(getApproval($connactionID, getUserID()) == -1){
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
														<input type="checkbox" name="releaseEmail"/>&nbsp;Release email to user<br/>
														<input type="checkbox" name="releasePhone"/>&nbsp;Release phone number to user		
														<input type="submit" class="join" name="joinRequest" value="Send"/>
													</div>
											<?php } ?>
										<?php } ?>
<?php
												if($userID == getUserID()){// && !datePassed($post[6])){ 
												if(datePassed($post[6])){
													echo "<span class='request_denied'>ConnAction ended.</span>";
												}
												
											
												
												//else if(check cur date and end date){
												//	$echo "ConnAction Is Over!";
												//}
												
										 } ?>
									</form>					
							</div><!-- begin tags -->
							<br/>
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
						//$startTime = $post[4];
						$startTime = getConnactionDateTime($connactionID, "START");
						$message = $post[5];
						//$endTime = $post[6];
						$endTime = getConnactionDateTime($connactionID, "END");
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
								<img src="<? echo getUserPic($userID); ?>" height="90"/><br/>
								<? echo getUserName($userID) ?>
							</div>
							<div class="post-body"> <!-- begin post body -->
								<p class="quote"><? echo $message; ?></p>
								<? echo $startTime." - ".$endTime ?><br>
								<? echo $location ?><br/>
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
								Open to joiners&nbsp;&raquo;
										<?php 
											if($userID != getUserID()){
												if(datePassed($post[6])){
													echo "<span class='request_denied'>ConnAction ended.</span>";
												}
												else if(getApproval($connactionID, getUserID()) == -1){
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
										<?php } 
													if($userID == getUserID()){// && !datePassed($post[6])){ 
												if(datePassed($post[6])){
													echo "<span class='request_denied'>ConnAction ended.</span>";
												}
												
											
												
												//else if(check cur date and end date){
												//	$echo "ConnAction Is Over!";
												//}
												
										 } ?>
									</form>					
							</div><!-- begin tags -->
							<br/>
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
