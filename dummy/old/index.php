<?php include("config.php");
$female = $_COOKIE["email"];
$male = $_COOKIE["passer"];
$stat = mysql_fetch_array(mysql_query("select * from members where email='$female' and passer='$male'"));
if($stat){
?> <meta http-equiv="refresh" content="0;url=members.php"> <? } ?>
<html>
<head>
<title>IAP Basel Surveying</title>

</head>
<BODY style="min-width:850px;margin:0 auto;">
<CENTER><img src="images/IAP-BASEL.jpg" style="padding-top:5px;">
<BR><img src="images/IAP_Adressfuss.jpg" width="800"><BR><BR>
<div style="width:400px;padding:5px;-moz-box-shadow: inset 0 0 10px #000000;-webkit-box-shadow: inset 0 0 10px #000000;box-shadow: inset 0 0 10px #000000;">
<h2 style="margin-bottom:-1px;">Log In Now</h2>
<form method="post" action="login.php">
<TABLE><TR><TD width="80">Email:</td><td><input type="text" id="email" name="email"></td></TR>
<TR><TD>Password:</TD><td><input type="password" id="passer" name="passer"></TD></TR>
<TR><TD></TD><TD><input type="submit" id="loginsub" name="loginsub" value="Log In"></TD></TR></TABLE>
</form>
</div>
</CENTER>
</BODY>
</HTML>