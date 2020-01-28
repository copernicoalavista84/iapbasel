<?php include("header.php"); 
function findexts($filename){ 
$filename = strtolower($filename); 
$exts = split("[.]", $filename); 
$n = count($exts)-1; $exts = $exts[$n]; return $exts; 
} 
?>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
   $("#rose").live('click', function(){
      var classy = $(this).attr('class'); // test id
      var namo = $(this).attr('name').replace('row', ''); // mem id 
        //alert("Test: "+classy+" | Mem: "+namo);

$.post("invite.php", { testid: classy, memid: namo },
       function() {
             $("td#row"+namo).html("An email was sent & test unlocked.");
        });
      return false;

   });
</script>
<?php
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
print "<a href=members.php>Members Home</a> | <B>Managing Tests</B> | <a href=manageusers.php>Manage Users</a><BR><BR><a href=managetests.php?action=add>Add Test</a><BR>";

if($stat[acctype] == 'Admin'){
     $ferrari = mysql_query("select * from tests");
}elseif($stat[acctype] == 'Psychologist'){
     $ferrari = mysql_query("select * from tests where psychid='$stat[id]'");
}
  if($stat[acctype] == 'Psychologist'){
   echo "<TABLE class='sap' width='700'><TR><TD width='135'><B>Test Name</B></TD><TD width='135'><B>Target User</B></TD><TD width='80'><B># Completed</B></TD><TD width='80'><B>Invites Sent</B></TD><td width='220'><B>Actions</B></TD></TR>";
while($fer = mysql_fetch_array($ferrari)){
   $fredy = mysql_fetch_array(mysql_query("select * from members where id='$fer[targetid]'"));
    echo "<TR><TD>$fer[testname]</TD><TD>"; if($stat[acctype] == 'Admin'){ echo "<a href='manageusers.php?action=edit&mid=$fer[psychid]'>$fredy[fullname]</a>"; }else{ echo "$fredy[fullname]"; } echo "</TD><TD>$fer[completed]</TD><TD>$fer[invites]</TD><TD><a href='managetests.php?action=qmanager&tid=$fer[id]'>Manage</a> | <a href='managetests.php?action=testresults&tid=$fer[id]'>Results</a> | "; if($fer[canedit] == 'Y'){ echo "<a href='managetests.php?action=edit&tid=$fer[id]'>Edit</a>"; }else{ print "Edit"; } echo " | <a href='managetests.php?action=delete&tid=$fer[id]'>Delete</a></TD></TR>";
}
   echo "</TABLE>";
  }else{
   echo "<TABLE class='sap' width='625'><TR><TD width='135'><B>Test Name</B></TD><TD width='135'><B>Psychologist</B></TD><TD width='80'><B>Completed</B></TD><td width='220'><B>Actions</B></TD></TR>";
while($fer = mysql_fetch_array($ferrari)){
   $fredy = mysql_fetch_array(mysql_query("select * from members where id='$fer[psychid]'"));
    echo "<TR><TD>$fer[testname]</TD><TD>"; if($stat[acctype] == 'Admin'){ echo "<a href='manageusers.php?action=edit&mid=$fer[psychid]'>$fredy[fullname]</a>"; }else{ echo "$fredy[fullname]"; } echo "</TD><TD>$fer[completed]</TD><TD><a href='managetests.php?action=qmanager&tid=$fer[id]'>Manage</a> | <a href='managetests.php?action=testresults&tid=$fer[id]'>Results</a> | "; if($fer[canedit] == 'Y'){ echo "<a href='managetests.php?action=edit&tid=$fer[id]'>Edit</a>"; }else{ print "Edit"; } echo " | <a href='managetests.php?action=delete&tid=$fer[id]'>Delete</a></TD></TR>";
}
   echo "</TABLE>";
  }
