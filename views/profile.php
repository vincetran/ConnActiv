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
				
			if (isset($_POST['saveInfo'])) 
				saveInfo();
			?>
			<script type="text/javascript">
		$(function() {
		
			$(".editable_textarea").editable("http://localhost/ConnActiv/ConnActiv/views/save.php", { 
				indicator : "<img src='http://localhost/ConnActiv/ConnActiv/public/images/indicator.gif'>",
				type   : 'textarea',
				select : true,
				submit : 'Save',
				cancel : 'cancel',
				tooltip   : "Click to edit..."
			});
			
			$(".editable_textile").editable("http://localhost/ConnActiv/ConnActiv/views/save.php?renderer=textile", {
				//Use this if you want the html tags to show
				//If you choose to use this you also need to uncomment some stuff in save.php, but then editable_textarea will not work.
				indicator : "<img src='http://localhost/ConnActiv/ConnActiv/public/images/indicator.gif'>",
				//loadurl   : "http://localhost/ConnActiv/ConnActiv/views/load.php", //This is suppose to make the html tags disappear. Doesn't work though
				type      : "textarea",
				submit    : "Save",
				cancel    : "Cancel",
				tooltip   : "Click to edit..."
			});

			
			$('.joinExpander').click(function(){
			$(this).siblings('.expand').toggle();
			});
			
			
			
			$('.top_links').removeClass('active');
			$('#profile').addClass('active');
		});
		
		$('#DOB').datepicker();
	
			</script>
			
			
			<div class="page">
			<h2>Profile</h2>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<table class="alternating regular_table" id="myInfo">
				<tr>
					<td>About Me:</td>
					<td width="300">
						<div style="width:300px; height:200px; white-space: normal;" class="editable_textarea" id="about_me"><?php echo getAboutMe($userID);?></div>
					</td>
				</tr>
				<tr>
					<td>Gender:</td>
					<td>
						<span class="clickable joinExpander"><?php echo getUserGender($userID);?></span>
						<div class="expand" style="display:none">
							<input type="radio" name="gender" value="M"/>Male
							<input type="radio" name="gender" value="F"/>Female
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>
					</td>
				</tr>
				<tr>
					<td>Location:</td>
					<td><?php echo getUserLocation($userID);?></td>
				</tr>
				<tr>
					<td>Age:</td>
					<td>
						<span class="clickable joinExpander"><?php echo getAge($userID);?></span>
						<div class="expand" style="display:none">
							Birthday:<input type="text" name="DOB" id="DOB" placeholder="Click here to select."/>
							<input class="button" type="submit" name="saveInfo" value="Save"/>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
				</tr>
			</table>
			</form>
			</div>
			<?php
		}
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
	
	include('footer.php');
?>