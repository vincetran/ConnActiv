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
	
	include("config.php"); //This needs to be removed when this page is included in home.php
	
	$connactions = getConnactions(getNetworkID("Oakland"), 1); //1 means passing in network id
																//0 would mean passing in activity id
	for($i = count($connactions)-1; $i >= 0; $i--){
	
?>
	<div class="post"> <!-- begin post -->
		<div class="post-author">
			<img src="public/images/face1.png" height="120" /><br/>
			<?php echo getName($connactions[$i][1]); ?>
		</div>
		<div class="post-body">
			<p><?php
				//TODO: make dates look good
				//$start = date_parse($connactions[$i][3]);
				//$end = date_parse($connactions[$i][5]);
				
				$start = $connactions[$i][3];
				$end = $connactions[$i][5];
				
				echo "Time: ", $start, " to ", $end;
				
			?></p>
			<p><?php echo $connactions[$i][4]; ?></p>
		<div class="post-levels">
			<p>I am a 6-7 seeking levels 4-8 accepting levels 3-8.</p>
			<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>					
		</div><!-- begin tags -->
		<br/>
				Tags:
				<ul class="tags">
					<li><?php echo getActivity($connactions[$i][6]); ?></li>
					<li><?php echo getNetworkName($connactions[$i][7]); ?></li>
				</ul><!-- end tags -->
		</div><!-- end post-body -->
	</div><!-- end post -->
	
	<?php
	}
	?>