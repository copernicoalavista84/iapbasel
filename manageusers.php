<?php
require_once("config.php");
checklogin($con);
$birthyear = '';
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
if (isset($_POST['adduser'])) {

    foreach ($_POST as $key => $val) {
        // $_POST[$key]
        ${$key} = utf8_encode($val);
        echo ${$key};
    }

    @extract($_POST);
    adduser($con, $_POST);
}
if (isset($_POST['updateuser'])) {
    @extract($_POST);
    edituser($con, $_POST);
}
if (isset($_REQUEST['delete'])) {
    $del = mysqli_fetch_array(mysqli_query($con, "select * from users where `key`='" . $_REQUEST['delete'] . "'"), MYSQLI_ASSOC);
    @extract($del);
    mysqli_query($con, "delete from users where `uid`='" . $uid . "'");
    mysqli_query($con, "delete from users where `createby`='" . $uid . "'");
    mysqli_query($con, "delete from options where `uid`='" . $uid . "'");
    mysqli_query($con, "delete from questions where `uid`='" . $uid . "'");
    mysqli_query($con, "delete from categories where `uid`='" . $uid . "'");
    mysqli_query($con, "delete from results where `uid`='" . $uid . "'");
    mysqli_query($con, "delete from tests where `uid`='" . $uid . "'");
    $tests = mysql_query("select * from testassign where `uid`='" . $uid . "'");
    while ($test = mysql_fetch_array($tests)) {
        $del = mysqli_fetch_array(mysqli_query($con, "select * from tests where `tid`='" . $test['tid'] . "'"));
        mysqli_query($con, "UPDATE `tests` SET `invites`=" . ($del['invites'] - 1) . " where `tid`=$del[tid]");
        if ($test['process'] == 'Completed')
            mysqli_query($con, "UPDATE `tests` SET `completed`=" . ($del['completed'] - 1) . " where `tid`=$del[tid]");
    }
    mysqli_query($con, "delete from testassign where `uid`='" . $uid . "'");
    setflash("<div class='success msg'>Successfully deleted</div>,Your member has been deleted in your management portal");
    header("location: manageusers.php");
    exit;
}
$user = mysqli_fetch_array(mysqli_query($con, "select * from users where uid=" . $_SESSION['login']), MYSQLI_ASSOC);
?>
                <?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
            <td align="left" valign="middle"><h1>Managing Users</h1></td>
            <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'] . ' ' . $user['lastname'] . ', ' . $user['actype']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
        <tr>
            <td align="center" colspan="2" valign="middle">
        <?php
        if (isset($_REQUEST['adduser']) || isset($_REQUEST['edituser']))
            echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="manageusers.php">Back</a>';
        else
            echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="manageusers.php?adduser">Add user</a>';
        ?>
            </td>
        </tr>
    </table>
