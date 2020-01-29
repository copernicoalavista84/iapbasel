<?php 
require_once("config.php");
checklogin($con);
$user=mysqli_fetch_array(mysqli_query($con, "select * from users where uid=".$_SESSION['login']),MYSQLI_ASSOC);
?>
<?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
            <td colspan="2" align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'].' '.$user['lastname'].', '.$user['actype']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
    </table>
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
            <td colspan="2" align="center" valign="middle"><a href=manageusers.php>Manage Users</a></td>
        </tr>
        <tr>
            <td colspan="2" align="center" valign="middle"><a href=managetests.php>Manage Tests</a></td>
        </tr>
        <tr>
            <td colspan="2" align="center" valign="middle"><a href=profile.php>My Profile</a></td>
        </tr>
        <tr>
            <td colspan="2" align="center" valign="middle"></td>
        </tr>
    </table>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>