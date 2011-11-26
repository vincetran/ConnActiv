<?php
//Everything commented out is my attempt to get this to work.
//The lines that have a // after are lines I added to try to get this to work
//
include("config.php");//
//require_once 'defaults.php';
$default['paragraph_2'] = 'wow this cannot be right!';//

$token    = $_GET['id'] ?  $_GET['id'] : $_POST['id'];
//$renderer = $_GET['renderer'] ?  $_GET['renderer'] : $_POST['renderer'];
$renderer = 'textile';//

/*$query = sprintf("SELECT value 
                  FROM config 
                  WHERE token='%s' 
                  ORDER BY id DESC
                  LIMIT 1", 
                  $token);*/

//$retval =  $dbh->query($query)->fetchColumn(0);

$retval = getAboutMe(getUserID());//

$retval = trim($retval) ?  $retval : $default[$token];
$retval = trim($retval) ?  $retval : 'Edit me!';

if ('textile' == $renderer) {
    require_once './Textile.php';
    $t = new Textile();
    $retval = $t->TextileThis($retval);
} 

print $retval;
