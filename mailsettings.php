<?php 
require_once("config.php");
checklogin();
if(isset($_POST['updatequs'])){
	$del=mysql_fetch_array(mysql_query("select * from campaigns where `camid`='".$_REQUEST['camid']."'"));
	@extract($_POST);
	mysql_query("UPDATE `campaigns` SET `subject`='".addslashes($subject)."',`from`='$from', `message`='".addslashes($message)."'  where `camid`=$del[camid]");
	setflash("<div class='success msg'>Successfully updated</div>,Your message has been successfully updated");
	header("location: mailsettings.php");
	exit;
}
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
?>
<?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        	<td align="left" valign="middle"><h1>Managing Campaigns</h1></td>
            <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'].' '.$user['lastname'].', '.$user['actype']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
        <tr>
        	<td align="center" colspan="2" valign="middle">
       		<?php 
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a>';
			?>
            </td>
        </tr>
    </table>
	<?php if(isset($_REQUEST['camid'])){ 	
$edit=mysql_fetch_array(mysql_query("select * from campaigns where `camid`='".$_REQUEST['camid']."'"));
@extract($edit);
	?> 
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Subject :</td>
                <td align="left" valign="middle"><input type="text" id="subject" style="width:500px;" class="validate[required]" value="<?php echo $subject; ?>" name="subject"></td>
            </tr>
            <tr>
            	<td align="right" valign="middle">From :</td>
                <td align="left" valign="middle"><input type="text" id="from" style="width:500px;" class="validate[required]" value="<?php echo $from; ?>" name="from"></td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Options :</td>
                <td align="left" valign="middle"><?php echo $options; ?></td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Message :</td>
                <td align="left" valign="middle"><textarea cols="70" rows="10" class="validate[required]" name="message" id="message"><?php echo $message; ?></textarea></td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="updatequs" value="Update Message">&nbsp;<input type="button" onclick="window.history.go(-1)" name="cancel" value="Cancel" /></td>
            </tr>
        </table>
    </form>
    <?php } else {  ?>
    
    <?php 
    $camps = mysql_query("select * from campaigns");
    ?>
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
    <?php
		echo '<tr><th align="center" valign="middle" width="30">#</th><th align="left" valign="middle">Campaign</th><th align="left" valign="middle">Actions</th></tr>';
			$i = 0;
			while($camp = mysql_fetch_array($camps)){
				if($i>0)
				echo "<tr><td align='center' valign='middle'>$i</td><td align='left' valign='middle'>".utf8_encode($camp[subject])."</td><td align='left' valign='middle'><a href='mailsettings.php?camid=$camp[camid]'>Edit</a></td></tr>";
				$i++;
			}
    ?>
    </table>
    <?php } ?>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>