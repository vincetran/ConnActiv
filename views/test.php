<?php //echo "hi you dumb ass mutha plucka"; 

include("config.php");

$networks = getNetworkActivites("Oakland");

print_r($networks);
echo $networks[0];
echo $networks[1];

?>
