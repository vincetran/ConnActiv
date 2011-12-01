<?php 
			
	$hour = time() - 3600;
	setcookie('ID_my_site', null, $hour, '/'); 
	setcookie('Key_my_site', null, $hour, '/');

	header("Location: ../index.php"); 

 ?> 