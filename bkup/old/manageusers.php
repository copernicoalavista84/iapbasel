<?php include("header.php");

if($stat[acctype] == 'User'){
print "You cant be here.";
include("footer.php");
exit;
}
?>
<style type="text/css">
table.sap td {
border:1px solid #ccc;
padding:2px;
}
</style>
<?
//
// MAIN
//
if(!$_REQUEST['action']){
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Manage Tests</a> | <B>Managing Users</B><BR><BR><a href=manageusers.php?action=add>Add User</a><BR>";

if($stat[acctype] == 'Admin'){
     $ferrari = mysql_query("select * from members where id!='1' and (acctype='Psychologist' OR acctype='User')");
}elseif($stat[acctype] == 'Psychologist'){
     $ferrari = mysql_query("select * from members where id!='1' and acctype='User' and createdbyid='$stat[id]'");
//}elseif($stat[acctype] == 'User Manager'){
//     $ferrari = mysql_query("select * from members where id!='1' and acctype='User' and createdbyid='$stat[id]'");
}
  if($stat[acctype] == 'Psychologist'){
   echo "<TABLE class='sap' width='650'><TR><TD width='100'><B>First Name</B></TD><TD width='150'><B>Last Name</B></TD><TD width='100'><B>Company</B></TD><TD><B>Position</B></TD><td width='100'><B>Actions</B></TD></TR>";
while($fer = mysql_fetch_array($ferrari)){
   $creator = mysql_fetch_array(mysql_query("select * from members where id='$fer[createdbyid]'"));
    $namesplit = explode(" ", $fer[fullname]);
    $firster = $namesplit[0];
    $laster = $namesplit[1];
    echo "<TR><TD>$firster</TD><TD>$laster</TD><TD>$fer[company]</TD><TD>$fer[relationship]</TD><TD><a href='manageusers.php?action=edit&mid=$fer[id]'>Edit</a> | <a href='manageusers.php?action=delete&mid=$fer[id]'>Delete</a></TD></TR>";
}
   echo "</TABLE>";
  }else{
   echo "<TABLE class='sap' width='650'><TR><TD width='100'><B>Name</B></TD><TD width='150'><B>Email</B></TD><TD width='100'><B>Type</B></TD><TD><B>Belongs To</B></TD><td width='100'><B>Actions</B></TD></TR>";
while($fer = mysql_fetch_array($ferrari)){
   $creator = mysql_fetch_array(mysql_query("select * from members where id='$fer[createdbyid]'"));
    echo "<TR><TD>$fer[fullname]</TD><TD>$fer[email]</TD><TD>$fer[acctype]</TD><TD>$creator[fullname]</TD><TD><a href='manageusers.php?action=edit&mid=$fer[id]'>Edit</a> | <a href='manageusers.php?action=delete&mid=$fer[id]'>Delete</a></TD></TR>";
}
   echo "</TABLE>";
  }
//
// END MAIN
//
}elseif($_REQUEST['action'] == 'add'){
//
// ADD USER
//
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Manage Tests</a> | <a href=manageusers.php>Back</a>";
?>
<form action="manageusers.php?action=addnext" method="post">
<TABLE><TR><TD width="100">Email:</TD><TD><input type="text" id="addemail" name="addemail"></TD></TR>
<TR><TD width="100">First Name:</TD><TD><input type="text" id="addfirstname" name="addfirstname"></TD></TR>
<TR><TD width="100">Last Name:</TD><TD><input type="text" id="addlastname" name="addlastname"></TD></TR>
<TR><TD width="100">Password:</TD><TD><input type="text" id="addpasser" name="addpasser"></TD></TR>
<TR><TD>Gender</TD><TD><select id="addgender" name="addgender"><option value="Male">Male</option><option value="Female">Female</option></select></TD></TR>
<TR><TD width="100">Company:</TD><TD><input type="text" id="addcompany" name="addcompany"></TD></TR>
<TR><TD width="100">Division:</TD><TD><input type="text" id="adddivision" name="adddivision"></TD></TR>
<TR><TD width="100">Team:</TD><TD><input type="text" id="addteam" name="addteam"></TD></TR>
<TR><TD width="100">Education:</TD><TD><input type="text" id="addedu" name="addedu"></TD></TR>
<TR><TD width="100">Position:</TD><TD><input type="text" id="addrelship" name="addrelship"></TD></TR>
<TR><TD width="100">Account Type:</TD><TD>
<?
if($stat[acctype] == 'Admin'){
     echo "<select id='acctype' name='acctype'><option value='Psychologist'>Psychologist</option></select>";
}elseif($stat[acctype] == 'Psychologist'){
     echo "<select id='acctype' name='acctype'><option value='User'>User</option></select>";
}
?>
</TD></TR><TR><TD style="text-align:right;vertical-align:top;"><input type="submit" id="createacc" name="createacc" value="Create"></form></TD><TD><form action="manageusers.php"><input type="submit" name="cancel" value="Cancel"></form></TD></TR></TABLE>
<? 
// SUBMIT ADD USER FORM
//
}elseif($_REQUEST['action'] == 'addnext'){
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Manage Tests</a> | <a href=manageusers.php>Back</a>";
     $addemail = $_POST['addemail'];
$firstn = $_POST['addfirstname'];
$lastn = $_POST['addlastname'];
     $addfullname = "$firstn $lastn";
     $gender = $_POST['addgender'];
     $addpasser = $_POST['addpasser'];
       $addcompany = $_POST['addcompany'];
       $adddivision = $_POST['adddivision'];
       $addteam = $_POST['addteam'];
$addedu = $_POST['addedu'];
$addrelship = $_POST['addrelship'];
     $acctype = $_POST['acctype'];
   mysql_query("INSERT INTO `members` (`passer`, `email`, `acctype`, `createdbyid`, `fullname`, `gender`, `company`, `division`, `team`, `education`, `relationship`) VALUES('$addpasser', '$addemail', '$acctype', '$stat[id]', '$addfullname', '$gender', '$addcompany', '$adddivision', '$addteam', '$addedu', '$addrelship')");

print "<BR><BR>User created! <a href=manageusers.php>Go Back.</a>";

//
// END ADD USER, START USER EDITING
//
}elseif($_REQUEST['action'] == 'edit'){
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Manage Tests</a> | <a href=manageusers.php>Back</a>";
$mid = $_GET['mid'];
  $editing = mysql_fetch_array(mysql_query("select * from members where id='$mid'"));
?>
<form action="manageusers.php?action=editnext&mid=<?php print "$mid"; ?>" method="post">
<TABLE><TR><TD width="100">Email:</TD><TD><input type="text" id="addemail" name="addemail" value="<?php print "$editing[email]"; ?>"></TD></TR>
<TR><TD width="100">Full Name:</TD><TD><input type="text" id="addfullname" name="addfullname" value="<?php print "$editing[fullname]"; ?>"></TD></TR>
<TR><TD width="100">Password:</TD><TD><input type="text" id="addpasser" name="addpasser" value="<?php print "$editing[passer]"; ?>"></TD></TR>
<TR><TD>Gender</TD><TD><select id="addgender" name="addgender"><option selected="selected" value="<?php print "$editing[gender]"; ?>"><?php print "$editing[gender]"; ?></option><option value="Male">Male</option><option value="Female">Female</option></select></TD></TR>
<TR><TD width="100">Company:</TD><TD><input type="text" id="addcompany" name="addcompany" value="<?php print "$editing[company]"; ?>"></TD></TR>
<TR><TD width="100">Division:</TD><TD><input type="text" id="adddivision" name="adddivision" value="<?php print "$editing[division]"; ?>"></TD></TR>
<TR><TD width="100">Team:</TD><TD><input type="text" id="addteam" name="addteam" value="<?php print "$editing[team]"; ?>"></TD></TR>
<TR><TD width="100">Education:</TD><TD><input type="text" id="addedu" name="addedu" value="<?php print "$editing[education]"; ?>"></TD></TR>
<TR><TD width="100">Relationship:</TD><TD><input type="text" id="addrelship" name="addrelship" value="<?php print "$editing[relationship]"; ?>"></TD></TR>
<TR><TD width="100">Account Type:</TD><TD>
<?
if($stat[acctype] == 'Admin'){
      if($editing[acctype] == 'Psychologist'){
     echo "<select id='acctype' name='acctype'><option value='Psychologist' selected='selected'>Psychologist</option><option value='User'>User</option></select>";
      }elseif($editing[acctype] == 'User'){
     echo "<select id='acctype' name='acctype'><option value='User' selected='selected'>User</option><option value='Psychologist'>Psychologist</option></select>";
     }
}elseif($stat[acctype] == 'Psychologist'){
     if($editing[acctype] == 'User'){
     echo "<select id='acctype' name='acctype'><option value='User' selected='selected'>User</option></select>";
     }
}
?>
</TD></TR><TR><TD style="text-align:right;vertical-align:top;"><input type="submit" id="editacc" name="editacc" value="Edit"></form></TD><TD><form action="manageusers.php"><input type="submit" name="cancel" value="Cancel"></form></TD></TR></TABLE>
<? 
}elseif($_REQUEST['action'] == 'editnext'){
$mid = $_GET['mid'];
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Manage Tests</a> | <a href=manageusers.php>Back</a>";
     $addemail = $_POST['addemail'];
     $addfullname = $_POST['addfullname'];
     $addpasser = $_POST['addpasser'];
     $acctype = $_POST['acctype'];
       $addcompany = $_POST['addcompany'];
       $adddivision = $_POST['adddivision'];
       $addteam = $_POST['addteam'];
       $addedu = $_POST['addedu'];
       $addrelship = $_POST['addrelship'];
       $addgender = $_POST['addgender'];
mysql_query("update members set gender='$addgender' where id='$mid'");
mysql_query("update members set company='$addcompany' where id='$mid'");
mysql_query("update members set division='$adddivision' where id='$mid'");
mysql_query("update members set team='$addteam' where id='$mid'");
mysql_query("update members set education='$addedu' where id='$mid'");
mysql_query("update members set email='$addemail' where id='$mid'");
mysql_query("update members set fullname='$addfullname' where id='$mid'");
mysql_query("update members set passer='$addpasser' where id='$mid'");
mysql_query("update members set acctype='$acctype' where id='$mid'");
mysql_query("update members set relationship='$addrelship' where id='$mid'");

print "<BR><BR>User edited! <a href=manageusers.php>Go Back.</a>";
//
// END USER EDITS, START ACC DELETING
//
}elseif($_REQUEST['action'] == 'delete'){
   $mid = $_GET['mid'];
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Manage Tests</a> | <a href=manageusers.php>Back</a>";
   $deling = mysql_fetch_array(mysql_query("select * from members where id='$mid'"));
echo "<BR><BR>Name: $deling[fullname]<BR>Email: $deling[email]<BR>Are you sure you want to delete this account? <a href='manageusers.php?action=deleteacc&mid=$mid'>Yes</a> | <a href=manageusers.php>No</a>";

}elseif($_REQUEST['action'] == 'deleteacc'){
   $mid = $_GET['mid'];
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Manage Tests</a> | <a href=manageusers.php>Back</a>";
mysql_query("DELETE from members where id='$mid'");
print "<BR><BR>User deleted! <a href=manageusers.php>Go Back.</a>";
}
//
// END USER DELETING
//
include("footer.php"); ?>