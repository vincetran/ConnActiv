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
					<th>Date</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<tr> <!-- TODO: make these editable and auto-populating -->
					<td>asdasdff</td>
					<td>asdaasdff</td>
					<td>asdfasdf</td>
					<td>asdfasdf</td>
				</tr>
				<tr>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
				</tr>
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
					<th>Date</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<tr> <!-- TODO: make these editable and auto-populating -->
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
				</tr>
				<tr>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
				</tr>
			</tbody>
			
			</table>
			
			<br/><br/>
			
		<h2>Past Requests</h2>
			
		<table id="past" class="requests regular_table">
			<thead>
				<tr>
					<th>User</th>
					<th>Activity</th>
					<th>Date</th>
					<th>Message</th>
				</tr>
			</thead>
			<tbody>
				<tr> <!-- TODO: make these editable and auto-populating -->
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
				</tr>
				<tr>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
					<td>asdf</td>
				</tr>
			</tbody>
			
			</table>
			
			<br/><br/>
			
		<div id="footer">&copy; 2011; Kim Cooperrider &middot; Rob Filippi &middot; Dave Johnson &middot; Vince Tran &middot; Ray Wang</div>
		</div> <!-- end page -->
			
			<?
		}
 		
?>