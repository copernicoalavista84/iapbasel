<?php include("header.php"); ?>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
    $("#radioans").live('click', function(){
         var ans = $(this).val();
         var quest = $(this).attr('class').replace('questid', '');
         var memid = $("#memid").val();
       $.post("send.php", { ans: ans, quest: quest, memid: memid },
         function() {
             $("#next").removeAttr('disabled');
          });
        return false;
    });

    $("#textans").live('change', function(){
        var ans = $(this).val();
         var quest = $(this).attr('class').replace('questid', '');
         var memid = $("#memid").val();
$("#next").removeAttr('disabled');
       $.post("send.php", { ans: ans, quest: quest, memid: memid },
         function() {
          });
        return false;
    });

    $("#next").live('click', function(){
        var testid = $(this).attr('class').replace('testid', '');
        window.location.href="test.php?tid="+testid;
    });
</script>
<?
$tid = $_GET['tid'];
   $tech = mysql_fetch_array(mysql_query("select * from tests where id='$tid'"));
    $perchnum = mysql_num_rows(mysql_query("select * from results where testid='$tid' and memid='$stat[id]' and answered!='' order by RAND()"));
    $outof = mysql_num_rows(mysql_query("select * from results where testid='$tid' and memid='$stat[id]' order by RAND()"));

$perch = mysql_fetch_array(mysql_query("select * from results where testid='$tid' and memid='$stat[id]' and answered='' order by RAND()"));
$questperch = mysql_fetch_array(mysql_query("select * from questions where id='$perch[questionid]'"));
echo "<div style='border-bottom:1px solid #ccc;width:99%;padding:5px;'>"; if($tech[logo]){ echo "<img src='images/$tech[logo]' style='max-height:100px;'><BR>"; } echo "Taking $tech[testname], $perchnum of $outof questions completed.</div>";
    
echo "<div style='padding:5px;'>";
   if($perchnum == $outof){
    print "You are done with the test! <a href=members.php>Members Area</a> | <a href=logout.php>Logout</a>";
    mysql_query("update tests set completed=completed+'1' where id='$tid'");
    include("footer.php");
    exit;
   }
echo "<B>$questperch[question]</B><BR>";
if($questperch[type] == 'MC'){
     echo "<table><TR><TD>$questperch[choicea]</TD><TD width='10'></TD><TD><input type='radio' id='radioans' name='radioans' class='questid$questperch[id]' value='$questperch[choicea]'></TD></TR>
<TR><TD>$questperch[choiceb]</TD><TD width='10'></TD><TD><input type='radio' id='radioans' name='radioans' class='questid$questperch[id]' value='$questperch[choiceb]'></TD></TR>
<TR><TD>$questperch[choicec]</TD><TD width='10'></TD><TD><input type='radio' id='radioans' name='radioans' class='questid$questperch[id]' value='$questperch[choicec]'></TD></TR>
<TR><TD>$questperch[choiced]</TD><TD width='10'></TD><TD><input type='radio' id='radioans' name='radioans' class='questid$questperch[id]' value='$questperch[choiced]'></TD></TR></table>";
}elseif($questperch[type] == 'Text'){
    echo "<input type='text' id='textans' name='textans' class='questid$questperch[id]'>";
}
echo "<input type='hidden' id='memid' name='memid' value='$stat[id]'><button id='next' class='testid$tid' disabled='disabled'>Next Question</button></div>";

include("footer.php"); ?>