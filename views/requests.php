<?php 
	include("header.php");

	if(cookieExists() && validCookie()) {
	
	
if(isset($_POST['subReview'])){
		
		if($_POST['review'][4] == 'on'){$anonymous = 1;} else{$anonymous = 0;}
		$query = "insert into reviews values(".mysql_real_escape_string($_POST['review'][2]).", ".getUserID().", ".$anonymous.", ".mysql_real_escape_string($_POST['review'][1]).", ".mysql_real_escape_string($_POST['review'][3]).", now(), '".mysql_real_escape_string($_POST['review'][0])."')";
		
		mysql_query($query) or die(mysql_error());
		unset($_POST['review']);
	}
	
	
	if (isset($_POST['accept'])) {
		if (isset($_POST['requestID'])) {
			$request = $_POST['requestID'];
			foreach($request as $req) { 
				acceptRequest($req);
				echo "<div class='notice'>Join request accepted!</div>";
			} // end foreach
		} unset($_POST['requestID']);
			unset($_POST['accept']);
	}
	
	if (isset($_POST['acceptFriend'])) {
		if (isset($_POST['friendReq'])) {
			$friends = $_POST['friendReq'];
			foreach($friends as $friend) { 
				acceptFriendRequest($friend);
				echo "<div class='notice'>Friend accepted!</div>";
			} // end foreach
		} //end if ($_POST[accept])
	}
	
	if (isset($_POST['deny'])) {
		if (isset($_POST['requestID'])) {
			$request = $_POST['requestID'];
			foreach($request as $req) {
				denyRequest($req);
				echo "<div class='notice'>Join request denied.</div>";
			} // end foreach
		} //end if ($_POST[deny])
	}
	
	if (isset($_POST['denyFriend'])) {
		if (isset($_POST['friendReq'])) {
			$friends = $_POST['friendReq'];
			foreach($friends as $friend) {
				denyFriendRequest($friend);
				echo "<div class='notice'>Friend request denied.</div>";
			} // end foreach
		} //end if ($_POST[deny])
	}
	
	if (isset($_POST['hideInc'])) {
		if (isset($_POST['hideID'])) {
			$request = $_POST['hideID'];
			foreach($request as $req) {
				hideRequestForTo($req);
			} // end foreach
		} //end if ($_POST[requestID])
	}
	
	if (isset($_POST['unhideInc'])) {
		unhideRequestForTo();
	}
	
	if (isset($_POST['hide'])) {
		if (isset($_POST['requestIDPen'])) {
			$request = $_POST['requestIDPen'];
			foreach($request as $req) {
				hideRequestForFrom($req);
			} // end foreach
		} //end if ($_POST[requestID])
	}
	
	if (isset($_POST['unhide'])) {
		unhideRequestForFrom();
	}

	} 
	
	if (isset($_POST['eventDeny'])) {
		if (isset($_POST['eventReq'])) {
			$request = $_POST['eventReq'];
			foreach($request as $req) {
				denyEvent($req);
			} // end foreach
			unset($_POST['eventDeny']);
		} //end if (count)
	} 
	
	if (isset($_POST['eventApprove'])) {
		if (isset($_POST['eventReq'])) {
			$request = $_POST['eventReq'];
			foreach($request as $req) {
				approveEvent($req);
			} // end foreach
			unset($_POST['eventApprove']);
		} // end if (count)
	} //end if ($_POST[eventApprove])
	
	
			?>
			
