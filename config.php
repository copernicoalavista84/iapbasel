<?php
ob_Start();
//SESSION START
session_start();
//ERROR REPORTING
error_reporting(1);



if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='192.168.2.27'){
 mysqli_connect ("localhost", "root", "");
}
else{
 mysqli_connect ("db429586031.db.1and1.com", "dbo429586031", "Basel2012.","db429586031");
}	
 require_once('functions.php');
?>