<?php if (isset($_REQUEST['adduser'])) { ?>
        <form method="post" action="" id="myForm" accept-charset="UTF-8">
    <?php if ($user['actype'] == 'Psychologist') { ?> 
                <input type="hidden" value="<?php echo $user['uid']; ?>" id='createby' name='createby'>
    <?php } ?>
            <table cellpadding="3" cellspacing="3" border="0" align="center">
                <tr><td align="right" valign="middle">Email :</td><td align="left" valign="middle"><input type="text" id="email" name="email" value="<?php echo $email; ?>"></td></tr>
                <tr><td align="right" valign="middle">First Name :</td><td align="left" valign="middle"><input type="text" class="validate[required]" id="firstname" name="firstname" value="<?php echo utf8_encode($firstname); ?>"></td></tr>
                <tr><td align="right" valign="middle">Last Name :</td><td align="left" valign="middle"><input type="text" class="validate[required]" id="lastname" name="lastname" value="<?php echo utf8_encode($lastname); ?>"></td></tr>
                <tr><td align="right" valign="middle">Password :</td><td align="left" valign="middle"><input type="password" class="validate[required,minSize[4]]" id="password" name="password" value="<?php echo $password; ?>"></td></tr>
                <tr><td align="right" valign="middle">Confirm Password :</td><td align="left" valign="middle"><input type="password" class="validate[required,equals[password]]" id="cpassword" name="cpassword" value="<?php echo $cpassword; ?>"></td></tr>
                <tr><td align="right" valign="middle">Gender :</td><td align="left" valign="middle"><select id="gender" name="gender"><option value="Male" <?php if ($gender == 'Male') echo "selected='selected'"; ?>>Male</option><option value="Female" <?php if ($gender == 'Female') echo "selected='selected'"; ?>>Female</option></select></td></tr>
                <tr><td align="right" valign="middle">Company :</td><td align="left" valign="middle"><input type="text" id="company" name="company" value="<?php echo $company; ?>"></td></tr>
                <tr><td align="right" valign="middle">Division :</td><td align="left" valign="middle"><input type="text" id="division" name="division" value="<?php echo $division; ?>"></td></tr>
                <tr><td align="right" valign="middle">Team :</td><td align="left" valign="middle"><input type="text" id="team" name="team" value="<?php echo $team; ?>"></td></tr>
                <tr><td align="right" valign="middle">Education :</td><td align="left" valign="middle"><input type="text" id="education" name="education" value="<?php echo $education; ?>"></td></tr>
                <tr><td align="right" valign="middle">Birth Year :</td><td align="left" valign="middle"><input type="text" id="birthyear" name="birthyear" value="<?php echo $birthyear; ?>"></td></tr>
                <tr><td align="right" valign="middle">Account Type :</td><td align="left" valign="middle"><?php if ($user['actype'] == 'Admin') { ?><select id='actype' name='actype'><option value='Psychologist'  <?php if ($acctype == 'Psychologist') echo "selected='selected'"; ?>>Psychologist</option><option value='User' <?php if ($acctype == 'User') echo "selected='selected'"; ?>>User</option></select><?php } else { ?>User<input type="hidden" value="User" id='actype' name='actype'><?php } ?></td></tr>  
    <?php if ($user['actype'] == 'Admin') { ?> 
                    <tr class="userpos" style="display:none;">
                        <td align="right" valign="middle">Belongs to :</td>
                        <td align="left" valign="middle">
                            <select id="createby" name="createby">
        <?php
        $users = mysql_query("select * from users where actype='Psychologist'");
        while ($foo = mysql_fetch_array($users)) {
            if ($foo[createby] == $createby)
                $sel = "selected='selected'";
            else
                $sel = '';
            echo "<option value='$foo[uid]' $sel>$foo[firstname] $foo[lastname]</option>";
        }
        ?>
                            </select>
                        </td>
                    </tr> 
                    <tr class="userpos" style="display:none;"><td align="right" valign="middle">Position :</td><td align="left" valign="middle">
                            <select id='relationship' name='relationship'>
                                <option value='Colleague'>Colleague</option>
                                <option value='Chief'>Chief</option>
                                <option value='Employee'>Employee</option>
                                <option value='Customer'>Customer</option>
                            </select></td></tr>                 
        <?php } else { ?> 
                    <tr><td align="right" valign="middle">Position :</td><td align="left" valign="middle">
                            <select id='relationship' name='relationship'>
                                <option value='Colleague'>Colleague</option>
                                <option value='Chief'>Chief</option>
                                <option value='Employee'>Employee</option>
                                <option value='Customer'>Customer</option>
                            </select></td></tr>  
    <?php } ?>                                                  
                <tr><td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="adduser" value="Create User">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td></tr>
            </table>
        </form>
<?php
} else if (isset($_REQUEST['edituser'])) {
    $edit = mysql_fetch_array(mysql_query("select * from users where `key`='" . $_REQUEST['edituser'] . "'"));
//@extract($edit);
    ?> 
        <form method="post" action="" id="myForm" accept-charset="UTF-8">
            <input type="hidden" value="<?php echo $edit['uid']; ?>" id='uid' name='uid'>
            <input type="hidden" value="<?php echo $user['uid']; ?>" id='createby' name='createby'>
            <table cellpadding="3" cellspacing="3" border="0" align="center">
                <tr><td align="right" valign="middle">Email :</td><td align="left" valign="middle"><input type="text" id="email" name="email" value="<?php echo $edit['email']; ?>"></td></tr>
                <tr><td align="right" valign="middle">First Name :</td><td align="left" valign="middle"><input type="text" class="validate[required]" id="firstname" name="firstname" value="<?php echo utf8_encode($edit['firstname']); ?>"></td></tr>
                <tr><td align="right" valign="middle">Last Name :</td><td align="left" valign="middle"><input type="text" class="validate[required]" id="lastname" name="lastname" value="<?php echo utf8_encode($edit['lastname']); ?>"></td></tr>
                <tr><td align="right" valign="middle">Password :</td><td align="left" valign="middle"><input type="password" class="validate[required,minSize[4]]" id="password" name="password" value="<?php echo $edit['password']; ?>"></td></tr>
                <tr><td align="right" valign="middle">Confirm Password :</td><td align="left" valign="middle"><input type="password" class="validate[required,equals[password]]" id="cpassword" name="cpassword" value="<?php echo $edit['password']; ?>"></td></tr>
                <tr><td align="right" valign="middle">Gender :</td><td align="left" valign="middle"><select id="gender" name="gender"><option value="Male" <?php if ($edit['gender'] == 'Male') echo "selected='selected'"; ?>>Male</option><option value="Female" <?php if ($edit['gender'] == 'Female') echo "selected='selected'"; ?>>Female</option></select></td></tr>
                <tr><td align="right" valign="middle">Company :</td><td align="left" valign="middle"><input type="text" id="company" name="company" value="<?php echo $edit['company']; ?>"></td></tr>
                <tr><td align="right" valign="middle">Division :</td><td align="left" valign="middle"><input type="text" id="division" name="division" value="<?php echo $edit['division']; ?>"></td></tr>
                <tr><td align="right" valign="middle">Team :</td><td align="left" valign="middle"><input type="text" id="team" name="team" value="<?php echo $edit['team']; ?>"></td></tr>
                <tr><td align="right" valign="middle">Education :</td><td align="left" valign="middle"><input type="text" id="education" name="education" value="<?php echo $edit['education']; ?>"></td></tr> 
                <tr><td align="right" valign="middle">Birth Year :</td><td align="left" valign="middle"><input type="text" id="birthyear" name="birthyear" value="<?php echo $edit['birthyear']; ?>"></td></tr> 
                <tr><td align="right" valign="middle">Account Type :</td><td align="left" valign="middle"><?php if ($user['actype'] == 'Admin') { ?><select id='actype' name='actype'><option value='Psychologist'  <?php if ($edit['actype'] == 'Psychologist') echo "selected='selected'"; ?>>Psychologist</option><option value='User' <?php if ($edit['actype'] == 'User') echo "selected='selected'"; ?>>User</option></select><?php } else { ?>User<input type="hidden" value="User" id='actype' name='actype'><?php } ?></td></tr> 
    <?php if ($user['actype'] == 'Admin') { ?> 
                    <tr class="userpos" <?php if ($edit['actype'] == 'Psychologist') echo 'style="display:none;"'; ?>>
                        <td align="right" valign="middle">Belongs to :</td>
                        <td align="left" valign="middle">
                            <select id="createby" name="createby">
        <?php
        $users = mysql_query("select * from users where actype='Psychologist'");
        while ($foo = mysql_fetch_array($users)) {
            if ($foo[uid] == $edit['createby'])
                $sel = "selected='selected'";
            else
                $sel = '';
            echo "<option value='$foo[uid]' $sel>$foo[firstname] $foo[lastname]</option>";
        }
        ?>
                            </select>
                        </td>
                    </tr> 
                    <tr class="userpos" <?php if ($edit['actype'] == 'Psychologist') echo 'style="display:none;"'; ?>><td align="right" valign="middle">Position :</td><td align="left" valign="middle">
                            <select id='relationship' name='relationship'>
                                <option value='Colleague' <?php if ($edit['relationship'] == 'Colleague') echo "selected='selected'"; ?>>Colleague</option>
                                <option value='Chief'  <?php if ($edit['relationship'] == 'Chief') echo "selected='selected'"; ?>>Chief</option>
                                <option value='Employee' <?php if ($edit['relationship'] == 'Employee') echo "selected='selected'"; ?>>Employee</option>
                                <option value='Customer'  <?php if ($edit['relationship'] == 'Customer') echo "selected='selected'"; ?>>Customer</option>
                            </select></td></tr>         
            <?php } else { ?> 
                    <tr><td align="right" valign="middle">Position :</td><td align="left" valign="middle">
                            <select id='relationship' name='relationship'>
                                <option value='Colleague' <?php if ($edit['relationship'] == 'Colleague') echo "selected='selected'"; ?>>Colleague</option>
                                <option value='Chief'  <?php if ($edit['relationship'] == 'Chief') echo "selected='selected'"; ?>>Chief</option>
                                <option value='Employee' <?php if ($edit['relationship'] == 'Employee') echo "selected='selected'"; ?>>Employee</option>
                                <option value='Customer'  <?php if ($edit['relationship'] == 'Customer') echo "selected='selected'"; ?>>Customer</option>
                            </select></td></tr>  
            <?php } ?>                  
                <tr><td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="updateuser" value="Update User">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td></tr>
            </table>
        </form>
        <?php
        } else {
            if ($user['actype'] == 'Admin')
                $users = mysqli_query($con, "select * from users where actype!='Admin'");
            else
                $users = mysqli_query($con, "select * from users where actype='User' and createby='$user[uid]'");
            $uc = mysqli_num_rows($users);
            ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <?php
        if ($user['actype'] == 'Psychologist') {
            echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>First Name</B></th><th align='left' valign='middle'>Last Name</th><th align='left' valign='middle'>Company</th><th align='left' valign='middle'>Position</th><th align='left' valign='middle'>Actions</td></tr>";
            if ($uc > 0) {
                $i = 1;
                while ($fer = mysqli_fetch_array($users, MYSQLI_ASSOC)) {
                    echo "<tr><td align='center' valign='middle'>$i</td><td>" . utf8_encode($fer[firstname]) . "</TD><TD>" . utf8_encode($fer[lastname]) . "</TD><TD>" . utf8_encode($fer[company]) . "</TD><TD>" . utf8_encode($fer[relationship]) . "</TD><TD><a href='manageusers.php?edituser=$fer[key]'>Edit</a> | <a class='confirdel' href='manageusers.php?delete=$fer[key]'>Delete</a></TD></TR>";
                    $i++;
                }
            } else
                echo '<tr><td colspan="6" align="center" valign="middle">There is no users avilable in the account</td></tr>';
        }else {
            echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>Name</th><th align='left' valign='middle'>Email</th><th align='left' valign='middle'>Type</th><th align='left' valign='middle'>Belongs To</th><th align='left' valign='middle'>Actions</B></TD></TR>";
            if ($uc > 0) {
                $i = 1;
                while ($fer = mysqli_fetch_array($users, MYSQLI_ASSOC)) {
                    $belong = mysqli_fetch_array(mysqli_query($con, "select * from users where `uid`='$fer[createby]'"), MYSQLI_ASSOC);
                    echo "<TR><td align='center' valign='middle'>$i</td><TD>" . utf8_encode($fer[firstname]) . " " . utf8_encode($fer[lastname]) . "</TD><TD>$fer[email]</TD><TD>$fer[actype]</TD><TD>" . utf8_encode($belong[firstname]) . " " . utf8_encode($belong[lastname]) . "</TD><TD><a href='manageusers.php?edituser=$fer[key]'>Edit</a> | <a class='confirdel' href='manageusers.php?delete=$fer[key]'>Delete</a></TD></TR>";
                    $i++;
                }
            } else
                echo '<tr><td colspan="6" align="center" valign="middle">There is no users avilable in the account</td></tr>';
        }
        ?>
        </table>
<?php } ?>
</div>
<div class="contentbotbg"></div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#actype').live('change', function () {
            if ($(this).val() == 'User')
                $('.userpos').show();
            else
                $('.userpos').hide();
        });
    });

</script>
<?php require_once('footer.php'); ?>