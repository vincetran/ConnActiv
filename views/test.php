<?php  

include("functions/config.php");


					$incRequests = getIncRequests(getUserID());
					if ($incRequests) {
					
						foreach($incRequests as $incoming){
							$fromUser = $incoming[0];
							$toUser = $incoming[1];
							$connactionID = $incoming[2];
							$message = $incoming[3];
							$approved = $incoming[4];
							$date = date_parse($incoming[5]);
							
							echo $fromUser;
							echo $toUser;
							echo $connactionID;
							echo $message;
							echo $approved;
							echo $date["month"].'/'.$date["day"].'/'.$date["year"];
							echo "<br/>";
							
						}
						
					}

?>
