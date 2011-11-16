<?php 
	include("config.php");

	//Checks if there is a login cookie
	if(cookieExists())
	//if there is a username cookie, we need to check it against our password cookie
	{ 
		if (!validCookie()) {
			//Cookie doesn't match password go to index
			header("Location: ../index.html"); 
		}
		else{
			//Cookie matches, show what they want
			?>
			<script type="text/javascript">
			$('a.join').click(function() {
				t = confirm("Are you sure you want to join?");
				t == true? alert("Your request to join has been sent! The user will contact you if he/she approves.") : alert('No join request made.');
			});

			$('a.stream').click(function() {
				type = $(this).attr('id');
				alert("STUB: Sorting to display " +type.toUpperCase()+ " stream only");
			});

			$('div.post-author').click(function() {
				auth = $(this).text().trim();
				alert("STUB: Going to profile of " +auth.toUpperCase());
			});

			$('.top_links').removeClass('active');
			$('#home').addClass('active');

			</script>
				
			<div class="page">
				
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<table>
				<tr>
					<td>Post a ConnAction: <input id="connaction"  type="text" name="connaction" maxlength="25"/><br/><br/></td>
				</tr>
			</table>
			</form>
				
				
				<h3>
				<a class="stream" id="public" href="#public-stream">Public Stream</a> | 
				<a class="stream" id="buddy" href="#buddy-stream">Buddy Stream</a>
				</h3>
				
					
				<div class="main feeds-container">
					<ul class="feeds">
						<li id="link_feeds_all"><a href="#">All</a></li>
						<?php 
						$networkNames = getNetworkNames();
						for($i = 0; $i  < count($networkNames); $i++){
							?>
							<li id="link_feeds_<?php $networkNames[$i]; ?>"><a href="#"><?php echo $networkNames[$i]; ?></a></li>
							<?php
						}
						?>
					</ul>
						<?php
							loadConnactions();
						?>
						<div class="post"> <!-- begin post -->
							<div class="post-author">
								<img src="public/images/face1.png" height="120" /><br/>
								Anita Napp
							</div>
							<div class="post-body">
								<p>Needs a running buddy for tmw morning!  8am anyone?</p>
							<div class="post-levels">
								<p>I am a 6-7 seeking levels 4-8 accepting levels 3-8.</p>
								<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>					
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li>Running</li>
										<li>Pittsburgh</li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
					
						<div class="post"><!-- begin post -->
							<div class="post-author">
								<img src="public/images/face2.png" height="120"/><br/>
								Bob Kelly
							</div>
							<div class="post-body">
								<p>Going to the gym early tomorrow. Gonna get in a great morning workout!</p>
							<!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li>Gym</li>
										<li>Pittsburgh</li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
						
						
							<div class="post"> <!-- begin post -->
							<div class="post-author">
								<img src="public/images/face1.png" height="120"/><br/>
								Foo Bar
							</div>
							<div class="post-body">
								<p>Wants to play squash tomorrow morning at 10. Looking for a partner.</p>
							<div class="post-levels">
								<p>I am a 6-7 seeking levels 4-8 accepting levels 3-8.</p>
								<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>			
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li>Squash</li>
										<li>Minneapolis</li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
						
						
				</div><!-- end feed container -->
				
			</div><!-- end page-->
		<?php
		}
 		
	}
	else {	 
		//if they are not logged in
		header("Location: ../index.html");
	}
?>