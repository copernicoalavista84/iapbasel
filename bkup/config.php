<?php
//OB START
ob_start();
//SESSION START
session_start();
//ERROR REPORTING
error_reporting(0);
//Database connection
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='192.168.2.27'){
$dbh=mysql_connect ("localhost", "root", "") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("iapbasel");
}
else{
$dbh=mysql_connect ("db429586031.db.1and1.com", "dbo429586031", "basel2012") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("db429586031");  
}
require_once('functions.php');
?>