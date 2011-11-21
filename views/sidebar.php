<? include 'config.php' ?>

<script type="text/javascript">

$('.thumbs_up').click(function() {
		alert("STUB: Going to the user's recommendations (positive).");
	});	
	
$('.thumbs_down').click(function() {
		alert("STUB: Going to the user's recommendations (negative).");
	});
	
</script>

<div id="sidebar">
	<br/>
	<p><img src="public/images/face2.png" height="120"/></p>
	<p><strong><? echo getName(); ?></strong></p>
	
	<br/>
	
	<table border="0" align="center">
		<tr>
			<td class="thumbs_up clickable"><img class="thumbs" src="public/images/thumbs_up1.png" height="60"/></td>
			<td class="thumbs_down clickable"><img class="thumbs" src="public/images/thumbs_down1.png" height="60"/></td>
		</tr>
		<tr>
			<td class="thumbs_up clickable"><h3>10</h3></td>
			<td class="thumbs_down clickable"><h3>0</h3></td>
		</tr>
		
		
	</table>
	
	<div id="favorites">
		<strong>My Favorites</strong><br/>
		
		<div>
		<?
			$favs = getFavorites();
			if ($favs):
				foreach ($favs as $fav):
					echo "$fav <br/>";
				endforeach;
			endif;
		?>
		</div>
	</div><!-- end favorites -->
</div>