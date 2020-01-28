<?php
session_start();
include("config.php"); ?>
<html>
<head>
<title>IAP Basel Surveying</title>

</head>
<BODY style="min-width:850px;margin:0 auto;">
<CENTER><img src="images/IAP-BASEL.jpg" style="padding-top:5px;">
<BR><img src="images/IAP_Adressfuss.jpg" width="800"><BR><BR>
<div style="width:400px;padding:5px;-moz-box-shadow: inset 0 0 10px #000000;-webkit-box-shadow: inset 0 0 10px #000000;box-shadow: inset 0 0 10px #000000;">
<?php
$email = $_POST['email'];
$passer = $_POST['passer'];

$finder = mysql_fetch_array(mysql_query("select * from members where email='$email' and passer='$passer'"));
if($finder){
     $_SESSION['iapemail'] = $email;
     $_SESSION['iappass'] = $passer;
     print "You are currently logging in, please wait..";
    ?> <meta http-equiv="refresh" content="0;url=redir.php"> <?php
}else{
     print "A member with the entered email and password was not found. <a href=index.php>Go back</a> and try again.";
}
?>
</div>
</CENTER>
</BODY>
</HTML>