<?php include("header.php");

print "Welcome $stat[fullname], $stat[acctype]<BR>";
if($stat[acctype] == 'Admin'){
     print "<BR><a href=manageusers.php>Manage Users</a><BR><a href=managetests.php>Manage Tests</a><BR><a href=logout.php>Logout</a>";
}elseif($stat[acctype] == 'Psychologist'){
     print "<BR><a href=manageusers.php>Manage Users</a><BR><a href=managetests.php>Manage Tests</a><BR><a href=logout.php>Logout</a>";
}elseif($stat[acctype] == 'User'){
      $seeif = mysql_num_rows(mysql_query("select * from results where correct='' and memid='$stat[id]'"));
    if($seeif > 0){
        $torch = mysql_query("select * from tests");
        while($forb = mysql_fetch_array($torch)){
            $avail = mysql_num_rows(mysql_query("select * from results where answered='' and memid='$stat[id]' and testid='$forb[id]'"));
            if($avail > 0){
                 print "<BR>$forb[testname] is Available for you to take! <a href=test.php?tid=$forb[id]>Take Test.</a>";
            }
        }
    }else{
        print "<BR>No test available. You will be emailed when one is available.";
    }
    print "<BR><a href=logout.php>Logout</a>";
}

include("footer.php"); ?>