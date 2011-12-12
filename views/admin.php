<? include("header.php");
   if(cookieExists() && validCookie()): 
   
   
   if (isset($_POST['deleteUser'])) {
   	if (isset($_POST['userID'])) {
   		$users = $_POST['userID'];
   		foreach($users as $u) {
   			deleteUser($u);
   		}//end foreach($user)
   	} unset($_POST['deleteUser']);
   		unset($_POST['userID']);
   		echo "<div class='adminAction'>Users deleted.</div>";
   }
 
  	
	if (isset($_POST['denyEvent'])) {
		if (isset($_POST['eventID'])) {
			$events = $_POST['eventID'];
			foreach($events as $event) {
				denyEvent($event);
			} // end foreach
			unset($_POST['denyEvent']);
			unset($_POST['eventID']);
		} 
	} else	if (isset($_POST['approveEvent'])) {
		if (isset($_POST['eventID'])) {
			$events = $_POST['eventID'];
			foreach($events as $event) {
				approveEvent($event);
			} // end foreach
			unset($_POST['approveEvent']);
			unset($_POST['eventID']);
		} // end if (count)
	} else if (isset($_POST['deleteEvent'])) {
		if (isset($_POST['eventID'])) {
			$events = $_POST['eventID'];
			foreach($events as $event) {
				deleteEvent($event);
			} // end foreach
			unset($_POST['deleteEvent']);
			unset($_POST['eventID']);
		} // end if (count)
	}
   
   
?>
	
	<script type="text/javascript">
	
	$(function() {
	
		$('.top_links').removeClass('active');
		$('#admin').addClass('active');
	
		$('#side').hide();
		
			$('#usersTable').dataTable({
				"aaSorting": [[ 0, "desc" ]],
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false,
				"aoColumns": [ null, null, null, null, null, null, null, null, null, null, null, null, { "bSortable": false }]
			});
			
			fnShowHide('usersTable', 8); //hide Phone Number
			fnShowHide('usersTable', 9); //hide Interests
			fnShowHide('usersTable', 4); //hide Street
			fnShowHide('usersTable', 7); //hide Zip
			
			$('#eventsTable').dataTable({
				"aaSorting": [[ 9, "desc" ]],
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false
			});
			
			$('.showHideCol').click(function() {
				table = $(this).parent('section').attr('id').split('_').pop();
				fnShowHide(table+'Table', this.id);
			});
			
			$('#container').width('1020');
			$('.dataTables_wrapper').width('1020');
			$('thead th').css('min-width','70px');
			
			$('section').hide();
			$('#view_users').show();
			$('#users').addClass('active');
			
			$('.pageViewer span').click(function() {
				$el = $(this).attr('id');
				$sect = $("#view_" + $el);
				$('.green').removeClass('active');
				$(this).addClass('active');
				$('section').hide();
				$sect.fadeIn();
			});
	
	});	
	
	function fnShowHide(table, iCol) {
		oTable = $('#' +table).dataTable();	
		bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
		oTable.fnSetColumnVis( iCol, bVis ? false : true );
	}
	
	</script>

	<div class="page" style="width:100%">
	
	<div class="pageViewer">
		<span class='clickable green' id='users'>Users</span>&nbsp;|
		<span class='clickable green' id='events'>Event Requests</span>
	</div>
	
	<section id="view_users">
			<h2>Users</h2>
			
			<? echo "<div class='stats'>Currently, there are ".totalUsers()." total users.</div>" ?>
			
			<br><span class="blue">Toggle column visibility:</span><br><br>
			<input type="checkbox" checked class="showHideCol" name="col" id="0">&nbsp;<label>User ID</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="1">&nbsp;<label>Email</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="2">&nbsp;<label>First name</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="3">&nbsp;<label>Last name</label>
			<input type="checkbox" class="showHideCol" name="col" id="4">&nbsp;<label>Street</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="5">&nbsp;<label>City</label><br>
			<input type="checkbox" checked class="showHideCol" name="col" id="6">&nbsp;<label>State</label>
			<input type="checkbox" class="showHideCol" name="col" id="7">&nbsp;<label>Zip</label>
			<input type="checkbox" class="showHideCol" name="col" id="8">&nbsp;<label>Phone</label>
			<input type="checkbox" class="showHideCol" name="col" id="9">&nbsp;<label>Interests</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="10">&nbsp;<label>DOB</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="11">&nbsp;<label>M/F</label>			
			
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<? echo getFormattedUsers() ?>
			
			<div class="below_table">
				<input style="float:right;  margin-right:20px" type="submit" name="deleteUser" id="userDeleteButton" value="Delete"/>
			</div>
			
			</form>
			
	</section> <!-- end #view_users -->
	
	<section id="view_events">
		
			<h2>Events</h2>
			<? echo "<div class='stats'>Total events: ".totalAllEvents();
				echo "<br>Awaiting approval: ".totalEvents('-1');
				echo "<br>Approved: ".totalEvents('1');
				echo "<br>Denied: ".totalEvents('0');
				echo "</div>" ?>
			
			<br><span class="blue">Toggle column visibility:</span><br><br>
			<input type="checkbox" checked class="showHideCol" name="col" id="0">&nbsp;<label>Event ID</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="1">&nbsp;<label>Requester</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="2">&nbsp;<label>Activity</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="3">&nbsp;<label>Network</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="4">&nbsp;<label>Location</label><br>
			<input type="checkbox" checked class="showHideCol" name="col" id="5">&nbsp;<label>Details</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="6">&nbsp;<label>Start Date</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="7">&nbsp;<label>End Date</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="8">&nbsp;<label>Status</label>
			<input type="checkbox" checked class="showHideCol" name="col" id="9">&nbsp;<label>Request Date</label>
			
			<form id="eventReqForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
				<? echo getFormattedEvents() ?>
				
				<div class="below_table">
					<input style="float:right;" type="submit" name="deleteEvent" value="Delete"/>
					<input style="float:right; margin-left:10px; margin-right:10px" type="submit" name="denyEvent" value="Deny"/>
					<input style="float:right;" type="submit" name="approveEvent" value="Approve"/>
				</div>
				
			</form>
			</div>
	
	</section> <!-- end #view_events -->
	
	
	</div>
	
<? endif; ?>
<? include('footer.php'); ?>
