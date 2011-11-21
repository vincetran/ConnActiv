<?php 
	include("config.php");

	if(cookieExists() && validCookie()):
	
		if (isset($_POST['postConnaction'])) { 
			//If user pressed login
			postConnaction();
		}

	?>
			<script type="text/javascript">
				$('header').show();
				$('#side').show();
				
				$('a.join').click(function() {
					t = confirm("Are you sure you want to join?");
					t == true? alert("Your request to join has been sent! The user will contact you if he/she approves.") : alert('No join request made.');
				});
	
				$('a.stream').click(function() {
					type = $(this).attr('id');
					alert("STUB: Sorting to display " +type.toUpperCase()+ " stream only");
				});
				
				$('input.button').click(function() {
					alert("ConnAction submited to database! If it was to the Oakland network you can view it here: \nhttp://localhost/ConnActiv/views/connactions.php");
				});
	
				$('div.post-author').click(function() {
					auth = $(this).text().trim();
					alert("STUB: Going to profile of " +auth.toUpperCase());
				});
	
				$('.top_links').removeClass('active');
				$('#home').addClass('active');
				
				$('#startDate').datepicker();
				$('#endDate').datepicker();

			</script>
				
			<div class="page">
				
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<table class="regular_table" id="postConnaction">
				<tr>
					<td colspan="4">
						<h2>Post a Connaction</h2>
					</td>
				</tr>
				<tr>
					<td>Message:</td>
					<td colspan="3"><textarea id="message" name="message" placeholder="Say what you're up to!" maxlength="4000"/></td>
				</tr>
				<tr>
					<td>Location:</td>
					<td colspan="3"><textarea class="small" id="location" placeholder="Where?" name="location" maxlength="255"/></td>
				</tr>
				<tr>
					<td>Start Time:</td>
					<td><input type="text" id="startDate"/>
					</td>
					<td>
						<select name="startHour">
							<option value="-1">Hour:</option>
							<?php
								for($i = getCurHour(); $i < 24; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
						</select>
						:
					</td>
					<td>
						<select name="startMin">
							<option value="-1">Min:</option>
							<?php
								for($i = getCurMin(); $i < 60; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>End Time:</td>
					<td>
						<input id="endDate" type="text"/>
					</td>
					<td>
						<select name="endHour">
							<option value="-1">Hour:</option>
							<?php
								for($i = 0; $i < 24; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
						</select>
						:
					</td>
					<td>
						<select name="endMin">
							<option value="-1">Min:</option>
							<?php
								for($i = 0; $i < 60; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<select name="network">
							<option value="-1">Network:</option>
							<?php
								$networks = getNetworkNames();
								for($i = 0; $i < count($networks); $i++){
									echo "<option value=\"",getNetworkID($networks[$i]), "\">", $networks[$i], "</option>";
								}
							?>
						</select>
					</td>
					<td>
						<select name="activity">
							<option value="-1">Activity:</option>
							<?php
								$activities = getUserActivities();
								for($i = 0; $i < count($activities); $i++){
									echo "<option value=\"",getActivityID($activities[$i]), "\">", $activities[$i], "</option>";
								}
							?>
						</select>
					</td>
					<td colspan="2">
						<select name="private">
							<option value="-1">Private:</option>
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				<tr>
					<td colspan="4"><input class="button" type="submit" name="postConnaction" value="Post this connaction!"/></td>
				</tr>
			</table>
			</form>
				
				<br/><br/>
				<h3>
				<a class="stream" id="public" href="#public-stream">Public Stream</a> | 
				<a class="stream" id="buddy" href="#buddy-stream">Buddy Stream</a>
				</h3>
				
					
				<div class="main feeds-container">
					<ul class="feeds">
						<li id="link_feeds_all"><a href="#">All</a></li>
						<?
						$networkNames = getNetworkNames();
						foreach ($networkNames as $network){
							?>
							<li id="link_feeds_<? $network; ?>"><a href="#"><? echo $network; ?></a></li>
							<?
						//}
						?>
					</ul>
					
					<? 
					$connactions = getConnactions(getNetworkID($network), 1);
					foreach($connactions as $post){
						$userID = $post[1];
						$location = $post[2];
						$startTime = $post[3];
						$message = $post[4];
						$endTime = $post[5];
						$activityID = $post[6];
						$networkID = $post[7];
						$isPrivate = $post[8];
					?>					
						<div class="post"> <!-- begin post -->
							<div class="post-author">
								<img src="<? echo getUserPic($userID); ?>" height="120" /><br/>
								<? echo getName($userID) ?>
							</div>
							<div class="post-body">
								<p><? echo $message; ?></p>
							<div class="post-levels">
								<p>
									I am a level <?php echo getActivityLevel($userID,$activityID, 3); ?>.
									I prefer level <?php echo getActivityLevel($userID,$activityID, 2); ?>.
									I accept levels <?php echo getActivityLevel($userID,$activityID, 0); ?>-
									<? echo getActivityLevel($userID,$activityID, 1); ?>.
								</p>
								<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>					
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li><?php echo getActivity($activityID); ?></li>
										<li><?php echo getNetworkName($networkID); ?></li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
		<?		}		//end foreach($post) ?> 				
				</div><!-- end feed container -->		
			</div><!-- end page-->
	<?  } // end foreach($network)
endif; ?>