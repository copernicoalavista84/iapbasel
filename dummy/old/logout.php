<?php include("header.php");

$past = time() - 100; 
	setcookie("email", $female, $past, "/", ".iapbasel.com", 0);
	setcookie("passer", $male, $past, "/", ".iapbasel.com", 0);
//	setcookie("email", $female, $past, "/", ".techrefurbish.com", 0);
//	setcookie("passer", $male, $past, "/", ".techrefurbish.com", 0);
print "Please wait... logging you out.";
?> <meta http-equiv="refresh" content="0;url=index.php"> <?
include("footer.php"); ?>