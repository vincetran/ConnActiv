<?php 
	include("header.php");

	if(cookieExists() && validCookie()) {
	//var_dump($_POST);					//Check for Dave
	if(isset($_POST['review'])){
		if($_POST['review'][4] == 'on'){$anonymous = 1;} else{$anonymous = 0;}
		$query = "insert into reviews values(".$_POST['review'][2].", ".getUserID().", ".$anonymous.", ".$_POST['review'][1].", ".$_POST['review'][3].", sysdate(), '".$_POST['review'][0]."')";
		
		mysql_query($query) or die(mysql_error());
	}
	else if (isset($_POST['accept'])) {
		if ($_POST['requestID']) {
			$request = $_POST['requestID'];
			foreach($request as $req) { 
				acceptRequest($req);
			} // end foreach
		} //end if ($_POST[subscribeTo])
	}
	else if (isset($_POST['deny'])) {
		if ($_POST['requestID']) {
			$request = $_POST['requestID'];
			foreach($request as $req) {
				denyRequest($req);
			} // end foreach
		} //end if ($_POST[requestID])
	}
			?>
			
<script type="text/javascript">
	$(document).ready(function() {
    $('#incoming').dataTable( {
        "aaSorting": [[ 5, "desc" ]],
        "bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false
   	 });
   	 
   	 $('#pending').dataTable( {
        "aaSorting": [[ 5, "desc" ]],
        "bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false
   	 });
   	 
   	 $('#past').dataTable( {
        "aaSorting": [[ 5, "desc" ]],
        "bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false
   	 });  
   	 
   	 
		$('.top_links').removeClass('active');
		$('#requests').addClass('active');
   
   	$('#view_friendReqs').hide();
   	
   	$('#connactions').click(function() {
   		$(this).addClass('active');
   		$('#friendReqs').removeClass('active');
   		$('#view_friendReqs').hide();
   		$('#view_connactions').fadeIn();
   	});
   	
   	$('#friendReqs').click(function() {
   		$(this).addClass('active');
   		$('#connactions').removeClass('active');
   		$('#view_connactions').hide();
   		$('#view_friendReqs').fadeIn();
   	});
   	 
		});		
</script>			
			
	<div class="page">
	
	<div class="pageViewer">
		<span class="clickable active green" id="connactions">Connaction Requests</span>&nbsp;|&nbsp;
		<span class="clickable green" id="friendReqs">Friend Requests</span>	
	</div>
	
	<div class="requestType" id="view_connactions">

		<h2>Incoming Connaction Requests</h2>
		<h3>People asking to join you</h3>
			<form id="unsubNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="incoming" class="requests regular_table">
			<thead class="reqHeader">
				<tr>
					<th>Status</th>
					<th>User</th>
					<th>Network</th>
					<th>Posted</th>
					<th>ConnAction Date</th>
					<th>Requested</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$incRequests = getIncRequests(getUserID());
					if ($incRequests) {
					
						foreach($incRequests as $incoming){
							$fromUser = $incoming[0];
							$toUser = $incoming[1];
							$connactionID = $incoming[2];
							$message = $incoming[3];
							$approved = $incoming[4];
							$date = date_parse($incoming[5]); 
							$requestID = $fromUser." ".$connactionID;
				?>
							
							<tr> 
								<td>
									<?php 
										//echo "<input type='checkbox' value='".$requestID."' name='requestID[]' /> <br/>"; //Add this line for changing status requests
										if($approved == -1){
											echo "<input type='checkbox' value='".$requestID."' name='requestID[]' /> <br/>"; //Remove this line for changing status requests
											echo "Pending";
										}
										else if($approved == 1){
											echo "Approved";
										}
										else{
											echo "Denied";
										}
									?>
								</td>
								<td><?php echo getUserName($fromUser); ?></td>
								<td><?php echo getConnactionUniqueNetwork($connactionID); ?></td>
								<td><?php echo getConnactionDate($connactionID, "POST"); ?></td>
								<td><?php echo getConnactionDate($connactionID, "START"); ?></td>
								<td><?php echo $date["month"].'/'.$date["day"].'/'.$date["year"]; ?></td>
								<td><?php echo $message; ?></td>
							</tr>
						<?php } 
					}
				?>
			</tbody>
			
			</table>
			<div class="below_table">
				<input style="float:right; margin-left:10px; margin-right:20px" type="submit" name="deny" value="Deny Request(s)"/>
				<input style="float:right;" type="submit" name="accept" value="Accept Request(s)"/>
			</div>
			
			<br/><br/>
			
		<h2>Pending Connaction Requests</h2>
		<h3>Activities you've asked to join</h3>
			
			<table id="pending" class="requests regular_table">
			<thead class="reqHeader">
				<tr>
					<th>Status</th>
					<th>User</th>
					<th>Network</th>
					<th>Posted</th>
					<th>ConnAction Date</th>
					<th>Requested</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$pendingRequests = getPendingRequests(getUserID());
					if ($pendingRequests) {
					
						foreach($pendingRequests as $incoming){
							$fromUser = $incoming[0];
							$toUser = $incoming[1];
							$connactionID = $incoming[2];
							$message = $incoming[3];
							$approved = $incoming[4];
							$date = date_parse($incoming[5]); ?>
				
							<tr>
								<td>
									<?php
										if($approved == -1){
											echo "Pending";
										}
										else if($approved == 1){
											echo "Approved";
										}
										else{
											echo "Denied";
										}
									?>
								</td>
								<td><?php echo getUserName($toUser); ?></td>
								<td><?php echo getConnactionUniqueNetwork($connactionID); ?></td>
								<td><?php echo getConnactionDate($connactionID, "POST"); ?></td>
								<td><?php echo getConnactionDate($connactionID, "START"); ?></td>
								<td><?php echo $date["month"].'/'.$date["day"].'/'.$date["year"]; ?></td>
								<td><?php echo $message; ?></td>
							</tr>
						<?php } 
					}
				?>
			</tbody>
			
			</table>
			
			<br/><br/>
			
		<h2>Attended Connactions</h2>
			
		<table id="past" class="requests regular_table">
			

			
			<thead class="reqHeader">
				<tr>
					<th>Posted By</th>
					<th>Activity</th>
					<th>Date</th>
					<th>Message</th>
					<th>Review</th>
				</tr>
			</thead>
		<?php
			$past = getPastConnactions(getUserID());
			
			foreach($past as $pc){
			echo "<tbody><tr>";

					echo "<td>".getUserName($pc[1])."</td>";
					echo "<td>".getConnactionActivity($pc[0])."</td>";
					echo "<td>".$pc[3]."</td>";
					echo "<td>".$pc[4]."</td>";
				if(ReviewedByUser($pc[0],getUserID()) == false){					
					echo "<td><form id='reviewform' action='".$_SERVER['PHP_SELF']."' method='post'>";
					echo "<input id = 'review' type = 'textbox' name = 'review[]' placeholder='Review this ConnAction	'/><br/>";					
					echo "<input type = 'hidden' name = 'review[]' value = $pc[0] />";
					echo "<input type = 'hidden' name = 'review[]' value = $pc[1] />";
					echo "<input id = 'review' name = 'review[]' type = 'radio' value = 1 />Thumbs Up<input name = 'review[]' type = 'radio' value = 0 />Thumbs Down<br/>";
					echo "<input id = 'review' name = 'review[]' type = 'checkbox'/>Anonymous";		
					echo "<input id = 'review' name = 'review[]' type = 'submit' value = 'Submit Review'/>";
					
					echo "</form></td>";
				}
				else{echo "<td> Review Submitted </td>";}
				/*$attending = getConnactionAttendees(1, getUserID());
							
				foreach($attending as $attendee){
					echo "<td>".getName($attendee[0])."     "."<input id = 'review' type = 'submit' name = 'review[]' value = 'Review this connaction' action = 'post' action = 'review.php'/></td>";
										
				}*/
				echo "</tr></tbody>";
			}
			?>
			
			</table>
			
			</div> <!-- end view_connactions div -->
			
			<div class="requestType" id="view_friendReqs">
			

			<h2>Incoming Friend Requests</h2>
		<h3>People asking to be your friend</h3>
			<form id="unsubNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="incoming" class="requests regular_table">
			<thead class="reqHeader">
				<tr>
					<th>Status</th>
					<th>User</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<!--inbound friend requests go here-->
			</tbody>
			
			</table>
			
			<br/><br/>

			<h2>Pending Friend Requests</h2>
		<h3>People  have asked to be your friend</h3>
			<form id="unsubNetworksForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="incoming" class="requests regular_table">
			<thead class="reqHeader">
				<tr>
					<th>Status</th>
					<th>User</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<!-- outbound friend requests go here -->
			</tbody>
			
			</table>
			
			</div> <!-- end friendReqs div -->


		</div> <!-- end page -->
			
			<?
		}
 		include('footer.php');
?>
