<?php 
	include("config.php");

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
			/*
			//This line until the next comment block is for 
			//editing the about me.
			//I stole this code from here: http://www.quirksmode.org/dom/cms.html
			//Pretty much if something is in a <p> tag then it can be edited and saved.
			//We cannot send anything in a <p> over with the form though. Kim with your
			//awesome web experience do you know of a better way to do this?
			var editing  = false;

			if (document.getElementById && document.createElement) {
				var butt = document.createElement('BUTTON');
				var buttext = document.createTextNode('Done Editing');
				butt.appendChild(buttext);
				butt.onclick = saveEdit;
			}

			function catchIt(e) {
				if (editing) return;
				if (!document.getElementById || !document.createElement) return;
				if (!e) var obj = window.event.srcElement;
				else var obj = e.target;
				while (obj.nodeType != 1) {
					obj = obj.parentNode;
				}
				if (obj.tagName == 'TEXTAREA' || obj.tagName == 'A') return;
				while (obj.nodeName != 'P' && obj.nodeName != 'HTML') {
					obj = obj.parentNode;
				}
				if (obj.nodeName == 'HTML') return;
				var x = obj.innerHTML;
				var y = document.createElement('TEXTAREA');
			//	y.appendChild(document.createTextNode(x));
				var z = obj.parentNode;
				z.insertBefore(y,obj);
				z.insertBefore(butt,obj);
				z.removeChild(obj);
				y.value = x;
				y.focus();
				editing = true;
				return false;
			}

			function saveEdit() {
				var area = document.getElementsByTagName('TEXTAREA')[0];
				var y = document.createElement('P');
				var z = area.parentNode;
				y.innerHTML = area.value;
				z.insertBefore(y,area);
				z.removeChild(area);
				z.removeChild(document.getElementsByTagName('button')[0]);
				editing = false;
				return false;
			}


			document.onclick = catchIt;
			//This is the end of the code I stole!
			//
			//
			*/
			
			/*$('.edit_about_me').click(function() {
				//This is an old way of how I was trying to make the edit about me work
					document.all.about_me.contentEditable="true";
					alert("test");
			});*/
			$(".editable_textarea").editable("http://localhost/ConnActiv/ConnActiv/views/save.php", { 
				indicator : "<img src='http://localhost/ConnActiv/ConnActiv/public/images/indicator.gif'>",
				type   : 'textarea',
				select : true,
				submit : 'OK',
				cancel : 'cancel',
				cssclass : "editable"
			});
			$(".editable_textile").editable("http://localhost/ConnActiv/ConnActiv/views/save.php?renderer=textile", { 
				indicator : "<img src='http://localhost/ConnActiv/ConnActiv/public/images/indicator.gif'>",
				//loadurl   : "http://www.appelsiini.net/projects/jeditable/php/load.php",
				type      : "textarea",
				submit    : "OK",
				cancel    : "Cancel",
				tooltip   : "Click to edit..."
			});

			
			$('.joinExpander').click(function(){
			$(this).siblings('.expand').toggle();
			});
			
			$('#DOB').datepicker();
	
			</script>
			
			
			<div class="page">
			<h2>Your Profile:</h2>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<table class="regular_table" id="myInfo" >
				<tr>
					<td colspan="3">
						<h2>My Info</h2>
					</td>
				</tr>
				<tr>
					<td>About Me:</td>
					<td width="300">
						<!--<p class="editable_textarea" id="paragraph_1"><?php// echo getAboutMe($userID);?></p>-->
						    <div class="editable_textile" id="paragraph_2"><?php echo getAboutMe($userID);?></div>

					</td>
					<td class="clickable edit_about_me"><u>Edit</u></td>
				</tr>
				<tr>
					<td>Gender:</td>
					<td><?php echo getUserGender($userID);?></td>
					<td>
						<span class="clickable joinExpander">Edit</span>
						<div class="expand" style="display:none">
							<input type="radio" name="gender" value="M"/>Male
							<input type="radio" name="gender" value="F"/>Female
						</div>
					</td>
				</tr>
				<tr>
					
				</tr>
				<tr>
					<td>Location:</td>
					<td><?php echo getUserLocation($userID);?></td>
					<td>Edit</td>
				</tr>
				<tr>
					<td>Age:</td>
					<td><?php echo getAge($userID);?></td>
					<td>
						<span class="clickable joinExpander">Edit</span>
						<div class="expand" style="display:none">
							DOB:<input type="text" name="DOB" id="DOB"/>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3"><input class="button" type="submit" name="saveInfo" value="Save!"/>
				</tr>
			</table>
			</form>
			<div id="footer">&copy; 2011; Kim Cooperrider &middot; Rob Filippi &middot; Dave Johnson &middot; Vince Tran &middot; Ray Wang</div>
			</div>
			<?php
		}
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>