<script type="text/javascript">
	$(document).ready(function() {
    $('#incoming').dataTable( {
        "aaSorting": [[ 5, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false
   	 });
   	 
   	 $('#pending').dataTable( {
        "aaSorting": [[ 5, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false
   	 });
   	 
   	 $('#past').dataTable( {
        "aaSorting": [[ 5, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false,
				"aoColumns": [ null, null, null, null, { "bSortable": false }]
   	 });
   	 
   	 
   	 $('#incomingFR').dataTable( {
        "aaSorting": [[ 1, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false
   	 }); 
   	 
   	 $('#pendingFR').dataTable( {
        "aaSorting": [[ 1, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false
   	 }); 
   	    	 
   	 $('#waitingEvents').dataTable( {
        "aaSorting": [[ 1, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false,
				"aoColumns": [ null, null, null, { "bSortable": false }]
   	 });   	 
   	 
		$('.top_links').removeClass('active');
		$('#requests').addClass('active');
   
   	$('#view_friendReqs').hide();
   	$('.requestType').hide();
   	$('#view_connactions').show();
   	
   	$('#connactions').click(function() {
   		$('.pageViewer span').removeClass('active');
   		$(this).addClass('active');
   		$('.requestType').hide();
   		$('#view_connactions').fadeIn();
   	});
   	
   	$('#friendReqs').click(function() {
   	  $('.pageViewer span').removeClass('active');
   		$(this).addClass('active');
   		$('.requestType').hide();
   		$('#view_friendReqs').fadeIn();
   	});
   	
   	$('#eventReqs').click(function() {
   	  $('.pageViewer span').removeClass('active');
   		$(this).addClass('active');
   		$('.requestType').hide();
   		$('#view_eventReqs').fadeIn();
   	});
   	
   	$('.expander').click(function() {
   		$(this).siblings('.expandable').show();
   		$(this).hide();
   	});
   	 
		});		
</script>			
			
	<div class="page">
	
	<div class="pageViewer">
		<span class="clickable active green" id="connactions">Connaction Requests</span>&nbsp;|&nbsp;
		<span class="clickable green" id="friendReqs">Friend Requests</span>
		
		<? if (isAdmin()) {
			echo "&nbsp;|&nbsp";
			echo "<span class='clickable green' id='eventReqs'>Event Requests</span>";
		} ?>
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
					
						foreach($incRequests as $incoming){
							$fromUser = $incoming[0];
							$toUser = $incoming[1];
							$connactionID = $incoming[2];
							$message = $incoming[3];
							$approved = $incoming[4];
							$date = date_parse($incoming[5]);
							$hidden = $incoming[7];
							$requestID = $fromUser." ".$connactionID." ".$approved;
							if($hidden == 0){?>
							
							<tr> 
								<td>
									<?php 
										//echo "<input type='checkbox' value='".$requestID."' name='requestID[]' /> <br/>"; //Add this line for changing status requests
										if($approved == -1){
											echo "<input type='checkbox' value='".$requestID."' name='requestID[]' /> <br/>"; //Remove this line for changing status requests
											echo "Pending";
										}
										else if($approved == 1){
											echo "<input type='checkbox' value='".$requestID."' name='hideID[]' /> <br/>";
											echo "Approved";
										}
										else{
											echo "<input type='checkbox' value='".$requestID."' name='hideID[]' /> <br/>";
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
			
			<? if ($incRequests) { ?>
			<div class="below_table">
				<span style="clear:both;" class="below_table"></span>
				<input style="float:right; margin-left:5px; margin-right:20px" type="submit" name="hideInc" value="Hide Request(s)"/>
				<input style="float:right; margin-left:5px;" type="submit" name="unhideInc" value="Unhide Request(s)"/>
				<input style="float:left; margin-left:5px; margin-left:20px" type="submit" name="accept" value="Accept Request(s)"/>
				<input style="float:left; margin-left:5px;" type="submit" name="deny" value="Deny Request(s)"/>
			</div>
			</form>
			<br/><br/>
			<? } ?>
			
		<br/><br/><br>
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
					
						foreach($pendingRequests as $incoming){
							$fromUser = $incoming[0];
							$toUser = $incoming[1];
							$connactionID = $incoming[2];
							$message = $incoming[3];
							$approved = $incoming[4];
							$date = date_parse($incoming[5]); 
							$hidden = $incoming[6];
							$requestID = $fromUser." ".$connactionID;
							
							if($hidden == 0){?>
							
							
								<tr>
									<td>
										<?php
											if($approved == -1){
												echo "Pending";
											}
											else if($approved == 1){
												echo "<input type='checkbox' value='".$requestID."' name='requestIDPen[]' /> <br/>";
												echo "Approved";
											}
											else{
												echo "<input type='checkbox' value='".$requestID."' name='requestIDPen[]' /> <br/>";
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
			
			<? if ($pendingRequests) { ?>
			<div class="below_table">
				<span style="clear:both;" class="below_table">Request are deleted the day after the ConnAction.</span>
				<input style="float:right; margin-left:5px; margin-right:20px" type="submit" name="hide" value="Hide Request(s)"/>
				<input style="float:right;" type="submit" name="unhide" value="Unhide Request(s)"/>
			</div>
			<br/><br/><br/>
			<? } ?>
			
			<br><br><br><br>
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
					echo "<td><span class='clickExpand expander'>Review&nbsp;&raquo;</span>";
					
					echo "<div class='expandable' style='display:none'>";
				
					echo "<form id='reviewform' action='".$_SERVER['PHP_SELF']."' method='post'>";
					echo "<input id = 'review' type = 'textbox' name = 'review[]' placeholder='Review this ConnAction'/><br/>";					
					echo "<input type = 'hidden' name = 'review[]' value = $pc[0] />";
					echo "<input type = 'hidden' name = 'review[]' value = $pc[1] />";
					echo "<input class = 'review' name = 'review[]' type = 'radio' value = 1 />Thumbs Up<input name = 'review[]' type = 'radio' value = 0 />Thumbs Down<br/>";
					echo "<input class = 'review' name = 'review[]' type = 'checkbox'/>Anonymous";		
					echo "<input class = 'review' name = 'subReview' type = 'submit' value = 'Submit Review'/>";
					
					echo "</form></div></td>";
					
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
			<form id="incFriendReqForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table id="incomingFR" class="requests regular_table">
			<thead class="reqHeader">
				<tr>
					<th>Status</th>
					<th>From User</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$incFriendRequests = getIncFriendRequests(getUserID());
					if ($incFriendRequests) {
					
						foreach($incFriendRequests as $incoming){
							if($incoming['IS_ACTIVE'] == -1){
							$fromUser = $incoming['FROM_USER'];
							$toUser = $incoming['TO_USER'];
							$message = $incoming['MESSAGE'];
							$is_active = $incoming['IS_ACTIVE'];
							$friendID = $fromUser." ".$toUser;
				?>
							
							<tr> 
								<td>
									<?php 
										if($is_active == -1){
											echo "<input type='checkbox' value='".$friendID."' name='friendReq[]' /> <br/>"; 
											echo "Pending";
										}
									?>
								</td>
								<td><?php echo getUserName($fromUser); ?></td>
								<td><?php echo $message; ?></td>
							</tr>
							
							
							
						<?php
							}
						} 
					}
				?>
			</tbody>
			
			</table>
			<div class="below_table">
				<input style="float:right; margin-left:10px; margin-right:20px" type="submit" name="denyFriend" value="Deny Request(s)"/>
				<input style="float:right;" type="submit" name="acceptFriend" value="Accept Request(s)"/>
			</div>
			</form>
			
			<br><br><br><br>

			<h2>Pending Friend Requests</h2>
			<h3>People you have asked to be your friend</h3>
			
			<table id="pendingFR" class="requests regular_table">
			<thead class="reqHeader">
				<tr>
					<th>Status</th>
					<th>To User</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$pendingFriendRequests = getPendingFriendRequests(getUserID());
					if ($pendingFriendRequests) {
						foreach($pendingFriendRequests as $pending){
							if($pending['IS_ACTIVE'] == -1){							
							$fromUser = $pending['FROM_USER'];
							$toUser = $pending['TO_USER'];
							$message = $pending['MESSAGE'];
							$is_active = $pending['IS_ACTIVE'];
							$friendRequest = $fromUser." ".$toUser;
				?>
							
							<tr> 
								<td>Pending</td>
								<td><?php echo getUserName($toUser); ?></td>
								<td><?php echo $pending['MESSAGE']; ?></td>
								
							</tr>
						<?php }
						} 
					}
				?>
			</tbody>
			
			</table>
			
			</div> <!-- end friendReqs div -->
			
			<? if (isAdmin()) { ?>
			<div id="view_eventReqs" class="requestType"> <!-- begin eventReqs div, only for admin -->
			
			
			Only the administrator will see this page.<br/>
			(Not an admin? Kindly <a href="mailto:connactiv@googlegroups.com?subject=Oops!&body=I'm not an admin, but I'm seeing admin stuff on your site and wanted to let you know">email us</a>
			&nbsp;to let us know there's a problem.)<br/><br/>
			
			<h2>Events Awaiting Approval</h2>
			
			<form id="eventReqForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<table class="alternating regular_table" id="waitingEvents">
				<thead>
					<th>Requesting User</th>
					<th>Date Requested</th>
					<th>Event Details</th>
					<th><span id="approve" class="checkAll"></span><span id="_approve" class="uncheckAll"></th>
				</thead>
				<tobdy>
			
			<? $waitingEvents = getAllWaitingEvents();
			
				foreach($waitingEvents as $event) {
					$eventID = $event[0];
					$user = getUserName($event[1]);
					$actID = $event[2]; $netID = $event[3]; 
					$uniqueID = getUniqueID($actID, $netID); 
					$str = prettifyName($uniqueID);
					$msg = $event[4];
					$start = $event[5]; $end = $event[6];
					$loc = $event[7];
					$requested = $event[10];
				
					echo "<tr>";
						echo "<td>$user</td>";
						echo "<td>$requested</td>";
						echo "<td><p><strong>Location: </strong>$loc</p><p><strong>Details: </strong>$msg</p></td>";
						echo "<td><input class='approve' type = 'checkbox' name = 'eventReq[]' value = '".$eventID."' /></td>";	
					echo "</tr>";
				
				}			
			?>
					
				</tbody>
			</table>
			<div class="below_table">
				<input style="float:right; margin-left:10px; margin-right:20px" type="submit" name="eventDeny" value="Deny Request(s)"/>
				<input style="float:right;" type="submit" name="eventApprove" value="Accept Request(s)"/>
			</div>
			
			</form>
			
			</div> <!-- end event Reqs -->
			
			<? } // end if isAdmin ?>
			


		</div> <!-- end page -->
			
			<?
		
 		include('footer.php');
?>
