<?
	include_once('views/functions/config.php'); 
	if(isset($_POST['demo'])){
		header("Location: views/home.php");
	}
	else if (isset($_POST['login'])) { 
		//If user pressed login
		login(); 
	} else if (isset($_POST['register'])) {
		//If user pressed register
		register();
	} 
?>

<!DOCTYPE HTML>
<html>
<head>
<title>ConnActiv | The place for activ people.</title>

<META name="description" content="A place where awesome people can find other awesome people doing awesome things. Awesome.">
<META name="keywords" content="awesome, active, activity, connactiv, connaction, fun, connect, friends, moving, athletic, athlete, sports, hobbies, interesets, connecting">

<link rel="shortcut icon" type="image/x-icon" href="public/images/favicon.ico">

<script type="text/javascript" src="js/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="styles/defaults.css"/>

<link type="text/css" rel="stylesheet/less" href="styles/style.less"/>
<link type="text/css" rel="stylesheet/less" href="styles/posts.less"/>
<link type="text/css" rel="stylesheet/less" href="styles/sidebar.less"/>
<link type="text/css" rel="stylesheet" href="styles/demo_table.css"/>
<link type="text/css" rel="stylesheet" href="styles/validationEngine.jquery.css" />

<script type="text/javascript" src="js/less.min.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-en.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js" charset="utf-8"></script>

<link href='http://fonts.googleapis.com/css?family=Reenie+Beanie' rel='stylesheet' type='text/css'>

<script type="text/javascript">
$(function() {

	$('#demo').click(function() {
		$('#username').val('guest@connactiv.com').removeClass('validate');
		$('#password').val('guest123').removeClass('validate');
	});
	
	$('#login').click(function(e) {
		e.preventDefault();
		$(this).addClass('active');
		$('#signup').removeClass('active');
		$('#credentials').slideDown();
		$('#new_user').hide();
	});
	
	$('#signup').click(function(e) {
		e.preventDefault();
		$(this).addClass('active');
		$('#login').removeClass('active');
		$('#new_user').slideDown();
		$('#credentials').hide();
	});
	
	$('#registerForm').validationEngine();
	
	$('#subscribeTable').dataTable({
        "aaSorting": [[ 0, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true,
				"aoColumns": [ null, null, { "bSortable": false }]
				});
				
	$('#subscribeTable_wrapper').hide();
	
	$('#expand').click(function() {
		$('#subscribeTable_wrapper').toggle();
	});
	
	$('#expand a').click(function(e) {
		e.preventDefault();
	});
	
	$('#addNewExpand').click(function() {
		$('#registrationUnique').toggle();
	});
	
	$('.checkAll').click(function() {
			className = $(this).attr('id');
			$('input.'+className).attr('checked', 'true');
		});
		
		$('.uncheckAll').click(function() {
			className = $(this).attr('id').split('_').pop();
			els = $('input.'+className);
			els.each(function() {
				$(this).is(':disabled') ? '' : $(this).removeAttr('checked');
			});
		});
	
	});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1903431-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>

<div id="container">

	<div id="content">
	
	<a href="<?php echo $_SERVER['PHP_SELF']?>"><img src="public/images/logo.png"/></a><br/>
	
	<div id="rollover_imgs">
		<div id="login" class="rollover clickable active"></div>
		<div id="signup" class="rollover clickable"></div>
	</div>
	<br/>
	
	<div id="welcomeForm">
	
		<div id="credentials">
			<form id="signinForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<table>
				<tr>
					<th class="formHeader"><label>Email:</label></th>
					<td><input id="username"  autofocus type="text" name="username" maxlength="25"/><br/></td>
				</tr>
				<tr>
					<th class="formHeader">Password:</th>
					<td><input id="password" type="password" name="pass" maxlength="100" class="validate[required]"/></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td colspan="2" style="text-align:right"><input type="submit" id="do_login" name="login" value="Login"/><span id="demo" class="clickExpand">&nbsp;&nbsp;or look around&nbsp;&raquo;</span></td>
				</tr>
			</table>
			</form>
		</div>
	
		<div id="new_user" style="display:none">
			<br/>
			<form id="registerForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<table>
				<tr>
					<th class="formHeader">Email*:</th>
					<td><input id="username"  type="text" name="username" maxlength="25" class="validate[required,custom[email]]"/><br/></td>
				</tr>
				<tr>
					<th class="formHeader">First name*:</th>
					<td><input id="firstName"  type="text" name="firstName" maxlength="20" class="validate[required]"/><br/></td>
				</tr>
				<tr>
					<th class="formHeader">Last name*:</th>
					<td><input id="lastName" type="text" name="lastName" maxlength="20" class="validate[required]"/></td>
				</tr>
				<tr>
					<th class="formHeader">City:</th>
					<td><input id="city" type="text" name="city" maxlength="25" /></td>
				</tr>
				<tr>
					<th class="formHeader">State:</th>
					<td><? echo getStateDropdownLong() ?><br/></td>
				</tr>
				<tr>
					<th class="formHeader">Zip:</th>
					<td><input id="zip" type="text" name="zip" maxlength="5" /></td>
				</tr>
				<tr>
					<th class="formHeader">Phone:</th>
					<td><input id="phone"  type="text" name="phone" maxlength="25" class="validate[custom[phone]]"/><br/></td>
				</tr>
				<tr>
					<th class="formHeader">A little about yourself:</th>
					<td><input id="interests" type="text" name="interests" maxlength="4000" /></td>
				</tr>
				<tr>
					<th class="formHeader">Password*:</th>
					<td><input id="password" type="password" name="password" maxlength="100" class="validate[required]" minlength="6"/><br/></td>
				</tr>
				<tr>
					<th class="formHeader">Confirm Password*:</th>
					<td><input id="confirm" type="password" name="confirm" maxlength="100" class="validate[required]" equalTo="#password"/></td>
				</tr>
				<tr>
					<td id="expand" colspan="2"><br/>
					Select networks to view and make posts<br/> about the activities that interest you.<br/><a href="#">Start browsing&nbsp;&raquo;</a></td>
				</tr>
				</table>
				
				<br>
				<table style="margin-bottom:10px;" class="small requests regular_table" id="subscribeTable">
						<thead>
							<tr>
								<th>Area</th>
								<th>Activity</th>
								<th>Subscribe<span id="registerSubscribe" class="checkAll"></span><span id="_registerSubscribe" class="uncheckAll"></span></th>
							</tr>
						</thead>
						<tbody>
							
							<? $unique = getAllUniqueNetworks(); //row(unique_network_id, area, state, activity_name).
									foreach($unique as $un) {
										echo "<tr><td>". $un[1] .", ". $un[2] ."</td><td>". $un[3] ."</td><td><input class='registerSubscribe' type='checkbox' value='".$un[0]."' name='activity[]' /></td></tr>";
									}
							?>
							</tbody>
						</table>
				<div><br><br>Or <span id="addNewExpand" style="clear:both" class="clickable realgreen">add your own&nbsp;&raquo;</span></div><br>
					<div id="registrationUnique" style="display:none">
						<span>Area: <input class="medium_input" type="text" name="area" value="" placeholder="ex: Pittsburgh"/></span>
						<span>State:  <? echo getStateDropdown() ?></span><br><br>
						<span>Activity: <input class="large_input" type="text" name="newActivity" value="" placeholder="ex: being awesome"/></span><br><br>
					</div>
					
					<input type="submit" id="do_register" name="register" value="Get ConnActed!"/>
					
			</form>
		</div>
		</div> <!-- /welcome_form-->

<? include('views/footer.php'); ?>