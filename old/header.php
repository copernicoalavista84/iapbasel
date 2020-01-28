<?php
include("config.php");
$female = $_COOKIE["email"];
$male = $_COOKIE["passer"];
$stat = mysql_fetch_array(mysql_query("select * from members where email='$female' and passer='$male'"));
?>
<html>
<head>
<title>IAP Basel Surveying</title>
<style type="text/css">
       body {
            font-family: "Helvetica","Arial",sans-serif;
            color: #1A1A1A;
          }
</style>
</head>
<BODY style="min-width:850px;margin:0 auto;">
<CENTER><img src="images/IAP-BASEL.jpg" style="padding-top:5px;">
<BR><img src="images/IAP_Adressfuss.jpg" width="800"><BR><BR>
<div style="width:700px;padding:5px;-moz-box-shadow: inset 0 0 10px #000000;-webkit-box-shadow: inset 0 0 10px #000000;box-shadow: inset 0 0 10px #000000;">