<?php
	//I am not sure exactly how to load the stream. If anyone has any thoughts please let me know.
	//Will be looking into it, but for now this is a skeleton of how to load a stream.
	//Given an activity ID or a network ID (the tabs of our streams) this will generate
	//that stream
	$networkID = 1;		//This would be oakland 	//Below I just used the string
	$activityID = 3;	//This would be running		//Oakland and got its ID
	
	/*These numbers are what columns they represent in the connactions table
	*	0 = connaction_id
	*	1 = user_id
	*	2 = location
	*	3 = start_time
	*	4 = message
	*	5 = end_time
	*	6 = activity_id
	*	7 = network_id
	* 	8 = is_private
	*/
	
	include("functions/config.php"); //This needs to be removed when this page is included in home.php
	
	$connactions = getConnactions(getNetworkID("Oakland"), 1); //1 means passing in network id
																//0 would mean passing in activity id
	for($i = count($connactions)-1; $i >= 0; $i--){
		$connactionid = $connactions[$i][0];
		$userID = $connactions[$i][1];
		$location = $connactions[$i][2];
		$startTime = $connactions[$i][3];
		$message = $connactions[$i][4];
		$endTime = $connactions[$i][5];
		$activityID = $connactions[$i][6];
		$networkID = $connactions[$i][7];
		$isPrivate = $connactions[$i][8];
?>
	<div class="post"> <!-- begin post -->
		<div class="post-author">
			<img src="<?php echo getUserPic($userID); ?>" height="120" /><br/>
			<?php echo getName($userID); ?>
		</div>
		<div class="post-body">
			<p><?php
				//TODO: make dates look good
				//$start = date_parse($startTime);
				//$end = date_parse($connactions[$i][5]);
				
				echo "Time: ", $startTime, " to ", $endTime;
				?>
			</p>
			<p><?php echo $message; ?></p>
		<div class="post-levels">
			<p>
				I am a level <?php echo getActivityLevel($userID,$activityID, 3); ?>.
				I prefer level <?php echo getActivityLevel($userID,$activityID, 2); ?>.
				I accept levels <?php echo getActivityLevel($userID,$activityID, 0); ?>-
				<?php echo getActivityLevel($userID,$activityID, 1); ?>.
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
	
	<?php
	}
	?>
