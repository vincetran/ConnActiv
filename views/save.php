<?php

//require_once 'config.php';
include("config.php");


//$query = sprintf("INSERT INTO config (token, value)
//VALUES ('%s', '%s')",
//                  $_POST['id'], stripslashes($_POST['value']));

//$interests = $_POST['about_me'];
$interests =  stripslashes($_POST['value']);

$query = sprintf("UPDATE users SET INTERESTS = '%s' WHERE USER_ID = '%s'",$interests, getUserID());

$update = mysql_query($query) or die(mysql_error());

//$dbh->exec($query);

/* sleep for a while so we can see the indicator in demo */
usleep(2000);

//This block of commented out code needs to be uncommented if you choose the editable textile
/*$renderer = $_GET['renderer'] ? $_GET['renderer'] : $_POST['renderer'];
if ('textile' == $renderer) {
    require_once './Textile.php';
    $t = new Textile();
    // What is echoed back will be shown in webpage after editing.
    print $t->TextileThis(stripslashes($_POST['value']));
} else {*/
    // What is echoed back will be shown in webpage after editing.
    print $_POST['value'];
//}
?>
