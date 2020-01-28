<?php 
require_once("config.php");
checklogin();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
?>
<?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        	<td align="left" valign="middle"><h1>Invite Users</h1></td>
            <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'].' '.$user['lastname'].', '.$user['actype']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
        <tr>
        	<td align="center" colspan="2" valign="middle">
       		<?php 
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="questions.php?test='.$test['key'].'">Back</a>';
			?>
            </td>
        </tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr>
        	<td align="left"  colspan="2" style="padding:5px 0;"><strong>Test :</strong> <?php echo $test['testname']; ?></td>
        </tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
    </table>        
    <?php 
         $users = mysql_query("select * from users where actype='User' and createby='$user[uid]'");
    $uc = mysql_num_rows($users);
    ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <?php
       echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>First Name</B></th><th align='left' valign='middle'>Last Name</th><th align='left' valign='middle'>Company</th><th align='left' valign='middle'>Position</th><th align='left' valign='middle'>Actions</td></tr>";
        if($uc>0){
			$i = 1;
    while($fer = mysql_fetch_array($users)){
		$ts = mysql_fetch_array(mysql_query("select * from testassign where `uid`='$fer[uid]' AND `tid`='$test[tid]'"));
		if(empty($ts))
        	echo "<tr><td align='center' valign='middle'>$i</td><td>$fer[firstname]</TD><TD>$fer[lastname]</TD><TD>$fer[company]</TD><TD>$fer[relationship]</TD><TD class='emailes'><input type=checkbox class='invite' id='invite$fer[uid]' name=row$fer[uid] value='$fer[uid]'> Send email to take test.</TD></TR>";		
		else{
			if($ts['process']=='Completed')
        		echo "<tr><td align='center' valign='middle'>$i</td><td>$fer[firstname]</TD><TD>$fer[lastname]</TD><TD>$fer[company]</TD><TD>$fer[relationship]</TD><TD class='emailes'>An email was sent & Completed.</TD></TR>";
			else
        		echo "<tr><td align='center' valign='middle'>$i</td><td>$fer[firstname]</TD><TD>$fer[lastname]</TD><TD>$fer[company]</TD><TD>$fer[relationship]</TD><TD class='emailes'>An email was sent & <input type=checkbox class='invite' id='invite$fer[uid]' name=row$fer[uid] value='$fer[uid]'>Resend email.</TD></TR>";
		}

		$i++;
    }}
      else echo '<tr><td colspan="6" align="center" valign="middle">There is no users avilable in the account</td></tr>';      
      ?>
      <input type="hidden" id="qid" value="<?php echo $test['tid']; ?>" />
    </table>
</div>
<div class="contentbotbg"></div>

<script type="text/javascript">
   $(".invite").live('click', function(){
	var tid = $('#qid').val();
	var uid = $(this).val();
$.post("send.php", { testid: tid, memid: uid },
       function() {
		   $('#invite'+uid).parents('tr').find('td.emailes').html("An email was sent & test unlocked.");
        });
      return false;

   });
</script>
<?php require_once('footer.php'); ?>