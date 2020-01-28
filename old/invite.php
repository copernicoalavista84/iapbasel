<?php include("config.php");

$testid = $_POST['testid'];
$memid = $_POST['memid'];

$fair = mysql_query("select * from questions where testid='$testid'");
while($form = mysql_fetch_array($fair)){
    mysql_query("INSERT INTO `results` (`memid`, `testid`, `questionid`) VALUES('$memid', '$testid', '$form[id]')");
}

mysql_query("update tests set canedit='N' where id='$testid'");
mysql_query("update tests set invites=invites+'1' where id='$testid'");

$mem = mysql_fetch_array(mysql_query("select * from members where id='$memid'"));

$subject = "New IAP Basel Survey Available";
$message = "Dear $mem[fullname], \n
A new survey is available for you to take at http://www.iapbasel.com. \n
Please login with this email and this password: $mem[passer] \n
Sincerely, \n
IAP Based Surveys \n";
$from = "From: noreply@iapbasel.com\r\n";
mail($mem[email], $subject, $message, $from);

?>