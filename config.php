<?php
ob_Start();
//SESSION START
session_start();
//ERROR REPORTING
error_reporting(-1);



if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='192.168.2.27'){
 $con = mysqli_connect("localhost", "administrador", "fer607372785", "db429586031");
}
else{
 $con = mysqli_connect("db429586031.db.1and1.com", "dbo429586031", "Basel2012.","db429586031");
}	

/* verificar la conexión */
if (mysqli_connect_errno()) {
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
}

 require_once('functions.php');
?>
