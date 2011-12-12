<? include_once("functions/config.php"); ?>

<!DOCTYPE HTML>
<html>
<head>
<title>ConnActiv | The place for activ people.</title>

<link rel="shortcut icon" type="image/x-icon" href="../public/images/favicon.ico">
<link type="text/css" rel="stylesheet" href="../styles/defaults.css"/>
<link type="text/css" rel="stylesheet/less" href="../styles/style.less"/>
<link type="text/css" rel="stylesheet/less" href="../styles/posts.less"/>
<link type="text/css" rel="stylesheet/less" href="../styles/sidebar.less"/>
<link type="text/css" rel="stylesheet" href="../styles/demo_table.css"/>
<link type="text/css" rel="stylesheet" href="../styles/validationEngine.jquery.css" />
<link type="text/css" rel="stylesheet" href="../styles/jquery.fancybox-1.3.4.css" />
<link type="text/css" rel="stylesheet/less" href="../styles/admin.less"/>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/less.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-en.js" charset="utf-8"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js" charset="utf-8"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

<link href='http://fonts.googleapis.com/css?family=Reenie+Beanie' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="../js/jquery.fancybox-1.3.4.pack.js"></script>

<!--<script type="text/javascript" src="../js/jquery.easing-1.4.pack.js"></script>
<script type="text/javascript" src="../js/jquery.mousewheel-3.0.4.pack.js"></script>
-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#user_menu').hide();
		$('#side').load('sidebar.php');
		
		$('#user_login').click(function(e) {
			e.preventDefault();
			$('#user_menu').toggle();
		});
		
		$(".fancybox").fancybox();

		$('#x').click(function(){
			$('#user_menu').toggle();
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

		setTimeout(fade_out, 3500);

		function fade_out() {
			$(".notice").slideUp();
			$(".error").slideUp();
			$(".adminAction").slideUp();
		}
		
		$('#selfReviews').dataTable({
        "aaSorting": [[ 0, "desc" ]],
        "bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true,
				"aoColumns": [ null, null, null, { "bSortable": false }, null]
   	 });
   	 
   	$('#demo').click(function() {
   		var bubble = $(this);
   		bubble.animate({
   			opacity: 0.5,
				height: '117px',
				'padding-top':'40px'
			}, 400, function() {
				bubble.html("In Demo mode, you can <span class='blue'>take a tour</span> of ConnActiv! Feel free to play around-- you can't actually mess with any of the real data. Also, you'll see some <span class='blue'>question marks</span> around the site. Click on them to find out more about a feature.<br>")
   			.fadeTo('fast',1)
   			.delay(6000).fadeOut('slow');
			});
   	});
   	
	});
</script>

</head>
<body>

<div id="container">

	<header>

	<a id="user_login" href="#"><? echo getName(); ?>&nbsp;&raquo;</a>
	
	<div id="user_menu" class="signout_opt" style="display:inline; padding: 2px 2px; width: 60px; text-align: left; color: #fff;">
			<div style="display:inline;"><a href="logout.php" id="logout">Sign out</a><div id="x"></div></div> 
	</div>
	
	<span style=" position: absolute; left: 220px">
		<a href="home.php"><img height="40" style="margin-top: -10px;" src="../public/images/logo.png"/></a>
	</span>

			<span id="top-nav">
				<ul id="nav">
					
					<? if (isAdmin()) { ?>
							<li class="headerlink" id="link_admin"><a class="top_links" id="admin" href="admin.php">Admin</a></li>
					<? } ?>
				
					<li class="headerlink" id="link_home"><a class="top_links" id="home" href="home.php">Home</a></li>
					<li class="headerlink" id="link_profile"><a class="top_links" id="profile" href="profile.php">Profile</a></li>
					<li class="headerlink" id="link_requests"><a class="top_links" id="requests" href="requests.php">Requests</a></li>
					<li class="headerlink" id="link_settings"><a class="top_links" id="settings" href="settings.php">Settings</a></li>
					</ul>
			</span>

	</header>
			
	<? if (isDemo()) { ?>
	
	<div id="demo" class="welcome_demo">
		You're in demo mode! <span class="clickable blue">What's this?</span>	
	</div>
	
	<? } ?>
		
	<div id="side">
	</div><!-- end #side -->
	
	<div id="content">
	<?php isValid() ?>
