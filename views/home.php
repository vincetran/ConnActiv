<?php 
	include("config.php");

	//Checks if there is a login cookie
	if(cookieExists())
	//if there is a username cookie, we need to check it against our password cookie
	{ 
		if (!validCookie()) {
			//Cookie doesn't match password go to index
			header("Location: ../index.html"); 
		}
		else{
			//Cookie matches, show what they want
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
			<table id="postConnaction">
				<tr>
					<td colspan="4">
						<h3>Post a Connaction:</h3>
					</td>
				</tr>
				<tr>
					<td>Message:</td>
					<td colspan="3"><textarea id="message" name="message" maxlength="4000"/></td>
				</tr>
				<tr>
					<td>Location:</td>
					<td colspan="3"><textarea class="small" id="location" name="location" maxlength="255"/></td>
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
						<?php 
						$networkNames = getNetworkNames();
						for($i = 0; $i  < count($networkNames); $i++){
							?>
							<li id="link_feeds_<?php $networkNames[$i]; ?>"><a href="#"><?php echo $networkNames[$i]; ?></a></li>
							<?php
						}
						?>
					</ul>
						<div class="post"> <!-- begin post -->
							<div class="post-author">
								<img src="public/images/avatar.png" height="120" /><br/>
								Anita Napp
							</div>
							<div class="post-body">
								<p>Needs a running buddy for tmw morning!  8am anyone?</p>
							<div class="post-levels">
								<p>I am a 6-7 seeking levels 4-8 accepting levels 3-8.</p>
								<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>					
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li>Running</li>
										<li>Pittsburgh</li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
					
						<div class="post"><!-- begin post -->
							<div class="post-author">
								<img src="public/images/avatar.png" height="120"/><br/>
								Bob Kelly
							</div>
							<div class="post-body">
								<p>Going to the gym early tomorrow. Gonna get in a great morning workout!</p>
							<!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li>Gym</li>
										<li>Pittsburgh</li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
						
						
							<div class="post"> <!-- begin post -->
							<div class="post-author">
								<img src="public/images/avatar.png" height="120"/><br/>
								Foo Bar
							</div>
							<div class="post-body">
								<p>Wants to play squash tomorrow morning at 10. Looking for a partner.</p>
							<div class="post-levels">
								<p>I am a 6-7 seeking levels 4-8 accepting levels 3-8.</p>
								<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>			
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li>Squash</li>
										<li>Minneapolis</li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
						
						
				</div><!-- end feed container -->
				
			</div><!-- end page-->
		<?php
		}
 		
	}
	else {	 
		//if they are not logged in
		header("Location: ../index.html");
	}
?>