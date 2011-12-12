<? include("header.php");
			//if (name is clicked)
				//viewing someones profile
				//$userID = $_POST['userID']
			//else
				//viewing our profile
				$userID = getUserID();
				
			if (isset($_POST['saveInfo'])){
				if(getUserID() != "2"){
					saveInfo();
				}
				else{echo "<div class = 'demo'>You are unable to save profile information in Demo Mode</div>";}
			}
			if(isset($_POST['saveInfoState'])){
				if(getUserID() != "2"){
					saveInfoState();
				}
				else{echo "<div class = 'demo'>You are unable to save profile information in Demo Mode</div>";}
			}
			if(isset($_POST['saveInfoAge'])){
				if(getUserID() != "2"){
					saveInfoAge();
				}
				else{echo "<div class = 'demo'>You are unable to save profile information in Demo Mode</div>";}
			}
			//upload the file and set the users profile pic.			
			if(isset($_POST['fileupload'])){
				if(getUserID() != "2"){
					upload_file($_FILES, getUserID());
					
					$query = "update users set profile_pic = 'profile_pics/".getUserID()."' where user_id = ".getUserID();
					mysql_query($query);
				}
				else{echo "<div class = 'demo'>You are unable to upload profile pictures in Demo Mode</div>";}
				unset($_FILES);

			}
			if(isset($_POST['reply'])){
				if(getUserID() != "2"){
					$query = "insert into messages values (".getUserID().", ".mysql_real_escape_string($_POST['reply'][3]).", '".mysql_real_escape_string($_POST['reply'][0])."', '".mysql_real_escape_string($_POST['reply'][1])."', now())";
					
					mysql_query($query);
				}
				else{echo "<div class = 'demo'>You are unable to reply to messages in Demo Mode</div>";}
			}
			
			?>
			
	<script type="text/javascript">
		$(function() {
		
			$(".editable_textarea").editable("http://localhost/ConnActiv/views/save.php", { 
				indicator : "<img src='../public/images/indicator.gif'>",
				type   : 'textarea',
				select : true,
				submit : 'Save',
				cancel : 'Cancel',
				tooltip   : "Click to edit..."
			});
			
			$(".editable_textile").editable("http://localhost/ConnActiv/views/save.php?renderer=textile", {
				//Use this if you want the html tags to show
				//If you choose to use this you also need to uncomment some stuff in save.php, but then editable_textarea will not work.
				indicator : "<img src='../public/images/indicator.gif'>",
				//loadurl   : "http://localhost/ConnActiv/ConnActiv/views/load.php", //This is suppose to make the html tags disappear. Doesn't work though
				type      : "textarea",
				submit    : "Save",
				cancel    : "Cancel",
				tooltip   : "Click to edit..."
			});

			
			$('.expander').click(function(){
			$(this).siblings('.expand').toggle();
			});
			
			$('.top_links').removeClass('active');
			$('#profile').addClass('active');
		
			$('#DOB').datepicker({  
				selectOtherMonths: true, 
				changeMonth: true, 
				changeYear: true, 
				maxDate: 0,
				yearRange: "-100:+0"
			});
			
			$('.section').hide();
			$('#view_profile').show();
			$('#profile').addClass('active');
			
			$('.pageViewer span').click(function() {
				$el = $(this).attr('id');
				$sect = $("#view_" + $el);
				$('.green').removeClass('active');
				$(this).addClass('active');
				$('.section').hide();
				$sect.fadeIn();
				
			});
			
			$('#receivedMessages').dataTable( {
				"aaSorting": [[ 3, "desc" ]],
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false,
				"aoColumns": [ null, null, null, null, { "bSortable": false }]
			});
   	 
			$('#sentMessages').dataTable( {
				"aaSorting": [[ 3, "desc" ]],
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false
			});
			
			setTimeout(fade_out, 4000);

			function fade_out() {
				$(".notice").slideUp();
				$(".error").slideUp();
			}

		});
			</script>
			
			
			<div class="page">
			
				<div class="pageViewer">
					<span class="clickable active green" id="profile">Your info</span>&nbsp;|&nbsp;
					<span class="clickable green" id="messages">Messages</span>&nbsp;|&nbsp;
					<span class="clickable green" id="reviews">Reviews</span>
				</div>
			
			<div class="section" id="view_profile">
			
			<h2>Profile Info</h2>
			
			<div class="greyBorder">
			
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<table class="simple_table" id="myInfo">
				<tr>
					<th>About</th>
					<td> 
						<? $about = getAboutMe($userID); ?>
						<span class="clickable expander"><? echo $about ?><span class='editIcon'></span></span>
						<div class="expand" style="display:none">
							<input type="text" name="about_me" value="<? echo $about ?>"/>
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>
					</td>
				</tr>
				<tr>
					<th>Gender</th>
					<td>
					<? $sex = getUserGender($userID); 
						$maleStatus = ''; $femaleStatus = '';
						
						$sex == 'Male' ? $maleStatus = 'checked' : '';
						$sex == 'Female' ? $femaleStatus = 'checked ' :''; //Determine which radio button to activate by default
					
					?>
						<span class="clickable expander"><? echo $sex ?><span class='editIcon'></span></span>
						<div class="expand" style="display:none">
							<input type="radio" name="gender" <? echo $maleStatus ?> value="M"/>Male
							<input type="radio" name="gender" <? echo $femaleStatus ?> value="F"/>Female
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>
					</td>
				</tr>
				<tr>
					<th>City</th>
					<td>
					<? $city = getUserCity($userID); ?>
					<span class="clickable expander"><? echo $city ?><span class='editIcon'></span></span>
					<div class="expand" style="display:none">
							<input type="text" name="city" value="<? echo $city ?>"/>
							<input class="button" type="submit" name="saveInfoCity" value="Save"/>
						</div>					
					</td>
				</tr>
				<tr>
					<th>State</th>
					<td>
					<? $st = getUserState($userID); ?>
					<span class="clickable expander"><? echo $st ?><span class='editIcon'></span></span>
					<div class="expand" style="display:none">
							<? echo getStateDropdown(); ?>
							<input class="button" type="submit" name="saveInfoState" value="Save"/>
						</div>					
					</td>
				</tr>
				<tr>
					<th>Age</th>
					<td>
						<? $age = getAge($userID); ?>
						<span class="clickable expander"><? echo $age ?><span class='editIcon'></span></span>
						<div class="expand" style="display:none">
							<input type="text" name="DOB" id="DOB" placeholder=" Date of birth"/>
							<input class="button" type="submit" name="saveInfoAge" value="Save"/>
						</div>
					</td>
				</tr>
				</form>
			</table>
			
			</div>
			
			<br/><br/>
				<h2>Profile Photo</h2>
				
				<div class="greyBorder">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
						<p>
							<label for="file">Select a file:</label>  <input type="file" name="userfile" id="file"> <br /><br />
							<input type = 'hidden' name = 'fileupload' /></p>
							<button>Upload File</button>
				</form>
				</div><!-- end .greyBorder -->
			</div> <!-- end view_profile div -->
			<div class="section" id="view_messages">
				
			
				<h2>Received Messages</h2>
				
			<table id="receivedMessages" class="alternating regular_table">
				<thead>
					<tr>
						<th>From</th>
						<th>Subject</th>
						<th>Message</th>
						<th>Date</th>
						<th>Reply</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$incMessages = getIncMessages(getUserID());
					
						foreach($incMessages as $message){
							echo "<tr><td>".getUserName($message['FROM_USER'])."</td>";
							echo "<td>".$message['SUBJECT']."</td>";
							echo "<td>".$message['BODY']."</td>";
							echo "<td>".$message['DATE']."</td>";
							echo "<td><form action = ".$_SERVER['PHP_SELF']." method = 'post'><input type= 'text' class='x_small_input' maxlength='255' placeholder = 'Subject' name = 'reply[]'><input type= 'text' maxlength = '4000' placeholder = 'Reply Here' name = 'reply[]'>";
							echo "<br/><input type = 'submit' name = 'reply[]' value = 'Reply'/><input type = 'hidden' name = 'reply[]' value = '".$message['FROM_USER']."'/></form></td>";
							echo "</tr>";
						}
				?>
				</tbody>
			</table>
			
				<br/><br/><br><br>
				<h2>Sent Messages</h2>
				
			<table id="sentMessages" class="alternating regular_table">
				<thead>
				<tr>
					<th>To</th>
					<th>Subject</th>
					<th>Message</th>
					<th>Date</th>				
				</tr>
				</thead>
				<tbody>
				<?php
					$sentMessages = getSentMessages(getUserID());
					
					foreach($sentMessages as $message){
						echo "<tr>";
						echo "<td>".getUserName($message['TO_USER'])."</td>";
						echo "<td>".$message['SUBJECT']."</td>";
						echo "<td>".$message['BODY']."</td>";
						echo "<td>".$message['DATE']."</td>";
						echo "</tr>";
					}
				?>
				</tbody>
			</table>
			
			</div><!-- end view_messages div -->
			<div class="section" id="view_reviews">
			
			<h2>Reviews of You</h2>
			<?
			$review = getAllReviews($userID);
			$reviews =  getFormattedReviews($review);
			if (!$reviews) echo "<p style='color:#2384DE;'><br><br>You haven't been reviewed yet!</p>Since only users with whom you've completed connactions can review you,<br>check back once you've done a few more activities.";
			else echo $reviews;
			?>
			
			</div><!-- end view_reviews div -->
			
			</div> <!-- end page -->
			<?php
	include('footer.php');
?>
