<?php
require_once("config.php");
checkuser($con);
$email = '';
$password = '';
$firstname = '';
$lastname = '';
$gender = '';
$company = '';
$division = '';
$team = '';
$education = '';
$relationship = '';
$actype = '';
if (isset($_POST['updateuser'])) {
    @extract($_POST);
    profile($con, $_POST);
}

$user = mysqli_fetch_array(mysqli_query($con, "select * from users where uid=" . $_SESSION['login']), MYSQLI_ASSOC);

//almacenamos en variables los parametros.
$birthyear = $user["birthday"];
$email = $user["email"];
$password = $user["password"];
$firstname = $user["firstname"];
$lastname = $user["lastname"];
$company = $user["company"];
$division = $user["division"];
$team = $user["team"];
$education = $user["education"];
$uid = $user["uid"];

?>
<?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
                <?php if (trim($_SESSION['actype']) == 'User') { ?>
            <tr>
                <td align="center" valign="middle"><h1>My Profile</h1></td>
                <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'] . ' ' . $user['lastname']; ?>, <a href=logout.php>Logout</a></td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle">
    <?php
    echo '<a href="managetest.php">Home</a> | <a href=profile.php>My Profile</a>';
    ?>
                </td>
            </tr>
                <?php } else { ?>
            <tr>
                <td align="center" valign="middle"><h1>My Profile</h1></td>
                <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'] . ' ' . $user['lastname'] . ', ' . $user['actype']; ?>, <a href=logout.php>Logout</a></td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle">
        <?php
        if (isset($_REQUEST['adduser']) || isset($_REQUEST['edituser']))
            echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="manageusers.php">Back</a>';
        else
            echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="manageusers.php?adduser">Add user</a>';
        ?>
                </td>
            </tr>
<?php } ?>
    </table>
<?php
//$edit = mysqli_fetch_array(mysqli_query($con, "select * from users where `uid`='" . $user['uid'] . "'"), MYSQLI_ASSOC);
//@extract($edit);

?> 
    <form method="post" action="" id="myForm">
        <input type="hidden" value="<?php echo $uid; ?>" id='uid' name='uid'>
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr><td align="right" valign="middle">Email :</td><td align="left" valign="middle"><input type="text" id="email" name="email" value="<?php echo $email; ?>"></td></tr>
            <tr><td align="right" valign="middle">First Name :</td><td align="left" valign="middle"><input type="text" class="validate[required]" id="firstname" name="firstname" value="<?php echo $firstname; ?>"></td></tr>
            <tr><td align="right" valign="middle">Last Name :</td><td align="left" valign="middle"><input type="text" class="validate[required]" id="lastname" name="lastname" value="<?php echo $lastname; ?>"></td></tr>
            <tr><td align="right" valign="middle">Password :</td><td align="left" valign="middle"><input type="password" class="validate[required,minSize[3]]" id="password" name="password" value="<?php echo $password; ?>"></td></tr>
            <tr><td align="right" valign="middle">Confirm Password :</td><td align="left" valign="middle"><input type="password" class="validate[required,equals[password]]" id="cpassword" name="cpassword" value="<?php echo $password; ?>"></td></tr>
            <tr><td align="right" valign="middle">Gender :</td><td align="left" valign="middle"><select id="gender" name="gender"><option value="Male" <?php if ($gender == 'Male') echo "selected='selected'"; ?>>Male</option><option value="Female" <?php if ($gender == 'Female') echo "selected='selected'"; ?>>Female</option></select></td></tr>
            <tr><td align="right" valign="middle">Company :</td><td align="left" valign="middle"><input type="text" id="company" name="company" value="<?php echo $company; ?>"></td></tr>
            <tr><td align="right" valign="middle">Division :</td><td align="left" valign="middle"><input type="text" id="division" name="division" value="<?php echo $division; ?>"></td></tr>
            <tr><td align="right" valign="middle">Team :</td><td align="left" valign="middle"><input type="text" id="team" name="team" value="<?php echo $team; ?>"></td></tr>
            <tr><td align="right" valign="middle">Education :</td><td align="left" valign="middle"><input type="text" id="education" name="education" value="<?php echo $education; ?>"></td></tr>                
            <tr><td align="right" valign="middle">Account Type :</td><td align="left" valign="middle"><?php echo $actype; ?></td></tr>                
            <tr><td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="updateuser" value="Update"></td></tr>
        </table>
    </form>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>