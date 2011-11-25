<?php include("config.php");?>

<script type="text/javascript">

$('#user_menu').hide();

$('.top_links').click(function(e) {
	$(this).nav(e); // function routes to index.html script (for now, index holds more global functions)
});

$('#user_login').hover(function(e) {
		e.preventDefault();
		$('#user_menu').show();
});

$('#logout').click(function(e) {
		e.preventDefault();
		window.location.replace('views/logout.php');
		$('#user_menu').hide();
});
	
</script>

<a id="user_login" href="#"><?php echo getName(); ?>&nbsp;&raquo;</a>

<div id="user_menu" class="signout_opt" style="display:inline; padding: 2px 2px; width: 60px; text-align: left; color: #fff;">
	<a href="" id="logout">Sign out</a>
</div>

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