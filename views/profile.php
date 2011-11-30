<? include("header.php");

	//Checks if there is a login cookie
	if(cookieExists())
	//if there is a username cookie, we need to check it against our password cookie
	{ 
		
		if (!validCookie()) {
			//Cookie doesn't match password go to index";
			header("Location: ../index.html"); 
		}
		else{
			
			
			//Cookie matches, show what they want.";
			
			//if (name is clicked)
				//viewing someones profile
				//$userID = $_POST['userID']
			//else
				//viewing our profile
				$userID = getUserID();
				
			if (isset($_POST['saveInfo'])){
				saveInfo();}
			//upload the file and set the users profile pic.			
			if(isset($_POST['fileupload'])){
				upload_file($_FILES, getUserID());
				$query = "update users set profile_pic = 'profile_pics/".getUserID()."' where user_id = ".getUserID();
				mysql_query($query);
				unset($_FILES);
			}
			if(isset($_POST['reply'])){
				$query = "insert into messages values (".getUserID().", ".$_POST['reply'][3].", '".$_POST['reply'][0]."', '".$_POST['reply'][1]."', now())";
				
				mysql_query($query);
				
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
		
			$('#DOB').datepicker({ showButtonPanel: true, selectOtherMonths: true, changeMonth: true, changeYear: true, minDate: new Date(0) });
			
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
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<table class="alternating regular_table" id="myInfo">
				<tr>
					<td>About</td>
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
					<td>Gender</td>
					<td>
						<span class="clickable expander"><? echo getUserGender($userID) ?><span class='editIcon'></span></span>
						<div class="expand" style="display:none">
							<input type="radio" name="gender" value="M"/>Male
							<input type="radio" name="gender" value="F"/>Female
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>
					</td>
				</tr>
				<tr>
					<td>City</td>
					<td>
					<? $city = getUserCity($userID); ?>
					<span class="clickable expander"><? echo $city ?><span class='editIcon'></span></span>
					<div class="expand" style="display:none">
							<input type="text" name="city" value="<? echo $city ?>"/>
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>					
					</td>
				</tr>
				<tr>
					<td>State</td>
					<td>
					<? $st = getUserState($userID); ?>
					<span class="clickable expander"><? echo $st ?><span class='editIcon'></span></span>
					<div class="expand" style="display:none">
							<? echo getStateDropdown(); ?>
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>					
					</td>
				</tr>
				<tr>
					<td>Age</td>
					<td>
						<? $age = getAge($userID); ?>
						<span class="clickable expander"><? echo $age ?><span class='editIcon'></span></span>
						<div class="expand" style="display:none">
							<input type="text" name="DOB" id="DOB" placeholder="Date of birth?"/>
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>
					</td>
				</tr>
				</form>
			</table>
			
			<br/><br/>
				<h2>Profile Photo</h2>
						
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
						<p>
							<label for="file">Select a file:</label> <input type="file" name="userfile" id="file"> <br />
							<input type = 'hidden' name = 'fileupload' /></p>
							<button>Upload File</button>
				</form>
				
			</div> <!-- end view_profile div -->
			<div class="section" id="view_messages">
				
			
				<h2>Received Messages</h2>
				
			<table class="alternating regular_table">
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
					
					if ($incMessages) {
					
						foreach($incMessages as $message){
							echo "<tr><td>".getUserName($message['FROM_USER'])."</td>";
							echo "<td>".$message['SUBJECT']."</td>";
							echo "<td>".$message['BODY']."</td>";
							echo "<td>".$message['DATE']."</td>";
							echo "<td><form action = ".$_SERVER['PHP_SELF']." method = 'post'><input = 'textbox' placeholder = 'Subject' name = 'reply[]'><input = 'textarea' placeholder = 'Reply Here' name = 'reply[]'><input type = 'submit' name = 'reply[]' value = 'Reply'/><input type = 'hidden' name = 'reply[]' value = '".$message['FROM_USER']."'/></form></td>";
							echo "</tr>";
						}
					
					} else echo "<tr><td colspan='5'>None yet.</tr>";
				?>
				</tbody>
			</table>
				<br/>
				<h2>Sent Messages</h2>
				
			<table class="alternating regular_table">
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
					
					if ($sentMessages) {
					
					foreach($sentMessages as $message){
						echo "<tr>";
						echo "<td>".getUserName($message['TO_USER'])."</td>";
						echo "<td>".$message['SUBJECT']."</td>";
						echo "<td>".$message['BODY']."</td>";
						echo "<td>".$message['DATE']."</td>";
						echo "</tr>";
					}
					
					} else echo "<tr><td colspan='5'>None yet.</tr>";
				?>
				</tbody>
			</table>
			
			</div><!-- end view_messages div -->
			<div class="section" id="view_reviews">
			
			<h2>Reviews of You</h2>
			<?
			$review = getAllReviews($userID);
			echo getFormattedReviews($review);
			?>
			
			</div><!-- end view_reviews div -->
			
			</div> <!-- end page -->
			<?php
		}
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
	
	include('footer.php');
?>
