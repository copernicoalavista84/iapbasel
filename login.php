<?php 
require_once("config.php");
if(isset($_SESSION['email']) &&  isset($_SESSION['password']))
	header("location: index.php");
if(isset($_POST['login'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	login($_POST,$con);
}
else{
	$email = '';
	$password = '';
}
?>
<?php require_once('header.php'); ?>
<div class="logintopbg"></div>
<div class="logincenbg">
    <form method="post" action="" id="myForm">
        <table cellpadding="5" cellspacing="5" border="0" width="100%">
            <tr>
                <td colspan="2" align="center" valign="middle"><h1>Log In Now</h1></td>
            </tr>
            <tr>
                <td align="right" valign="middle">Email :</td>
                <td align="left" valign="middle"><input type="text" id="email" class="validate[required,custom[email]]" style="width:200px;" value="<?php echo $email; ?>" name="email"></td>
            </tr>
            <tr>
                <td align="right" valign="middle">Password :</td>
                <td align="left" valign="middle"><input type="password" class="validate[required]" id="password" style="width:200px;" value="<?php echo $password; ?>" name="password"></td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle"><input type="checkbox" name="weeks" value="1"> Don't ask me to log in for 2 weeks</td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle"><span class="forgottab loginlink" style="padding-right:30px;">Can't access your account?</span>&nbsp;<input type="submit" id="loginsub" name="login" value="Log In"></td>
            </tr>
        </table>
    </form>
</div>
<div class="loginbotbg"></div>
<?php require_once('footer.php'); ?>