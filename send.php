<?php 
require_once("config.php");
checklogin();
if(isset($_POST['testid']) && isset($_POST['memid'])){
	@extract($_POST);
	$alt=mysql_fetch_array(mysql_query("select * from testassign where `tid`='$testid' AND `uid`=$memid"));
	if(empty($alt)){
		mysql_query("INSERT INTO `testassign` (`uid`, `tid`) VALUES ('$memid', '$testid')");
		$del=mysql_fetch_array(mysql_query("select * from tests where `tid`='$testid'"));
		$invites = $del['invites']+1;
		mysql_query("UPDATE `tests` SET `invites`='$invites' where `tid`='$testid'");
	}
	sendmail(4,$memid);	
}
?>