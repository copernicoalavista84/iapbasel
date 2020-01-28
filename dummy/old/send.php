<?php include("config.php");

$ans = $_POST['ans'];
$quest = $_POST['quest'];
$memid = $_POST['memid'];
mysql_query("update results set answered='$ans' where memid='$memid' and questionid='$quest'");

?>