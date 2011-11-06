<?php include("config.php");?>

<script type="text/javascript">

$('.top_links').click(function(e) {
	$(this).nav(e); // function routes to index.html script (for now, index holds more global functions)
});

$('#user_login').click(function(e) {
	e.preventDefault();
	$('#user_menu').slideDown();
	});

$('#logout').click(function(e) {
	e.preventDefault();
	t = confirm('Are you sure you want to sign out?');
	if (t) {
		window.location.replace('views/logout.php');
		//alert('Signed out.'); 
	}
	$('#user_menu').hide();
});
	
</script>

<a id="user_login" href="#">
<?php echo getName(); ?>
</a>
<?php 
	if(cookieExists() && validCookie()){ ?>
		<span id="top-nav">
			<ul id="nav">
				<li class="headerlink" id="link_home"><a class="top_links" id="home" href="">Home</a></li>
				<li class="headerlink" id="link_profile"><a class="top_links" id="profile" href="">Profile</a></li>
				<li class="headerlink" id="link_requests"><a class="top_links" id="requests" href="">Requests</a></li>
				<li class="headerlink" id="link_settings"><a class="top_links" id="settings" href="">Settings</a></li>
			</ul>
		</span>
	<?php } ?>
	
<div id="user_menu" style="display:none; border:1px solid #000; height:2em; width:80px; padding: 2px 2px; text-align: center; background: #fff; color: #333;">
	<a href="" autofocus id="logout">Sign out</a>
</div>