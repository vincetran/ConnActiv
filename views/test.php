<?php //echo "hi you dumb ass mutha plucka"; 

include("config.php");


$connactionUsers = getConnactions(getNetworkID("Oakland"), 1);

//print_r($connactionUsers);
echo $connactionUsers[0][2];
//echo $activities[1];

?>
