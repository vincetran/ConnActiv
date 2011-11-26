<?php 
	include("config.php");

	if(cookieExists() && validCookie()) {
			?>
			
<script type="text/javascript">
	$(document).ready(function() {
    $('#incoming').dataTable( {
        "aaSorting": [[ 2, "desc" ]],
        "bPaginate": false,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false
   	 });
   	 
   	 $('#pending').dataTable( {
        "aaSorting": [[ 2, "desc" ]],
        "bPaginate": false,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false
   	 });
   	 
   	 $('#past').dataTable( {
        "aaSorting": [[ 2, "desc" ]],
        "bPaginate": false,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false
   	 });  	 
   	 
   	 
		});		
</script>			
			
	<div class="page">

		<h2>Incoming Requests</h2>
		<h3>People asking to join you</h3>
			
			<table id="incoming" class="requests regular_table">
			<thead>
				<tr>
					<th>User</th>
					<th>Activity</th>
					<th>Location</th>
					<th>ConnAction Posted Date</th>
					<th>ConnAction Date</th>
					<th>Request Date</th>
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
							$date = date_parse($incoming[5]); ?>
				
							<tr> <!-- TODO: make these editable and auto-populating -->
								<td><?php echo getUserName($fromUser); ?></td>
								<td><?php echo getConnactionActivity($connactionID); ?></td>
								<td><?php echo getConnactionNetwork($connactionID); ?></td>
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
			
		<h2>Pending Requests</h2>
		<h3>Activities you've asked to join</h3>
			
			<table id="pending" class="requests regular_table">
			<thead>
				<tr>
					<th>User</th>
					<th>Activity</th>
					<th>Location</th>
					<th>ConnAction Posted Date</th>
					<th>ConnAction Date</th>
					<th>Request Date</th>
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
				
							<tr> <!-- TODO: make these editable and auto-populating -->
								<td><?php echo getUserName($toUser); ?></td>
								<td><?php echo getConnactionActivity($connactionID); ?></td>
								<td><?php echo getConnactionNetwork($connactionID); ?></td>
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
			
		<h2>Past Requests</h2>
			
		<table id="past" class="requests regular_table">
			
		<?php
			$past = getPastConnactions(getUserID());
			
			
			
			echo "<thead>";
				echo "<tr>";
					echo "<th>User</th>";
					echo "<th>Activity</th>";
					echo "<th>Date</th>";
					echo "<th>Message</th>";
					echo "<th>Review</th>";
				echo "</tr>";
			echo "</thead>";
			foreach($past as $pc){
			echo "<tbody>";
											
						
								
									$attending = getConnactionAttendees(1, getUserID());
									echo "<tr>";			
									foreach($attending as $attendee){
										echo "<td>".getName($attendee[0])."     "."<input id = 'review' type = 'submit' name = 'review[]' value = 'Review this connaction' action = 'post' action = 'review.php'/></td>";
										
									}
									echo "</tr>";

								
			echo "</tbody>";
			}
			?>
			
			</table>
			
			<br/><br/>
			
		<div id="footer">&copy; 2011; Kim Cooperrider &middot; Rob Filippi &middot; Dave Johnson &middot; Vince Tran &middot; Ray Wang</div>
		</div> <!-- end page -->
			
			<?
		}
 		
?>
