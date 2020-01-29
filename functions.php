<?php

/*
 * Random key generate for Registration
 * @param mixed What page to login
 * @access public
 */

function str_rand($length = 8, $output = 'alphanum') {
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
function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

//SETFLASH
function setflash($msg) {
    $_SESSION['FLASH'] = $msg;
}

//CHECKFLASH
function findFlash() {
    $message = @$_SESSION['FLASH'];
    return $message;
}

//GETFLASH
function getFlash() {
    $message = $_SESSION['FLASH'];
    unset($_SESSION['FLASH']);
    return $message;
}

//Checking for already login
function checklogin($con) {
    if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {

        $check = mysqli_fetch_array(mysqli_query($con, "select * from users where email='" . $_COOKIE['email'] . "' and status='Active'"), MYSQLI_ASSOC);

        if (!empty($check)) {
            if ($check['password'] == $_COOKIE['password']) {
                $_SESSION['email'] = $_COOKIE['email'];
                $_SESSION['password'] = $_COOKIE['password'];
            } else
                header("location: login.php");
        }
    }
    if (!isset($_SESSION['email']) && !isset($_SESSION['password']))
        header("location: login.php");
    if (isset($_SESSION['actype'])) {
        if (trim($_SESSION['actype']) == 'User') {
            setflash("<div class='error msg'>Account suspended.</div>,Sorry. Your don't have permission to view that page. Please contact your site admin.");
            header("location: managetest.php");
        }
    }
}

//Checking for already login
function checkuser($con) {
    if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        $check = mysqli_fetch_array(mysqli_query($con, "select * from users where email='" . $_COOKIE['email'] . "' and status='Active'"), MYSQLI_ASSOC);
        if (!empty($check)) {
            if ($check['password'] == $_COOKIE['password']) {
                $_SESSION['email'] = $_COOKIE['email'];
                $_SESSION['password'] = $_COOKIE['password'];
            } else
                header("location: login.php");
        }
    }
    if (!isset($_SESSION['email']) && !isset($_SESSION['password']))
        header("location: login.php");
}

//Checking for login
function login($val, $con) {
    $email = $val['email'];
    $password = $val['password'];

    if (isset($email) && isset($password)) {

        $sql = "select * from users where email='$email' and password='$password' and status='Active'";
        $result = mysqli_query($con, $sql) or die("Error al hacer la consulta.");
        $check = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if (!empty($check)) {
            if ($check['password'] == $password) {
                if ($check['password'] == $password) {
                    $_SESSION['login'] = $check['uid'];
                    $_SESSION['email'] = $check['email'];
                    $_SESSION['firstname'] = $check['firstname'];
                    $_SESSION['lastname'] = $check['lastname'];
                    $_SESSION['actype'] = $check['actype'];
                    if ($check['actype'] == 'User')
                        header("location: managetest.php");
                    else
                        header("location: index.php");
                } else
                    setflash("<div class='error msg'>Account suspended.</div>,Sorry. Your account has been suspended by site admin.");
            } else
                setflash("<div class='error msg'>Invalid Password.</div>,You entered an incorrect password. Please try again.");
        } else
            setflash("<div class='error msg'>Invalid Email id.</div>,You are enter incorrect email address for the forgot password. So please try again.");
    }
}

function profile($con, $val) {

    //asiganmos a variables.
    $email = $val["email"];
    $uid = $val["uid"];

    @extract($val);

    if (empty($val))
    //obtenemos los datos del perfil de usuario.
        $val = mysqli_fetch_array(mysqli_query($con, "select * from users where email='$email' and uid=$uid"), MYSQLI_ASSOC);


    if (!empty($val)) {

        //almacenamos en variables los parametros.
        $birthyear = $val["birthday"];
        $email = $val["email"];
        $password = $val["password"];
        $firstname = $val["firstname"];
        $lastname = $val["lastname"];
        $company = $val["company"];
        $division = $val["division"];
        $team = $val["team"];
        $education = $val["education"];
        $uid = $val["uid"];

        //asignamos uid en una variable de sesion.
        $_SESSION["login"] = $uid;

        $sql = "UPDATE users SET email='" . $email . "' ,password='" . $password . "' ,firstname='" . $firstname . "' ,lastname='" . $lastname . "' ,gender='$gender' ,company='" . $company . "' ,division='" . $division . "' ,team='" . $team . "' ,education='" . $education . "' WHERE uid=$uid";

        $res = mysqli_query($con, $sql);
        setflash("<div class='success msg'>Successfully updated</div>,Your profile has been successfully updated");
        header("location: profile.php");

        exit;
    } else
        setflash("<div class='error msg'>Already registered.</div>,Sorry this email is already taken by somebody. So please try again with another name.");
}

