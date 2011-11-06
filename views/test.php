<?php //echo "hi you dumb ass mutha plucka"; 

include("config.php");


$activities = getUserNetworkActivities("Oakland");

print_r($activities);
echo $activities[0];
//echo $activities[1];

?>
