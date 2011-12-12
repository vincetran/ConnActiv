<? include('functions/config.php') ?>

<script type="text/javascript">

	$(function() {

	$('.thumbs_up').click(function() {
			window.location.href = 'profile.php';
		});	
		
	$('.thumbs_down').click(function() {
			window.location.href = 'profile.php';
		});
	
	$('.fav').click(function(e) {
		//alert(this.id); //li = id corresponding to stream_ id
		e.preventDefault();
		el = $(this).attr('id').split('_').pop();
		
		//Not working due to reload - window.location.href = '/views/home.php';
		
		$('.stream').hide();
		$('.link_stream').removeClass('tab_active');
		$('#'+el).addClass('tab_active');
		$('#stream_' +el).show();
	});
	
	close_details = $("<span class='clickable close'></span>").click(function() {
		$(this).parent('.details_question').fadeOut();
	});
	
	$('div.question').click(function() {
		id = $(this).attr('id');
		$('#details_'+id).append(close_details)
		.fadeIn('slow');
	});
		
});
	
</script>

<div id="sidebar">
	<br/>
	<img src="<? echo getUserPic(getUserId()); ?>" height="120"/>
	<h2 class="sidebar"><? echo getName(); ?></h2>
	
	<div id="reviews" class="question" style="left:-40px;top:100px"></div>
	<div id="details_reviews" class="details_question" style="left:-120px;display:none"><span class="blue">Reviews</span> of an individual are written by people who have<br>done connactions with the user.</div>
	
	<table id="test" class="top_border" border="0" align="center">
		<tr>
			<td class="thumbs_up clickable"><img class="thumbs" src="../public/images/thumbs_up.png" height="60"/></td>
			<td class="thumbs_down clickable"><img class="thumbs" src="../public/images/thumbs_down.png" height="60"/></td>
		</tr>
		<tr>
			<td class="thumbs_up clickable"><h3><? echo totalReviews('positive'); ?></h3></td>
			<td class="thumbs_down clickable"><h3><? echo totalReviews('negative'); ?></h3></td>
		</tr>	
	</table>
	
	<div id="my_favorites">
		<div id="favorites" class="question" style="left:-40px;top:100px"></div>
		<div id="details_favorites" class="details_question" style="left:-120px;top:480px;display:none"><span class="blue">Favorite</span> networks that you want to view frequently. Set them up under Settings.</div>
	
		<h3 class="sidebar">Favorites</h3>
		
		<div>
		<?
			$favs = getFavoritesWithIDs();
			if ($favs):
				echo "<ul class='tags'>";
				foreach ($favs as $fav):
					echo "<li class='side_list'><a href='#' id='goto_".$fav[0]."' class='fav'>".$fav[1]. ", " .$fav[2]. " - ".$fav[3]."</a></li>";
				endforeach;
				echo "</ul>";
			else:
				echo "None yet!";
			endif;
		?>
		</div>
	</div><!-- end favorites -->
</div>