function adduser($con, $val) {
    @extract($val);
    $check = mysqli_fetch_array(mysqli_query($con, "select * from users where email='$email' and status='Active'"), MYSQLI_ASSOC);
    if (empty($check)) {
        $key = str_rand(15);
        if ($actype == 'Psychologist')
            $createby = $_SESSION['login'];
        mysqli_query($con, "INSERT INTO `users` (`birthyear` ,`email` ,`password` ,`firstname` ,`lastname` ,`gender` ,`company` ,`division` ,`team` ,`education` ,`relationship` ,`actype` ,`key` ,`createby`)VALUES ('" . addslashes(utf8_decode($birthyear)) . "','" . addslashes(utf8_decode($email)) . "','" . addslashes(utf8_decode($password)) . "','" . addslashes(utf8_decode($firstname)) . "','" . addslashes(utf8_decode($lastname)) . "','$gender','" . addslashes(utf8_decode($company)) . "','" . addslashes(utf8_decode($division)) . "','" . addslashes(utf8_decode($team)) . "','" . addslashes(utf8_decode($education)) . "','" . addslashes(utf8_decode($relationship)) . "','$actype','$key','$createby')");
        setflash("<div class='success msg'>Successfully created</div>,Your member has been added in your management portal");
        $uid = mysqli_insert_id();
        //sendmail(1,$uid);
        header("location: manageusers.php");
        exit;
    } else
        setflash("<div class='error msg'>Already registered.</div>,Sorry this email is already taken by somebody. So please try again with another name.");
}

function edituser($con, $val) {
    @extract($val);
    $check = mysqli_fetch_array(mysqli_query($con, "select * from users where email='$email' and uid!=$uid"), MYSQLI_ASSOC);
    if (empty($check)) {
        if ($actype == 'Psychologist')
            $createby = $_SESSION['login'];
        mysqli_query($con, "UPDATE `users` SET `birthyear`='" . addslashes($birthyear) . "' ,`email`='" . addslashes(utf8_decode($email)) . "' ,`password`='" . addslashes(utf8_decode($password)) . "' ,`firstname`='" . addslashes(utf8_decode($firstname)) . "' ,`lastname`='" . addslashes(utf8_decode($lastname)) . "' ,`gender`='$gender' ,`company`='" . addslashes(utf8_decode($company)) . "' ,`division`='" . addslashes(utf8_decode($division)) . "' ,`team`='" . addslashes(utf8_decode($team)) . "' ,`education`='" . addslashes(utf8_decode($education)) . "' ,`relationship`='" . addslashes(utf8_decode($relationship)) . "' ,`actype`='$actype' ,`createby`='$createby' WHERE `users`.`uid` =$uid");
        setflash("<div class='success msg'>Successfully updated</div>,Your member has been updated in your management portal");
        sendmail(2, $uid);
        header("location: manageusers.php");
        exit;
    } else
        setflash("<div class='error msg'>Already registered.</div>,Sorry this email is already taken by somebody. So please try again with another name.");
}

function sendmail($con, $campaign, $uid) {
    $list = mysqli_fetch_array(mysqli_query($con, "select * from campaigns where camid='$campaign'") . MYSQLI_ASSOC);
    $options = explode(",", $list['options']);
    $user = mysqli_fetch_array(mysqli_query($con, "select * from users where uid=$uid"), MYSQLI_ASSOC);
    $values = array('<a href="http://' . $_SERVER['HTTP_HOST'] . '/login.php">click here</a>', $user['firstname'] . ' ' . $user['lastname'], $user['email'], $user['password'], $user['email']);
    $from = str_replace($options, $values, $list['from']);
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: noreply@iapbasel.com\r\n";
    $message = '<pre style="font-family:\'Trebuchet MS\',Arial,Sans-Serif">' . str_replace($options, $values, $list['message']) . '</pre>';
    $to = str_replace($options, $values, $user['email']);
    $subject = str_replace($options, $values, $list['subject']);
    mail($to, $subject, $message, $headers);
}

?>
