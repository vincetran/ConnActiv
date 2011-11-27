<?
	include_once('views/config.php'); 
	if (isset($_POST['login'])) { 
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
	$('#signinForm').validationEngine();
	
	});
</script>

</head>
<body>

<div id="container">

	<div id="content">
	
	<img src="public/images/logo.png"/><br/>
	
	<div id="rollover_imgs">
		<div id="login" class="rollover clickable active"></div>
		<div id="signup" class="rollover clickable"></div>
	</div>
	<br/>
	

	<div id="welcomeForm">
	
		<div id="credentials">
			<br/>
			<form id="signinForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<table>
				<tr>
					<th><label>Email:</label></th>
					<td><input id="username"  type="text" name="username" maxlength="25" class="validate[required,custom[email]]"/><br/><br/></td>
				</tr>
				<tr>
					<th>Password:</th>
					<td><input id="password" type="password" name="pass" maxlength="100" class="validate[required]"/></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" id="do_login" name="login" value="Login"/></td>
				</tr>
			</table>
			</form>
		</div>
	
		<div id="new_user" style="display:none">
			<br/>
			<form id="registerForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<table>
				<tr>
					<th>Email (required):</th>
					<td><input id="username"  type="text" name="username" maxlength="25" class="validate[required,custom[email]]"/><br/><br/></td>
				</tr>
				<tr>
					<th>First name:</th>
					<td><input id="firstName"  type="text" name="firstName" maxlength="20" class="validate[required]"/><br/><br/></td>
				</tr>
				<tr>
					<th>Last name:</th>
					<td><input id="lastName" type="text" name="lastName" maxlength="20" class="validate[required]"/></td>
				</tr>
				<tr>
					<th>Street:</th>
					<td><input id="street"  type="text" name="street" maxlength="25" /><br/><br/></td>
				</tr>
				<tr>
					<th>City:</th>
					<td><input id="city" type="text" name="city" maxlength="25" /></td>
				</tr>
				<tr>
					<th>State:</th>
					<td><input id="state"  type="text" name="state" maxlength="2"/><br/><br/></td>
				</tr>
				<tr>
					<th>Zip:</th>
					<td><input id="zip" type="text" name="zip" maxlength="5" /></td>
				</tr>
				<tr>
					<th>Phone:</th>
					<td><input id="phone"  type="text" name="phone" maxlength="25"/><br/><br/></td>
				</tr>
				<tr>
					<th>Interests:</th>
					<td><input id="interests" type="text" name="interests" maxlength="4000" /></td>
				</tr>
				<tr>

					<td>Activities:</td>
					<table align = left>
					<?php $activities = mysql_query("select * from activities");
						while($activities1 = mysql_fetch_array($activities)){
							echo "<tr><input id='activities'  type='checkbox' name='activities[]' value='".
							$activities1[1]."' />".$activities1[1]."</tr><br>";
						}?>

					<th>Activities:</th>
					<table align="left">
					<?php $activities = mysql_query("select * from ACTIVITIES");
						while($activities1 = mysql_fetch_array($activities)){
							echo "<tr><input id='activities'  type='checkbox' name='activities' value='".
							$activities1['ACTIVITY_NAME']."' />".$activities1['ACTIVITY_NAME']."</tr></br>";
						}?>

					</table>
				</tr>
				<tr>
					<th>Password (required):</th>
					<td><input id="password" type="password" name="password" maxlength="100" class="validate[required]" minlength="6"/></td>
				</tr>
				<tr>
					<th>Confirm Password (required):</th>
					<td><input id="confirm" type="password" name="confirm" maxlength="100" class="validate[required]" equalTo="#password"/></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" id="do_register" name="register" value="Get ConnActed!"/></td>
				</tr>
			</table>
			</form>
		</div>
		</div> <!-- /welcome_form-->

<? include('views/footer.php'); ?>