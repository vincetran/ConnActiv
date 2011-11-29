<? include('config.php') ?>

<script type="text/javascript">

$('.thumbs_up').click(function() {
		window.location.href = '/views/profile.php';
	});	
	
$('.thumbs_down').click(function() {
		window.location.href = '/views/profile.php';
	});
	
</script>

<div id="sidebar">
	<br/>
	<img src="<? echo getUserPic(getUserId()); ?>" height="120"/>
	<h2 class="sidebar"><? echo getName(); ?></h2>
	
	<br/>
	
	<table class="top_border" border="0" align="center">
		<tr>
			<td class="thumbs_up clickable"><img class="thumbs" src="../public/images/thumbs_up.png" height="60"/></td>
			<td class="thumbs_down clickable"><img class="thumbs" src="../public/images/thumbs_down.png" height="60"/></td>
		</tr>
		<tr>
			<td class="thumbs_up clickable"><h3><? echo totalReviews('positive'); ?></h3></td>
			<td class="thumbs_down clickable"><h3><? echo totalReviews('negative'); ?></h3></td>
		</tr>		
	</table>
	
	<div id="favorites">
		<h3 class="sidebar">Favorites</h3>
		
		<div>
		<?
			$favs = getFavorites();
			if ($favs):
				foreach ($favs as $fav):
					echo "$fav <br/>";
				endforeach;
			else:
				echo "None yet!";
			endif;
		?>
		</div>
	</div><!-- end favorites -->
</div>
