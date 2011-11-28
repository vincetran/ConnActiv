<?php 
	include("header.php");

	if(cookieExists() && validCookie()) {
	if(isset($_POST['review'])){
		if($_POST['review'][4] == 'on'){$anonymous = 1;} else{$anonymous = 0;}
		$query = "insert into reviews values(".$_POST['review'][2].", ".getUserID().", ".$anonymous.", ".$_POST['review'][1].", ".$_POST['review'][3].", sysdate(), '".$_POST['review'][0]."')";
		
		mysql_query($query) or die(mysql_error());
	}
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
   	 
   	 
		$('.top_links').removeClass('active');
		$('#requests').addClass('active');
   	 
   	 
		});		
</script>			
			
	<div class="page">

		<h2>Incoming Requests</h2>
		<h3>People asking to join you</h3>
			
			<table id="incoming" class="requests regular_table">
			<thead class="reqHeader">
				<tr>
					<th>User</th>
					<th>Activity</th>
					<th>Location</th>
					<th>ConnAction Post Date</th>
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
				
							<tr> 
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
			<thead class="reqHeader">
				<tr>
					<th>User</th>
					<th>Activity</th>
					<th>Location</th>
					<th>ConnAction Post Date</th>
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
			echo "<tbody>";
											
						
				echo "<tr>";


					echo "<td>".getUserName($pc[1])."</td>";
					echo "<td>".getConnactionActivity($pc[0])."</td>";
					echo "<td>".$pc[3]."</td>";
					echo "<td>".$pc[4]."</td>";
				if(ReviewedByUser($pc[0],getUserID()) == false){					
					echo "<td><form id='reviewform' action='".$_SERVER['PHP_SELF']."' method='post'>";
					echo "<input id = 'review' type = 'textbox' name = 'review[]' placeholder='Review this ConnAction	'/><br/>";					
					echo "<input type = 'hidden' name = 'review[]' value = $pc[0] />";
					echo "<input type = 'hidden' name = 'review[]' value = $pc[1] />";
					echo "<input id = 'review' name = 'review[]' type = 'radio' value = 1 />Thumbs Up<input name = 'review' type = 'radio' value = 0 />Thumbs Down<br/>";
					echo "<input id = 'review' name = 'review[]' type = 'checkbox'/>Anonymous";		
					echo "<input id = 'review' name = 'review[]' type = 'submit' value = 'Submit Review'/>";
					
					echo "</form></td>";
				}
				else{echo "<td> Review Submitted </td>";}
				/*$attending = getConnactionAttendees(1, getUserID());
							
				foreach($attending as $attendee){
					echo "<td>".getName($attendee[0])."     "."<input id = 'review' type = 'submit' name = 'review[]' value = 'Review this connaction' action = 'post' action = 'review.php'/></td>";
										
				}*/
				echo "</tr>";

								
			echo "</tbody>";
			}
			?>
			
			</table>
			
			<br/><br/>
			
		</div> <!-- end page -->
			
			<?
		}
 		include('footer.php');
?>
