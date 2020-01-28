<?php
/* 
* Random key generate for Registration
* @param mixed What page to login
* @access public
*/

function str_rand($length = 8, $output = 'alphanum')
{
// Possible seeds
$outputs['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
$outputs['numeric'] = '0123456789';
$outputs['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
$outputs['hexadec'] = '0123456789abcdef';

// Choose seed
if (isset($outputs[$output])) {
$output = $outputs[$output];
}

// Seed generator
list($usec, $sec) = explode(' ', microtime());
$seed = (float) $sec + ((float) $usec * 100000);
mt_srand($seed);

// Generate
$str = '';
$output_count = strlen($output);
for ($i = 0; $length > $i; $i++) {
$str .= $output{mt_rand(0, $output_count - 1)};
}

return $str;
}
//getExtension
function getExtension($str) 
{
	 $i = strrpos($str,".");
	 if (!$i) { return ""; }
	 $l = strlen($str) - $i;
	 $ext = substr($str,$i+1,$l);
	 return $ext;
}
//SETFLASH
function setflash($msg)
{	
	$_SESSION['FLASH']=$msg; 
}
//CHECKFLASH
function findFlash()
{
	$message=$_SESSION['FLASH'];	
	return $message;
} 
//GETFLASH
function getFlash()
{
	$message=$_SESSION['FLASH'];	
	unset($_SESSION['FLASH']);
	return $message;
} 
//Checking for already login
function checklogin(){
	if(isset($_COOKIE['email']) &&  isset($_COOKIE['password'])){
		$check=mysql_fetch_array(mysql_query("select * from users where email='".$_COOKIE['email']."' and status='Active'"));
		if(!empty($check)){
			if($check['password']==$_COOKIE['password'])
			{
				$_SESSION['email'] = $_COOKIE['email'];
				$_SESSION['password'] = $_COOKIE['password'];
			}
			else				
				header("location: login.php");
		}
	}
	if(!isset($_SESSION['email']) &&  !isset($_SESSION['password']))
		header("location: login.php");	
	if(isset($_SESSION['actype'])){
		if(trim($_SESSION['actype'])=='User'){
			setflash("<div class='error msg'>Account suspended.</div>,Sorry. Your don't have permission to view that page. Please contact your site admin.");
			header("location: managetest.php");
		}
	}
}
//Checking for already login
function checkuser(){
	if(isset($_COOKIE['email']) &&  isset($_COOKIE['password'])){
		$check=mysql_fetch_array(mysql_query("select * from users where email='".$_COOKIE['email']."' and status='Active'"));
		if(!empty($check)){
			if($check['password']==$_COOKIE['password'])
			{
				$_SESSION['email'] = $_COOKIE['email'];
				$_SESSION['password'] = $_COOKIE['password'];
			}
			else				
				header("location: login.php");
		}
	}
	if(!isset($_SESSION['email']) &&  !isset($_SESSION['password']))
		header("location: login.php");
}
//Checking for login
function login($val){
	$email = $val['email'];
	$password = $val['password'];
	if(isset($email) &&  isset($password)){
		$check=mysql_fetch_array(mysql_query("select * from users where email='$email' and status='Active'"));
		if(!empty($check)){
			if($check['password']==$password)
			{
				if($check['password']==$password){
					$_SESSION['login'] = $check['uid'];
					$_SESSION['email'] = $check['email'];
					$_SESSION['firstname'] = $check['firstname'];
					$_SESSION['lastname'] = $check['lastname'];
					$_SESSION['actype'] = $check['actype'];
					if($check['actype']=='User')
					header("location: managetest.php");
					else
					header("location: index.php");
				}
				else
					setflash("<div class='error msg'>Account suspended.</div>,Sorry. Your account has been suspended by site admin.");
			}
			else	
				setflash("<div class='error msg'>Invalid Password.</div>,You entered an incorrect password. Please try again.");			
		}
		else
			setflash("<div class='error msg'>Invalid Email id.</div>,You are enter incorrect email address for the forgot password. So please try again.");	
	}
}

function profile($val){
	@extract($val);
	$check=mysql_fetch_array(mysql_query("select * from users where email='$email' and uid!=$uid"));
	if(empty($check)){
		mysql_query("UPDATE `users` SET `birthyear`='".addslashes($birthyear)."' ,`email`='".addslashes($email)."' ,`password`='".addslashes($password)."' ,`firstname`='".addslashes($firstname)."' ,`lastname`='".addslashes($lastname)."' ,`gender`='$gender' ,`company`='".addslashes($company)."' ,`division`='".addslashes($division)."' ,`team`='".addslashes($team)."' ,`education`='".addslashes($education)."' WHERE `users`.`uid` =$uid");
		setflash("<div class='success msg'>Successfully updated</div>,Your profile has been successfully updated");
		header("location: profile.php");
		exit;
	}
	else	
	setflash("<div class='error msg'>Already registered.</div>,Sorry this email is already taken by somebody. So please try again with another name.");
}

function adduser($val){
	@extract($val);
	$check=mysql_fetch_array(mysql_query("select * from users where email='$email' and status='Active'"));
	if(empty($check)){
		$key = str_rand(15);
		if($actype=='Psychologist')
		$createby = $_SESSION['login'];
		mysql_query("INSERT INTO `users` (`birthyear` ,`email` ,`password` ,`firstname` ,`lastname` ,`gender` ,`company` ,`division` ,`team` ,`education` ,`relationship` ,`actype` ,`key` ,`createby`)VALUES ('".addslashes($birthyear)."','".addslashes($email)."','".addslashes($password)."','".addslashes($firstname)."','".addslashes($lastname)."','$gender','".addslashes($company)."','".addslashes($division)."','".addslashes($team)."','".addslashes($education)."','".addslashes($relationship)."','$actype','$key','$createby')");
		setflash("<div class='success msg'>Successfully created</div>,Your member has been added in your management portal");
		$uid = mysql_insert_id();
		//sendmail(1,$uid);
		header("location: manageusers.php");
		exit;
	}
	else	
	setflash("<div class='error msg'>Already registered.</div>,Sorry this email is already taken by somebody. So please try again with another name.");
}

function edituser($val){
	@extract($val);
	$check=mysql_fetch_array(mysql_query("select * from users where email='$email' and uid!=$uid"));
	if(empty($check)){		
		if($actype=='Psychologist')
		$createby = $_SESSION['login'];
		mysql_query("UPDATE `users` SET `birthyear`='".addslashes($birthyear)."' ,`email`='".addslashes($email)."' ,`password`='".addslashes($password)."' ,`firstname`='".addslashes($firstname)."' ,`lastname`='".addslashes($lastname)."' ,`gender`='$gender' ,`company`='".addslashes($company)."' ,`division`='".addslashes($division)."' ,`team`='".addslashes($team)."' ,`education`='".addslashes($education)."' ,`relationship`='".addslashes($relationship)."' ,`actype`='$actype' ,`createby`='$createby' WHERE `users`.`uid` =$uid");
		setflash("<div class='success msg'>Successfully updated</div>,Your member has been updated in your management portal");
		sendmail(2,$uid);
		header("location: manageusers.php");
		exit;
	}
	else	
	setflash("<div class='error msg'>Already registered.</div>,Sorry this email is already taken by somebody. So please try again with another name.");
}

function sendmail($campaign, $uid){
	$list=mysql_fetch_array(mysql_query("select * from campaigns where camid='$campaign'"));
	$options = explode(",",$list['options']);
	$user=mysql_fetch_array(mysql_query("select * from users where uid=$uid"));
	$values = array('<a href="http://'.$_SERVER['HTTP_HOST'].'/login.php">click here</a>',$user['firstname'].' '.$user['lastname'],$user['email'],$user['password'],$user['email']);
	$from = str_replace($options, $values, $list['from']);
	$headers  = 'MIME-Version: 1.0' . "\r\n";	
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
	$headers .= "From: noreply@iapbasel.com\r\n";
	$message = '<pre style="font-family:\'Trebuchet MS\',Arial,Sans-Serif">'.str_replace($options, $values, $list['message']).'</pre>';
	$to	= str_replace($options, $values, $user['email']);
	$subject = str_replace($options, $values, $list['subject']);
	mail($to, $subject, $message, $headers);
}
?>