//
// END MAIN
//
}elseif($_REQUEST['action'] == 'add'){
        print "<a href=members.php>Members Home</a> | <a href=managetests.php>Back</a> | <a href=manageusers.php>Manage Users</a>";
      $display = mysql_num_rows(mysql_query("select * from tests where psychid='$stat[id]'"));
if($display != 0){
      $fond = mysql_query("select * from tests where psychid='$stat[id]'");
?><BR><BR><form action="managetests.php?action=copytest" method="post">
Copy a Test: <select id="copytt" name="copytt"> <?php while($foo = mysql_fetch_array($fond)){ echo "<option value='$foo[id]'>$foo[testname]</option>"; } echo "</select>"; ?> Test Name: <input type="text" id="newname" name="newname"> <input type="submit" id="copytsub" name="copytsub" value="Copy"></form>

<HR>OR Create a Test<HR> <? } ?>
<form action="managetests.php?action=addnext" method="post" enctype="multipart/form-data">
<TABLE><TR><TD width="100">Test Name:</TD><TD><input type="text" id="testname" name="testname"></TD></TR>
<?
if($stat[acctype] == 'Admin'){
     echo "<TR><TD width='100'>Psychologist:</TD><TD><select id='psychid' name='psychid'>";
    $furrari = mysql_query("select * from members where acctype='Psychologist'");
        while($fur = mysql_fetch_array($furrari)){
           echo "<option value='$fur[id]'>$fur[fullname]</option>";
        }
    echo "</select></TD></TR>";
}elseif($stat[acctype] == 'Psychologist'){
     //echo "<TR><TD width='100'>Psychologist:</TD><TD><select id='psychid' name='psychid'><option value='$stat[id]'>$stat[fullname]</option></select></TD></TR>";
}
?>
<!--<TR><TD>Questions Per Page:</TD><TD><select id="perpage" name="perpage"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option></select></TD></TR>-->

<TR><TD>Logo:</TD><TD><input type="file" id="logoadd" name="logoadd"></TD></TR>
<TR><TD>Target User</TD><TD><select id="target" name="target">
<?php    $furrari = mysql_query("select * from members where createdbyid='$stat[id]'");
        while($fur = mysql_fetch_array($furrari)){
           echo "<option value='$fur[id]'>$fur[fullname]</option>";
        }
?> </select></TD></TR>
<TR><TD colspan="2">Instructions:<BR>
<textarea rows=5 cols=35 id="instructions" name="instructions"></textarea></TD></TR>

<TR><TD style="text-align:right;vertical-align:top;">
<? if($stat[acctype] == 'Psychologist'){ echo "<input type='hidden' id='psychid' name='psychid' value='$stat[id]'>"; } ?><input type="submit" id="createtest" name="createtest" value="Create"></form></TD><TD><form action="managetests.php"><input type="submit" name="cancel" value="Cancel"></form></TD></TR></TABLE>

<? 
}elseif($_REQUEST['action'] == 'copytest'){
    $copytt = $_POST['copytt'];
    $newname = $_POST['newname'];
    $detecti = mysql_fetch_array(mysql_query("select * from tests where id='$copytt'"));
 mysql_query("INSERT INTO `tests` (`testname`, `psychid`, `perpage`, `canedit`, `logo`, `instructions`, `completed`) VALUES('$newname', '$stat[id]', '1', 'Y', '$detecti[logo]', '$detecti[instructions]', '0')");
  $ntid = mysql_fetch_array(mysql_query("select * from tests where testname='$newname' and psychid='$stat[id]' and completed='0' and instructions='$detecti[instructions]'"));
    $detectz = mysql_query("select * from questions where testid='$copytt'");
   while($detect = mysql_fetch_array($detectz)){
 mysql_query("INSERT INTO `questions` (`type`, `testid`, `cateid`, `question`, `textanswer`, `memid`, `choicea`, `choiceb`, `choicec`, `choiced`, `aweight`, `bweight`, `cweight`, `dweight`) VALUES('$detect[type]', '$ntid[id]', '$detect[cateid]', '$detect[question]', '', '$stat[id]', '$detect[choicea]', '$detect[choiceb]', '$detect[choicec]', '$detect[choiced]', '$detect[aweight]', '$detect[bweight]', '$detect[cweight]', '$detect[dweight]')");   
   }
print "<BR><BR>Test copied and added! <a href=managetests.php>Go back.</a>";
// SUBMIT ADD test FORM
// 
}elseif($_REQUEST['action'] == 'addnext'){
        print "<a href=members.php>Members Home</a> | <a href=managetests.php>Back</a> | <a href=manageusers.php>Manage Users</a>";
     $testname = $_POST['testname'];
     $psychid = $_POST['psychid'];
     //$perpage = $_POST['perpage'];
     $instructions = $_POST['instructions'];
     $logoer = $_FILES['logoadd'];
     $target = $_POST['target'];
//
// START LOGO UPLOAD
//   
                $newkka = str_replace(' ','_',$logoer['name']);
		$newk = str_replace('&','and',$newkka);
		$newbok = strtolower($newk);
		$ext = findexts($newbok);
     if(!$logoer['name'] || $ext == 'gif' || $ext == 'jpeg' || $ext == 'pjpeg' || $ext == 'png' || $ext == 'jpg'){
if (file_exists("images/$newk")){
     	 //echo $newk . " already exists. ";
		$my_array = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");	
		shuffle($my_array);
$another = array_rand($my_array,15);
$randa = $my_array[$another[0]];
$randb = $my_array[$another[1]];
$randc = $my_array[$another[2]];
$randd = $my_array[$another[3]];
$rande = $my_array[$another[4]];
$randf = $my_array[$another[5]];
$randg = $my_array[$another[6]];
$randh = $my_array[$another[7]];
$randi = $my_array[$another[8]];
$randj = $my_array[$another[9]];
$randk = $my_array[$another[10]];
$randl = $my_array[$another[11]];
$randm = $my_array[$another[12]];
$randn = $my_array[$another[13]];
$rando = $my_array[$another[14]];
$randp = $my_array[$another[15]];
$randq = $my_array[$another[16]];
$randr = $my_array[$another[17]];
$rands = $my_array[$another[18]];
$randt = $my_array[$another[19]];
$randu = $my_array[$another[20]];
$hasher = "$randa$randb$randc$randd$rande$randf$randg$randh$randi$randj$randk$randl$randm$randn$rando$randp$randq$randr$rands$randt$randu";
                 $fries = "$hasher.$ext";
	move_uploaded_file($logoer["tmp_name"], "images/".$fries);
$logo = $fries;

}else{
    move_uploaded_file($logoer["tmp_name"], "images/".$newk);
$logo = $newk;
}
    }else{
    print "<BR><BR>We only allow .gif, .jpg, .jpeg and .png images. <a href=managetests.php?action=add>Go back</a> and try again.";
     include("footer.php");
    exit;
    }
//
// END LOGO UPLOAD
//
     $perpage = '1';
if($logoer['name']){
   mysql_query("INSERT INTO `tests` (`testname`, `psychid`, `perpage`, `logo`, `instructions`, `targetid`) VALUES('$testname', '$psychid', '$perpage', '$logo', '$instructions', '$target')");
}else{
   mysql_query("INSERT INTO `tests` (`testname`, `psychid`, `perpage`, `logo`, `instructions`, `targetid`) VALUES('$testname', '$psychid', '$perpage', '', '$instructions', '$target')");
}

print "<BR><BR>Test created! <a href=managetests.php>Go Back.</a>";
//
// END TEST ADDITION, START TEST EDITING
//
}elseif($_REQUEST['action'] == 'edit'){
        print "<a href=members.php>Members Home</a> | <a href=managetests.php>Back</a> | <a href=manageusers.php>Manage Users</a><BR><BR>";
    $tid = $_GET['tid'];
    $editing = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
?>
  <?php if($editing[logo]){ ?> <img src="images/<?php print "$editing[logo]"; ?>"><BR> <? } ?>
<form action="managetests.php?action=editnext&tid=<?php print "$tid"; ?>" method="post" enctype="multipart/form-data">
<TABLE><TR><TD width="100">Test Name:</TD><TD><input type="text" id="testname" name="testname" value="<?php print "$editing[testname]"; ?>"></TD></TR>
<TR><TD>Logo:</TD><TD><input type="file" id="logoadds" name="logoadds"></TD></TR>
<?
if($stat[acctype] == 'Admin'){
    $editor = mysql_fetch_array(mysql_query("select * from members where id='$editing[psychid]'")); 
     echo "<TR><TD width='100'>Psychologist:</TD><TD><select id='psychid' name='psychid'><option value='$editing[psychid]' selected='selected'>$editor[fullname]</option>";
    $furrari = mysql_query("select * from members where acctype='Psychologist'");
        while($fur = mysql_fetch_array($furrari)){
           echo "<option value='$fur[id]'>$fur[fullname]</option>";
        }
    echo "</select></TD></TR>";
}elseif($stat[acctype] == 'Psychologist'){
     echo "<TR><TD width='100'>Psychologist:</TD><TD><select id='psychid' name='psychid'><option value='$stat[id]'>$stat[fullname]</option></select></TD></TR>";
}
?>
<!--<TR><TD>Questions Per Page: </TD><TD><select id="perpage" name="perpage"><option value="<?php print "$editing[perpage]"; ?>" selected="selected"><?php print "$editing[perpage]"; ?></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option></select></TD></TR>-->

<TR><TD colspan="2">Instructions:<BR>
<textarea rows=5 cols=35 id="instructions" name="instructions"><?php print "$editing[instructions]"; ?></textarea></TD></TR>

<TR><TD style="text-align:right;vertical-align:top;"><input type="submit" id="edittest" name="edittest" value="Edit"></form></TD><TD><form action="managetests.php"><input type="submit" name="cancel" value="Cancel"></form></TD></TR></TABLE>
<?
}elseif($_REQUEST['action'] == 'editnext'){
        print "<a href=members.php>Members Home</a> | <a href=managetests.php>Back</a> | <a href=manageusers.php>Manage Users</a>";
    $tid = $_GET['tid'];
    $psychid = $_POST['psychid'];
    $testname = $_POST['testname'];
    //$perpage = $_POST['perpage'];
    $instructions = $_POST['instructions'];
     $logoer = $_FILES['logoadds'];
//mysql_query("update tests set perpage='$perpage' where id='$tid'");
mysql_query("update tests set instructions='$instructions' where id='$tid'");
mysql_query("update tests set testname='$testname' where id='$tid'");
mysql_query("update tests set psychid='$psychid' where id='$tid'");

if($logoer){
//
// START LOGO UPLOAD
//   
                $newkka = str_replace(' ','_',$logoer['name']);
		$newk = str_replace('&','and',$newkka);
		$newbok = strtolower($newk);
		$ext = findexts($newbok);
     if($ext == 'gif' || $ext == 'jpeg' || $ext == 'pjpeg' || $ext == 'png' || $ext == 'jpg'){
if (file_exists("images/$newk")){
     	 //echo $newk . " already exists. ";
		$my_array = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");	
		shuffle($my_array);
$another = array_rand($my_array,15);
$randa = $my_array[$another[0]];
$randb = $my_array[$another[1]];
$randc = $my_array[$another[2]];
$randd = $my_array[$another[3]];
$rande = $my_array[$another[4]];
$randf = $my_array[$another[5]];
$randg = $my_array[$another[6]];
$randh = $my_array[$another[7]];
$randi = $my_array[$another[8]];
$randj = $my_array[$another[9]];
$randk = $my_array[$another[10]];
$randl = $my_array[$another[11]];
$randm = $my_array[$another[12]];
$randn = $my_array[$another[13]];
$rando = $my_array[$another[14]];
$randp = $my_array[$another[15]];
$randq = $my_array[$another[16]];
$randr = $my_array[$another[17]];
$rands = $my_array[$another[18]];
$randt = $my_array[$another[19]];
$randu = $my_array[$another[20]];
$hasher = "$randa$randb$randc$randd$rande$randf$randg$randh$randi$randj$randk$randl$randm$randn$rando$randp$randq$randr$rands$randt$randu";
                 $fries = "$hasher.$ext";
	move_uploaded_file($logoer["tmp_name"], "images/".$fries);
$logo = $fries;
  mysql_query("update tests set logo='$logo' where id='$tid'");

}else{
    move_uploaded_file($logoer["tmp_name"], "images/".$newk);
$logo = $newk;
  mysql_query("update tests set logo='$logo' where id='$tid'");

}
    }else{
    print "<BR><BR>We only allow .gif, .jpg, .jpeg and .png images. <a href=managetests.php?action=add>Go back</a> and try again.";
     include("footer.php");
    exit;
    }
//
// END LOGO UPLOAD
//
}
print "<BR><BR>Test edited! <a href=managetests.php>Go Back.</a>";

//
// END TEST EDITING, START TEST DELETING
//
}elseif($_REQUEST['action'] == 'delete'){
   $tid = $_GET['tid'];
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Back</a> | <a href=manageusers.php>Manage Users</a>";
   $deling = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
echo "<BR><BR>Test Name: $deling[testname]<BR>Are you sure you want to delete this test? <u>All questions will be deleted with it.</u> <a href='managetests.php?action=deleteacc&tid=$tid'>Yes</a> | <a href=managetests.php>No</a>";

}elseif($_REQUEST['action'] == 'deleteacc'){
   $tid = $_GET['tid'];
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Back</a> | <a href=manageusers.php>Manage Users</a>";
mysql_query("DELETE from tests where id='$tid'");
print "<BR><BR>Test deleted! <a href=managetests.php>Go Back.</a>";

//
//END TEST DELETING, START QUESTION MANAGER
//
}elseif($_REQUEST['action'] == 'qmanager'){
  $tid = $_GET['tid'];
     print "<a href=members.php>Members Home</a> | <a href=managetests.php>Back</a> | <a href=manageusers.php>Manage Users</a>";
$deling = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
print "<BR><BR><B>$deling[testname]</B><BR><u>Question Categories:</u>";
    $furr = mysql_query("select * from categories where testid='$tid'");
        while($food = mysql_fetch_array($furr)){
            print "<BR>$food[category]";
        }
           echo "<BR><a href='managetests.php?action=addcate&tid=$tid'>Add Category</a><BR><BR>";
if($deling[canedit] == 'Y'){ echo "<a href=managetests.php?action=addquest&tid=$tid>Add MC Question</a> | <a href=managetests.php?action=addtquest&tid=$tid>Add Text Question</a>"; }else{ print "Add MC Question | Add Text Question"; } echo " | <a href=managetests.php?action=inviteusers&tid=$tid>Select Users to Take</a><BR>";

     $fari = mysql_query("select * from questions where testid='$tid'");
   echo "<TABLE class='sap' width='550'><TR><TD width='225'><B>Question</B></TD><TD width='75'><B>Type</B></TD><TD width='125'><B>Category</B></TD><td width='125'><B>Actions</B></TD></TR>";
            while($fer = mysql_fetch_array($fari)){
                  $caty = mysql_fetch_array(mysql_query("select * from categories where id='$fer[cateid]'"));
                 echo "<TR><TD>$fer[question]</TD><TD>$fer[type]</TD><TD>$caty[category]</TD><TD>"; if($deling[canedit] == 'Y'){ echo "<a href='managetests.php?action=editq&qid=$fer[id]&tid=$tid'>Edit</a>"; }else{ echo "Edit"; } echo" | <a href='managetests.php?action=delq&qid=$fer[id]&tid=$tid'>Delete</a></TD></TR>";
            }
   echo "</TABLE>";
//
// END QUESTION MANAGER, START ADD CATEGORY TO TESTS
//
}elseif($_REQUEST['action'] == 'addcate'){
    $tid = $_GET['tid'];
     print "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a><BR><BR>";
?> <form action="managetests.php?action=catenext&tid=<?php print "$tid"; ?>" method="post">
Category: <input type="text" name="testcate" id="testcate"> <input type="submit" id="cateadd" name="cateadd" value="Add"> </form>
<?php }elseif($_REQUEST['action'] == 'catenext'){
     print "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a>";
    $tid = $_GET['tid'];
    $testcate = $_POST['testcate'];
mysql_query("INSERT INTO `categories` (`category`, `testid`) VALUES('$testcate', '$tid')");

print "<BR><BR>Category added! <a href=managetests.php?action=qmanager&tid=$tid>Go Back.</a>";
//
// END ADD CATES TO TESTS, START ADD QUESTIONS TO TEST
//
}elseif($_REQUEST['action'] == 'addquest'){
     $tid = $_GET['tid'];
$deling = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
     echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a><BR><BR>For <B>$deling[testname]</B>:<BR><BR>";
$fond = mysql_query("select * from questions where memid='$stat[id]' and type='MC'");
?> <form action="managetests.php?action=copyque&tid=<?php print "$tid"; ?>" method="post">
Copy MC Question: <select id="copyquest" name="copyquest"> <?php while($foo = mysql_fetch_array($fond)){ echo "<option value='$foo[id]'>$foo[question]</option>"; } echo "</select>"; ?> <input type="submit" id="copysub" name="copysub" value="Copy"></form>

<HR>OR Create a Question<HR>
<form action="managetests.php?action=questnext&type=mc&tid=<?php print "$tid"; ?>" method="post">
<TABLE width="465" class="sap"><TR><TD width="100">Question: </TD><TD width="365"><input type="text" id="question" name="question" size="50"></TD></TR>
<TR><TD>Category: </TD><TD><select id="questcate" name="questcate"><?
                     $furr = mysql_query("select * from categories where testid='$tid'");
                        while($food = mysql_fetch_array($furr)){
                           echo "<option value='$food[id]'>$food[category]</option>";
                        }
?> </select></TD></TR><TR><TD>Choice A: </TD><TD><input type="text" id="choicea" name="choicea"> Weight <select id="aweight" name="aweight"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>
<TR><TD>Choice B: </TD><TD><input type="text" id="choiceb" name="choiceb"> Weight <select id="bweight" name="bweight"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>
<TR><TD>Choice C: </TD><TD><input type="text" id="choicec" name="choicec"> Weight <select id="cweight" name="cweight"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>
<TR><TD>Choice D: </TD><TD><input type="text" id="choiced" name="choiced"> Weight <select id="dweight" name="dweight"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>

<!--<TR><TD>Correct Choice</TD><TD>A <input type="radio" id="correctchoice" name="correctchoice" value="a"> | B <input type="radio" id="correctchoice" name="correctchoice" value="b"> | C <input type="radio" id="correctchoice" name="correctchoice" value="C"> | D <input type="radio" id="correctchoice" name="correctchoice" value="D"></TD></TR>-->

<tr><TD style="text-align:right;vertical-align:top;"><input type="submit" id="amcqsub" name="amcqsub" value="Add"></FORM></TD><TD><form action="managetests.php?action=qmanager&tid=<?php print "$tid"; ?>"><input type="submit" name="cancel" value="Cancel"></form></TD></TR>
</TABLE>
<?php
}elseif($_REQUEST['action'] == 'addtquest'){
     $tid = $_GET['tid'];
$deling = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
     echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a><BR><BR>For <B>$deling[testname]</B>:<BR><BR>";
$fond = mysql_query("select * from questions where memid='$stat[id]' and type='Text'");
?><form action="managetests.php?action=copytque&tid=<?php print "$tid"; ?>" method="post">
Copy Text Question: <select id="copyquest" name="copyquest"> <?php while($foo = mysql_fetch_array($fond)){ echo "<option value='$foo[id]'>$foo[question]</option>"; } echo "</select>"; ?> <input type="submit" id="copysub" name="copysub" value="Copy"></form>

<HR>OR Create a Question<HR>

<form action="managetests.php?action=questnext&type=text&tid=<?php print "$tid"; ?>" method="post">
<TABLE width="465" class="sap"><TR><TD width="100">Question: </TD><TD width="365"><input type="text" id="question" name="question" size="50"></TD></TR>
<TR><TD>Category: </TD><TD><select id="questcate" name="questcate"><?
                     $furr = mysql_query("select * from categories where testid='$tid'");
                        while($food = mysql_fetch_array($furr)){
                           echo "<option value='$food[id]'>$food[category]</option>";
                        }
?> </select></TD></TR><TR><TD>Answer: </TD><TD><input type="text" id="textanswer" name="textanswer"></TD></TR>
<tr><TD style="text-align:right;vertical-align:top;"><input type="submit" id="atqsub" name="atqsub" value="Add"></FORM></TD><TD><form action="managetests.php?action=qmanager&tid=<?php print "$tid"; ?>"><input type="submit" name="cancel" value="Cancel"></form></TD></TR>
</TABLE>
<?php
}elseif($_REQUEST['action'] == 'copyque'){
    $copyquest = $_POST['copyquest'];
    $tid = $_GET['tid'];
    $detect = mysql_fetch_array(mysql_query("select * from questions where id='$copyquest'"));
 mysql_query("INSERT INTO `questions` (`type`, `testid`, `cateid`, `question`, `textanswer`, `memid`, `choicea`, `choiceb`, `choicec`, `choiced`, `aweight`, `bweight`, `cweight`, `dweight`) VALUES('MC', '$tid', '$detect[cateid]', '$detect[question]', '', '$stat[id]', '$detect[choicea]', '$detect[choiceb]', '$detect[choicec]', '$detect[choiced]', '$detect[aweight]', '$detect[bweight]', '$detect[cweight]', '$detect[dweight]')");   
print "<BR><BR>Question copied and added! <a href=managetests.php?action=qmanager&tid=$tid>Go back.</a>";

}elseif($_REQUEST['action'] == 'copytque'){
    $copyquest = $_POST['copyquest'];
    $tid = $_GET['tid'];
    $detect = mysql_fetch_array(mysql_query("select * from questions where id='$copyquest'"));
mysql_query("INSERT INTO `questions` (`type`, `testid`, `cateid`, `question`, `textanswer`, `memid`) VALUES('Text', '$tid', '$detect[cateid]', '$detect[question]', '$detect[textanswer]', '$stat[id]')");
print "<BR><BR>Question copied and added! <a href=managetests.php?action=qmanager&tid=$tid>Go back.</a>";

}elseif($_REQUEST['action'] == 'questnext'){
     $tid = $_GET['tid'];
     $type = $_GET['type'];
     $question = $_POST['question'];
     $questcate = $_POST['questcate'];
 echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a>";
          if($type == 'text'){
               $textanswer = $_POST['textanswer'];
mysql_query("INSERT INTO `questions` (`type`, `testid`, `cateid`, `question`, `textanswer`, `memid`) VALUES('Text', '$tid', '$questcate', '$question', '$textanswer', '$stat[id]')");
               print "<BR><BR>Question added! <a href=managetests.php?action=qmanager&tid=$tid>Go back.</a>";
          }elseif($type == 'mc'){
               $choicea = $_POST['choicea'];
               $choiceb = $_POST['choiceb'];
               $choicec = $_POST['choicec'];
               $choiced = $_POST['choiced'];
               //$correctchoice = $_POST['correctchoice'];
               $aweight = $_POST['aweight'];
               $bweight = $_POST['bweight'];
               $cweight = $_POST['cweight'];
               $dweight = $_POST['dweight'];
mysql_query("INSERT INTO `questions` (`type`, `testid`, `cateid`, `question`, `textanswer`, `memid`, `choicea`, `choiceb`, `choicec`, `choiced`, `aweight`, `bweight`, `cweight`, `dweight`) VALUES('MC', '$tid', '$questcate', '$question', '', '$stat[id]', '$choicea', '$choiceb', '$choicec', '$choiced', '$aweight', '$bweight', '$cweight', '$dweight')");
               print "<BR><BR>Question added! <a href=managetests.php?action=qmanager&tid=$tid>Go back.</a>";

         }
//
// END ADD QUESTIONS TO TESTS, START DELETE QUESTIONS
//
}elseif($_REQUEST['action'] == 'delq'){
     $qid = $_GET['qid'];
     $tid = $_GET['tid'];
$deler = mysql_fetch_array(mysql_query("select * from questions where id='$qid'"));
    echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a>";
    print "<BR><BR>Are you sure you want to delete this question? Notice all results that deal with this question will also be deleted.<BR>Question: $deler[question]<BR>Delete? <a href=managetests.php?action=delqacc&qid=$qid&tid=$tid>Yes</a> | <a href=managetests.php?action=qmanager&tid=$tid>No</a>";

}elseif($_REQUEST['action'] == 'delqacc'){
     $qid = $_GET['qid'];
     $tid = $_GET['tid'];
 echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a>";
mysql_query("DELETE from questions where id='$qid'");
print "<BR><BR>You have deleted the question. <a href=managetests.php?action=qmanager&tid=$tid>Go back.</a>";

//
// END DELETE QUESTIONS, START EDIT QUESTIONS
//
}elseif($_REQUEST['action'] == 'editq'){
     $qid = $_GET['qid'];
     $tid = $_GET['tid'];
$findq = mysql_fetch_array(mysql_query("select * from questions where id='$qid'"));
 echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a><BR>";

  if($findq[type] == 'MC'){
?><form action="managetests.php?action=editqnext&qid=<?php print "$qid"; ?>&tid=<?php print "$tid"; ?>" method="post">
<TABLE width="465" class="sap"><TR><TD width="100">Question: </TD><TD width="365"><input type="text" id="question" name="question" size="50" value="<?php print "$findq[question]"; ?>"></TD></TR>
<TR><TD>Category: </TD><TD><select id="questcate" name="questcate"><? $concur = mysql_fetch_array(mysql_query("select * from categories where id='$findq[cateid]'"));
                       echo "<option value='$findq[cateid]' selected='selected'>$concur[category]</option>";
                     $furr = mysql_query("select * from categories where testid='$tid'");
                        while($food = mysql_fetch_array($furr)){
                           echo "<option value='$food[id]'>$food[category]</option>";
                        }
?> </select></TD></TR><TR><TD>Choice A: </TD><TD><input type="text" id="choicea" name="choicea" value="<?php print "$findq[choicea]"; ?>"> Weight <select id="aweight" name="aweight"><?php echo "<option value='$findq[aweight]' selected='selected'>$findq[aweight]</option>"; ?><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>
<TR><TD>Choice B: </TD><TD><input type="text" id="choiceb" name="choiceb" value="<?php print "$findq[choiceb]"; ?>"> Weight <select id="bweight" name="bweight"><?php echo "<option value='$findq[bweight]' selected='selected'>$findq[bweight]</option>"; ?><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>
<TR><TD>Choice C: </TD><TD><input type="text" id="choicec" name="choicec" value="<?php print "$findq[choicec]"; ?>"> Weight <select id="cweight" name="cweight"><?php echo "<option value='$findq[cweight]' selected='selected'>$findq[cweight]</option>"; ?><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>
<TR><TD>Choice D: </TD><TD><input type="text" id="choiced" name="choiced" value="<?php print "$findq[choiced]"; ?>"> Weight <select id="dweight" name="dweight"><?php echo "<option value='$findq[dweight]' selected='selected'>$findq[dweight]</option>"; ?><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>
<tr><TD></TD><TD><input type="submit" id="editqsub" name="editqsub" value="Edit"></TD></TR>
</TABLE></FORM>
<?php
  }elseif($findq[type] == 'Text'){
?><form action="managetests.php?action=editqnext&qid=<?php print "$qid"; ?>&tid=<?php print "$tid"; ?>" method="post">
<TABLE width="465" class="sap"><TR><TD width="100">Question: </TD><TD width="365"><input type="text" id="question" name="question" size="50" value="<?php print "$findq[question]"; ?>"></TD></TR>
<TR><TD>Category: </TD><TD><select id="questcate" name="questcate"><? $concur = mysql_fetch_array(mysql_query("select * from categories where id='$findq[cateid]'"));
                       echo "<option value='$findq[cateid]' selected='selected'>$concur[category]</option>";
                     $furr = mysql_query("select * from categories where testid='$tid'");
                        while($food = mysql_fetch_array($furr)){
                           echo "<option value='$food[id]'>$food[category]</option>";
                        }
?> </select></TD></TR><TR><TD>Answer: </TD><TD><input type="text" id="textanswer" name="textanswer" value="<?php print "$findq[textanswer]"; ?>"></TD></TR>
<tr><TD></TD><TD><input type="submit" id="edittsub" name="edittsub" value="Edit"></TD></TR>
</TABLE></FORM>
<?php
  }    
}elseif($_REQUEST['action'] == 'editqnext'){
     $qid = $_GET['qid'];
     $tid = $_GET['tid'];
         $findq = mysql_fetch_array(mysql_query("select * from questions where id='$qid'"));
echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a><BR>";

     $question = $_POST['question'];
     $questcate = $_POST['questcate'];
mysql_query("update questions set question='$question' where id='$qid'");
mysql_query("update questions set cateid='$questcate' where id='$qid'");
   if($findq[type] == 'MC'){
               $choicea = $_POST['choicea'];
               $choiceb = $_POST['choiceb'];
               $choicec = $_POST['choicec'];
               $choiced = $_POST['choiced'];
               $aweight = $_POST['aweight'];
               $bweight = $_POST['bweight'];
               $cweight = $_POST['cweight'];
               $dweight = $_POST['dweight'];
               //$correctchoice = $_POST['correctchoice'];
mysql_query("update questions set aweight='$aweight' where id='$qid'");
mysql_query("update questions set bweight='$bweight' where id='$qid'");
mysql_query("update questions set cweight='$cweight' where id='$qid'");
mysql_query("update questions set dweight='$dweight' where id='$qid'");
mysql_query("update questions set choicea='$choicea' where id='$qid'");
mysql_query("update questions set choiceb='$choiceb' where id='$qid'");
mysql_query("update questions set choicec='$choicec' where id='$qid'");
mysql_query("update questions set choiced='$choiced' where id='$qid'");
//mysql_query("update questions set correctchoice='$correctchoice' where id='$qid'");
   }elseif($findq[type] == 'Text'){
               $textanswer = $_POST['textanswer'];
mysql_query("update questions set textanswer='$textanswer' where id='$qid'");
   }
print "<BR><BR>You have edited the question. <a href=managetests.php?action=qmanager&tid=$tid>Go back.</a>";
//
// END EDIT QUESTIONS, START INVITING USERS TO TAKE TESTS (WITH EMAIL)
//
}elseif($_REQUEST['action'] == 'inviteusers'){
     $tid = $_GET['tid'];
         $findt = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a><BR><BR>Select Users to Take <B>$findt[testname]</B>:";
     $ferrari = mysql_query("select * from members where id!='1' and acctype='User' and createdbyid='$stat[id]'");
   echo "<TABLE class='sap' width='550'><TR><TD width='100'><B>First Name</B></TD><TD width='100'><B>Last Name</B></TD><TD width='150'><B>Company</B></TD><td width='200'><B>Actions</B></TD></TR>";
$i = 0;
while($fer = mysql_fetch_array($ferrari)){
       $seeif = mysql_num_rows(mysql_query("select * from results where testid='$tid' and memid='$fer[id]'"));
 $nameex = explode(" ", $fer[fullname]);
   $firstn = $nameex[0];
   $lastn = $nameex[1];
    echo "<TR><TD>$firstn</TD><TD>$lastn</TD><TD>$fer[company]</TD><TD id=row$fer[id]>"; if($seeif > 0){ print "An email was sent & test locked."; }else{ echo "<input type=checkbox class=$tid id=rose name=row$fer[id]> Send email to take test."; } echo "</TD></TR>";
$i++;
}
   echo "</TABLE>";
//
// TEST RESULTS
//
}elseif($_REQUEST['action'] == 'testresults'){
   $tid = $_GET['tid'];
echo "<a href=members.php>Members Home</a> | <a href=managetests.php?action=qmanager&tid=$tid>Back</a> | <a href=manageusers.php>Manage Users</a><BR>";
$tech = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
if($tech[logo]){ echo "<img src='images/$tech[logo]' style='max-height:100px;'><BR>"; }

        include("libchart/libchart/classes/libchart.php");
	
	$chart = new HorizontalBarChart(450, 150);

	$dataSet = new XYDataSet();

   $finders = mysql_query("select * from results where testid='$tid' order by memid");
    echo "<TABLE width='650' class='sap'><TR><TD><B>Member</B></TD><TD><B>Question</B></TD><TD><B>Category</B></TD><TD><B>Answered</B></TD><TD><B>Weight</B></TD></TR>";
$totalweight = "0";
$yourweight = "0";
$xer = "0";
     while($fou = mysql_fetch_array($finders)){
         $memmax = mysql_num_rows(mysql_query("select * from results where testid='$tid' and memid='$fou[memid]'"));
       $mecka = mysql_fetch_array(mysql_query("select * from members where id='$fou[memid]'"));
       $qqq = mysql_fetch_array(mysql_query("select * from questions where id='$fou[questionid]'"));
       $cater = mysql_fetch_array(mysql_query("select * from categories where id='$qqq[cateid]'"));
if($fou[answered] == $qqq[choicea]){
    $letter = "(A)";
    $weight = $qqq[aweight];
    $yourweight += $weight;
}elseif($fou[answered] == $qqq[choiceb]){
    $letter = "(B)";
    $weight = $qqq[bweight];
    $yourweight += $weight;
}elseif($fou[answered] == $qqq[choicec]){
    $letter = "(C)";
    $weight = $qqq[cweight];
    $yourweight += $weight;
}elseif($fou[answered] == $qqq[choiced]){
    $letter = "(D)";
    $weight = $qqq[dweight];
    $yourweight += $weight;
}else{
    $letter = "";
    $weight = "-"; 
}
$maxq = mysql_fetch_array(mysql_query("SELECT GREATEST(aweight, bweight, cweight, dweight) FROM questions where id='$fou[questionid]'"));
$maxfind = $maxq['GREATEST(aweight, bweight, cweight, dweight)'];
$totalweight += $maxfind;
         echo "<TR><TD>$mecka[fullname]</TD><TD>$qqq[question]</TD><TD>$cater[category]</TD><TD>$fou[answered] $letter</TD><TD>$weight</TD></TR>";
           $xer += 1;
         if($xer == $memmax){ $dataSet->addPoint(new Point("$mecka[fullname] Score", "$yourweight")); }
     }
    echo "</table><BR>";

        $dataSet->addPoint(new Point("Max Score", "$totalweight"));
	$chart->setDataSet($dataSet);

	$chart->getPlot()->setGraphPadding(new Padding(0, 30, 20, 120));
	$chart->setTitle("Score by Weight");
	$chart->render("results/demo$tid.png");
      echo "<img alt='Horizontal bars chart'  src='results/demo$tid.png' style='border: 1px solid gray;'/><BR><BR>";
//
// END
//

}

include("footer.php"); ?>