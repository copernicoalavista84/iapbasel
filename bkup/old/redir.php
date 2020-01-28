<?
session_start();
$email = $_SESSION['iapemail'];
$passer = $_SESSION['iappass'];

$expire=time()+60*60*24*30;
	setcookie("email", $email, $expire, "/", ".iapbasel.com", 0);
	setcookie("passer", $passer, $expire, "/", ".iapbasel.com", 0);
//	setcookie("email", $email, $expire, "/", ".techrefurbish.com", 0);
//	setcookie("passer", $passer, $expire, "/", ".techrefurbish.com", 0);
?> <meta http-equiv="refresh" content="0;url=members.php">