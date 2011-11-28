<? 
	include("header.php");

	if(cookieExists() && validCookie()):
	
		if (isset($_POST['postConnaction'])) {
			postConnaction();
		} else if (isset($_POST['joinRequest'])) { 
			joinRequest();
		}
		
	?>
	<script type="text/javascript">
	
	$(document).ready(function(){
		$('#restOfBoxes').hide();
		
		$('#link_feeds_all').addClass('tab_active');
		
		$('.link_stream').click(function(){
			var id=$(this).attr('id');
			var el=$('#'+id);
			$('.stream').hide();
			$('.link_stream').removeClass('tab_active');
			el.addClass('tab_active');
			$('#stream_' +id).show();
		});

		$('div.post-author').click(function() {
		auth = $(this).text().trim();
		alert("STUB: Going to profile of " +auth.toUpperCase());
		});

		$('.top_links').removeClass('active');
		$('#home').addClass('active');

		$('.joinExpander').click(function(){
		$(this).siblings('.expand').toggle();
		});

		$('#messageBox').click(function(){
			$('#restOfBoxes').slideDown();
		});
		
		$('#startDate').datepicker({ showButtonPanel: true, selectOtherMonths: true, changeMonth: true, changeYear: true, minDate: new Date(0) });
		$('#endDate').datepicker({ showButtonPanel: true, selectOtherMonths: true, changeMonth: true, changeYear: true, minDate: new Date(0) });
	});
	</script>
	
		<div class="page">		
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<div id="postConnaction">
				<div id="postHeader">
					<h2>Post a ConnAction</h2>
				</div>
				<div id="postBoxes">
					<div id="messageBox">Message: <textarea id="message" name="message" placeholder="Say what you're up to!" maxlength="4000"></textarea></div>
					<div id="restOfBoxes">
						Location: <textarea class="small" id="location" placeholder="Where?" name="location" maxlength="255"></textarea>
						<br/><br/>
						Start Time: <input type="text" name="startDate" id="startDate"/> <select name="startHour">
							<option value="-1">Hour:</option>
							<?php
								for($i = 1; $i < 24; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
							</select>:<select name="startMin">
							<option value="-1">Min:</option>
								<?php
								for($i = 0; $i < 60; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
								?>
							</select>
						<br/><br/>
						End Time: <input type="text" name="endDate" id="endDate" /> <select name="endHour">
							<option value="-1">Hour:</option>
							<?php
								for($i = 1; $i < 24; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
							</select>:<select name="endMin">
							<option value="-1">Min:</option>
								<?php
								for($i = 0; $i < 60; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
								?>
							</select>
						<br><br>
						<select name="network">
							<option value="-1">Network:</option>
							<?php
								$networks = getNetworkNames();
								for($i = 0; $i < count($networks); $i++){
									echo "<option value=\"",getNetworkID($networks[$i]), "\">", $networks[$i], "</option>";
								}
							?>
						</select>
						<select name="activity">
							<option value="-1">Activity:</option>
							<?php
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
				
				<br/><br/>
				<h2>Stream</h2>				
					
				<div class="main feeds-container">
					<ul class="feeds">
						<li id="link_feeds_all" class="link_stream"><a href="#">All</a></li>
						<?
						$networkNames = getNetworkNames();
						foreach ($networkNames as $network): ?>
							<li id="<? echo $network; ?>" class="link_stream"><a href="#"><? echo $network; ?></a></li>
							<? endforeach; ?>
					</ul>
						
				 <? $networkNames = getNetworkNames();
						foreach ($networkNames as $network) { ?> 
					
					<div class="stream" id="stream_<? echo $network; ?>"> 
					
				<? $connactions = getConnactions(getNetworkID($network), 1);
					
					if ($connactions) {
					
					foreach($connactions as $post){
						$connactionID = $post[0];
						$postTime = $post[1];
						$userID = $post[2];
						$location = $post[3];
						$startTime = $post[4];
						$message = $post[5];
						$endTime = $post[6];
						$activityID = $post[7];
						$networkID = $post[8];
						$isPrivate = $post[9];
					?>					
						<div class="post"> <!-- begin post -->
							<div class="post-author">
								<img src="<? echo getUserPic($userID); ?>" height="120" /><br/>
								<? echo getUserName($userID) ?>
							</div>
							<div class="post-body"> <!-- begin post body -->
								<p class="quote"><? echo $message; ?></p>
								<? //echo date_format($startTime, 'l, F jS, Y h:i a'); 
									echo $startTime." To ".$endTime?>
							<div class="post-levels">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
									I am a level <?php echo getActivityLevel($userID,$activityID, 3); ?>.
									I prefer level <?php echo getActivityLevel($userID,$activityID, 2); ?>.
									I accept levels <?php echo getActivityLevel($userID,$activityID, 0); ?>-
									<? echo getActivityLevel($userID,$activityID, 1); ?>.
								<br/>
								Open to joiners&nbsp;&raquo;
										<?php 
											if($userID != getUserID()){ 
												if(getApproval($connactionID, getUserID()) == -1){
													echo "Request Pending!";
												}
												else if(getApproval($connactionID, getUserID()) == 2){
													echo getApproval($connactionID, getUserID());
													echo "Request Denied.";
												}
												else if(getApproval($connactionID, getUserID()) == 1){
													echo "Request Accepted!";
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
