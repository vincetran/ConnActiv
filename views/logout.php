<?php 
			
	$hour = time() - 3600;
	echo setcookie('ID_my_site', null, $hour, '/'); 
	echo setcookie('Key_my_site', null, $hour, '/');

	header("Location: ../index.php"); 

 ?> 