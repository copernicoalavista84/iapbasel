<?php 
require_once("config.php");
checklogin();
/*$tests=mysql_query("select * from tests");
	while($test = mysql_fetch_array($tests)){
	$max=mysql_query("select * from questions where `tid`='$test[tid]' AND `type`='MC'");
	$val = 0;
	while($qus = mysql_fetch_array($max)){
		$opt=mysql_fetch_array(mysql_query("select * from options where `qid`=$qus[qid]"));
		for($k=1; $k<12; $k++){ 
			if($opt['option'.$k]!='')
			  $var[]=$opt['weight'.$k];
		}
		mysql_query("UPDATE `questions` SET `max`=".max($var).", `score`=".array_sum($var).", `option`=".count($var).", `avg`=".(array_sum($var)/count($var))." where `qid`=$qus[qid]");
		$val += max($var);
		unset($var);
	}
	mysql_query("UPDATE `tests` SET `max`=$val where `tid`=$test[tid]");
	}*/
$email='';$password='';$firstname='';$lastname='';$gender='';$company='';$division='';$team='';$education='';$relationship='';$actype='';
if(isset($_POST['addtest'])){
	@extract($_FILES['logo']);
	if ($size && !$error) {	
		$extension = getExtension($name);
		$extension = strtolower($extension);
		$m=explode(".",$name);
		$imagename=$m[0].time().".".$extension;		
		$destination='files/'.$imagename;
		move_uploaded_file($tmp_name, $destination);
	}
	else
	$imagename = '';
	@extract($_POST);
	$key = str_rand(15);
	mysql_query("INSERT INTO `tests` (`uid` ,`testname` ,`logo` ,`target` ,`instruction`, `finish` ,`key`)VALUES ('$uid', '".addslashes($testname)."', '$imagename', '$target', '".addslashes($instruction)."', '".addslashes($finish)."', '$key')");
	setflash("<div class='success msg'>Successfully created</div>,Your new test has been successfully created");
	header("location: managetests.php");
	exit;
}
if(isset($_POST['copytest'])){
	@extract($_POST);
	$uid = $_SESSION['login'];
	$test=mysql_fetch_array(mysql_query("select * from tests where `tid`='$tid'"));
	$extension = getExtension($test['logo']);
	if(!empty($test['logo'])){		
		$extension = strtolower($extension);
		$name = strtolower(str_replace(' ','-',preg_replace('/[^a-zA-Z0-9_ -]/s', '', $testname)));
		$imagename=$name.time().".".$extension;		
		$destination='files/'.$imagename;
		copy('files/'.$test['logo'], $destination);
	}
	else
	$imagename = '';
	
	$key = str_rand(15);
	mysql_query("INSERT INTO `tests` (`uid` ,`testname` ,`logo` ,`target` ,`print` ,`instruction`, `finish` ,`max` ,`key`)VALUES ('$uid', '".addslashes($testname)."', '$imagename', '$test[target]', '$test[print]', '".addslashes($test[instruction])."', '".addslashes($test[finish])."', '$test[max]', '$key')");
	$tsid = mysql_insert_id();	
	$cates=mysql_query("select * from categories where `tid`='$tid'");
	while($cat = mysql_fetch_array($cates)){
		$key = str_rand(15);
		mysql_query("INSERT INTO `categories` (`uid` ,`tid` ,`category` ,`key`)VALUES ('$uid', '$tsid', '".addslashes($cat[category])."', '$key')");
		$tcid = mysql_insert_id();
		$questions=mysql_query("select * from questions where `tid`='$tid' and cid='".$cat[cid]."'");
		while($qus = mysql_fetch_array($questions)){		
			$key = str_rand(15);
			$pos = mysql_num_rows(mysql_query("select * from questions where `tid`='$tsid'"))+1;
			if($qus['type']=='Text'){	
				mysql_query("INSERT INTO `questions` (`uid` ,`tid` ,`cid` ,`type` ,`pos` ,`question`,`answer`,`max`,`option`,`avg`,`key`)VALUES ('$uid', '$tsid','$tcid', '$qus[type]', '$pos','".addslashes($qus[question])."', '".addslashes($qus[answer])."', '$qus[max]', '$qus[option]', '$qus[avg]', '$key')");
			}
			else{
				mysql_query("INSERT INTO `questions` (`uid` ,`tid` ,`cid` ,`type` ,`pos` ,`question`,`answer`,`max`,`option`,`avg`,`key`)VALUES ('$uid', '$tsid','$tcid', '$qus[type]', '$pos','".addslashes($qus[question])."', '".addslashes($qus[answer])."', '$qus[max]', '$qus[option]', '$qus[avg]', '$key')");
				$qid = mysql_insert_id();
				$opt=mysql_fetch_array(mysql_query("select * from options where `qid`='$qus[qid]'"));
				mysql_query("INSERT INTO `options` (`uid`, `tid`, `qid`, `option1`, `weight1`, `option2`, `weight2`, `option3`, `weight3`, `option4`, `weight4`, `option5`, `weight5`, `option6`, `weight6`, `option7`, `weight7`, `option8`, `weight8`, `option9`, `weight9`, `option10`, `weight10`, `option11`, `weight11`) VALUES ('$uid', '$tsid','$qid','".addslashes($opt[option1])."', '$opt[weight1]', '".addslashes($opt[option2])."', '$opt[weight2]', '".addslashes($opt[option3])."', '$opt[weight3]', '".addslashes($opt[option4])."', '$opt[weight4]', '".addslashes($opt[option5])."', '$opt[weight5]', '".addslashes($opt[option6])."', '$opt[weight6]', '".addslashes($opt[option7])."', '$opt[weight7]', '".addslashes($opt[option8])."', '$opt[weight8]', '".addslashes($opt[option9])."', '$opt[weight9]', '".addslashes($opt[option10])."', '$opt[weight10]', '".addslashes($opt[option11])."', '$opt[weight11]')");
			}
		}
	}
	setflash("<div class='success msg'>Successfully created</div>,Your new test has been successfully created");
	header("location: managetests.php");
	exit;
}
if(isset($_POST['updatetest'])){
	$del=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['edittest']."'"));
	@extract($_FILES['logo']);
	if ($size && !$error) {	
		unlink('files/'.$del['logo']);
		$extension = getExtension($name);
		$extension = strtolower($extension);
		$m=explode(".",$name);
		$imagename=$m[0].time().".".$extension;		
		$destination='files/'.$imagename;
		move_uploaded_file($tmp_name, $destination);
	}
	else
		$imagename = $del['logo'];
	@extract($_POST);
	mysql_query("UPDATE `tests` SET `uid`='$uid',`testname`='".addslashes($testname)."',`logo`='$imagename',`target`='$target',`print`='$print',`instruction`='".addslashes($instruction)."',`finish`='".addslashes($finish)."' where `tid`=$del[tid]");
	setflash("<div class='success msg'>Successfully updated</div>,Your test has been successfully updated");
	header("location: managetests.php");
	exit;
}
if(isset($_REQUEST['delete'])){	
	$del=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['delete']."'"));
	unlink('files/'.$del['logo']);
	@extract($del);
	mysql_query("delete from options where `tid`='".$tid."'");
	mysql_query("delete from questions where `tid`='".$tid."'");
	mysql_query("delete from results where `tid`='".$tid."'");
	mysql_query("delete from testassign where `tid`='".$tid."'");
	mysql_query("delete from categories where `tid`='".$tid."'");
	mysql_query("delete from tests where `tid`='".$tid."'");
	setflash("<div class='success msg'>Successfully deleted</div>,Your test has been deleted in your management portal");
	header("location: managetests.php");
	exit;
}
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
?>
<?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        	<td align="left" valign="middle"><h1>Managing Tests</h1></td>
            <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'].' '.$user['lastname'].', '.$user['actype']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
        <tr>
        	<td align="center" colspan="2" valign="middle">
       		<?php 
			if(isset($_REQUEST['addtest']) || isset($_REQUEST['edittest']))
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="managetests.php">Back</a>';
			else			
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="managetests.php?addtest">Add test</a>';
			?>
            </td>
        </tr>
    </table>
	<?php if(isset($_REQUEST['addtest'])){ 
    //$tests = mysql_query("select * from tests where uid='$user[uid]'");
	$tests = mysql_query("select * from tests");
	if(mysql_num_rows($tests) > 0){?>
    <form action="" method="post" id="myForm1">
        <input type="hidden" value="<?php echo $user['uid']; ?>" id='createby' name='createby'>
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Copy a Test :</td>
            	<td align="left" valign="middle">
                	<select id="tid" name="tid">
                    <?php while($foo = mysql_fetch_array($tests)){ 
					echo "<option value='$foo[tid]'>$foo[testname]</option>"; 
					} ?>
                    </select>
                </td>
            	<td align="right" valign="middle">Test Name :</td>
                <td align="left" valign="middle"><input type="text" class="validate[required]" id="testname" name="testname"></td>
                <td align="left" valign="middle"><input type="submit" id="loginsub" name="copytest" value="Copy Test"></td>
            </tr>
            <tr><td align="center" valign="middle" colspan="5"><h1>OR Create a Test</h1></td></tr>
        </table>
    </form>	
 	<?php } ?>
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
    	<?php if($user['actype'] == 'Psychologist'){ ?>
        <input type="hidden" value="<?php echo $user['uid']; ?>" id='uid' name='uid'>
        <?php } ?>
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Test Name :</td>
                <td align="left" valign="middle"><input type="text" id="testname" class="validate[required]" name="testname"></td>
            </tr>
            <?php if($user['actype'] == 'Admin'){ ?>
            <tr>
            	<td align="right" valign="middle">Psychologist :</td>
            	<td align="left" valign="middle">
                	<select id="uid" name="uid">
                    <?php $users = mysql_query("select * from users where actype='Psychologist'");
					while($foo = mysql_fetch_array($users)){ 
					echo "<option value='$foo[uid]'>$foo[firstname] $foo[lastname]</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
        	<?php } ?>
            <tr>
            	<td align="right" valign="middle">Test logo :</td>
                <td align="left" valign="middle"><input type="file" id="logo" class="validate[optional,custom[image]]" name="logo"></td>
            </tr>
            <tr>
            	<td align="right" valign="middle">&nbsp;</td>
                <td align="left" valign="middle">(You can upload using the following format .png, .jpg, .gif with the dimension of 200x200)</td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Target User :</td>
            	<td align="left" valign="middle">
                	<select id="target" name="target">
                    <?php $users = mysql_query("select * from users where actype='User'");
					while($foo = mysql_fetch_array($users)){ 
					echo "<option value='$foo[uid]'>$foo[firstname] $foo[lastname]</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Print :</td>
                <td align="left" valign="middle"><input type="checkbox" name="print" value="1" />&nbsp;User can also print this test report and details.</td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Test instructions :</td>
                <td align="left" valign="middle"><textarea name="instruction" cols="40" rows="6" id="instruction" class="validate[required]"></textarea></td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Test complete message:</td>
                <td align="left" valign="middle"><textarea name="finish" cols="40" rows="6" id="finish" class="validate[required]">Thanks for completing the test.</textarea></td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="addtest" value="Create Test">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td>
            </tr>
        </table>
    </form>
    <?php } else if(isset($_REQUEST['edittest'])){ 	
$edit=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['edittest']."'"));
@extract($edit);
	?> 
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
    	<?php if($user['actype'] == 'Psychologist'){ ?>
        <input type="hidden" value="<?php echo $user['uid']; ?>" id='uid' name='uid'>
        <?php } ?>
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Test Name :</td>
                <td align="left" valign="middle"><input type="text" id="testname" class="validate[required]" name="testname" value="<?php echo $testname; ?>"></td>
                <td rowspan="5" align="center"> <?php if($test['logo']=='') echo '<img src="images/no_preview.jpg" alt="logo" title="logo" width="200" />';
            else echo '<img src="files/'.$test['logo'].'" alt="logo" title="logo" width="200" />';?></td>
            </tr>
            <?php if($user['actype'] == 'Admin'){ ?>
            <tr>
            	<td align="right" valign="middle">Psychologist :</td>
            	<td align="left" valign="middle">
                	<select id="uid" name="uid">
                    <?php $users = mysql_query("select * from users where actype='Psychologist'");
					while($foo = mysql_fetch_array($users)){ 
						if($foo[uid]==$uid) $sel = "selected='selected'"; else $sel = '';
					echo "<option value='$foo[uid]' $sel>$foo[firstname] $foo[lastname]</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
        	<?php } ?>
            <tr>
            	<td align="right" valign="middle">Test logo :</td>
                <td align="left" valign="middle"><input type="file" id="logo" class="validate[optional,custom[image]]" name="logo"></td>
            </tr>
            <tr>
            	<td align="right" valign="middle">&nbsp;</td>
                <td align="left" valign="middle">(You can upload using the following format .png, .jpg, .gif with the dimension of 200x200)</td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Target User :</td>
            	<td align="left" valign="middle">
                	<select id="target" name="target">
                    <?php $users = mysql_query("select * from users where actype='User'");
					while($foo = mysql_fetch_array($users)){ 
						if($foo[uid]==$uid) $sel = "selected='selected'"; else $sel = '';
					echo "<option value='$foo[uid]' $sel>$foo[firstname] $foo[lastname]</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Print :</td>
                <td align="left" valign="middle"><input type="checkbox" name="print" value="1" <?php if($print==1) echo 'checked="checked"'; ?> />&nbsp;User can also print this test report and details.</td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Test instructions :</td>
                <td align="left" valign="middle"><textarea name="instruction" cols="40" rows="6" id="instruction" class="validate[required]"><?php echo utf8_encode($instruction); ?></textarea></td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Test complete message:</td>
                <td align="left" valign="middle"><textarea name="finish" cols="40" rows="6" id="finish" class="validate[required]"><?php echo utf8_encode($finish); ?></textarea></td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="updatetest" value="Update Test">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td>
            </tr>
        </table>
    </form>
    <?php } else { 
    if($user['actype'] == 'Admin')
         $tests = mysql_query("select * from tests");
    else
         $tests = mysql_query("select * from tests where uid='$user[uid]'");
    $uc = mysql_num_rows($tests);
    ?>
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
    <?php
		if($user['actype'] == 'Admin'){
			echo '<tr><th align="center" valign="middle" width="30">#</th><th align="left" valign="middle">Test Name</th><th align="left" valign="middle">Psychologist</th><th align="center" valign="middle">Completed</th><th align="center" valign="middle">Invites Sent</th><th align="left" valign="middle">Actions</th></tr>';
			if($uc>0){
				$i=1;
				while($test = mysql_fetch_array($tests)){
					$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[uid]'"));					
         			$assign = mysql_num_rows(mysql_query("select * from testassign where `tid`='$test[tid]'"));
					if($assign==0)
						$noedit = "<a href='managetests.php?edittest=$test[key]'>Edit</a>";
					else
						$noedit = "<a href='invites.php?test=$test[key]'>Invite Users</a>";
					echo "<tr><td align='center' valign='middle'>$i</td><td align='left' valign='middle'>$test[testname]</td><td align='left' valign='middle'>$ts[firstname] $ts[lastname]</td><td align='center' valign='middle'>$test[completed]</td><td align='center' valign='middle'>$test[invites]</td><td align='left' valign='middle'><a href='questions.php?test=$test[key]'>Manage</a> | <a href='results.php?test=$test[key]'>Results</a> | $noedit | <a class='confirdel' href='managetests.php?delete=$test[key]'>Delete</a></td></tr>";
					$i++;
				}
			}
			else echo '<tr><td colspan="6" align="center" valign="middle">There are no tests avilable in the account</td></tr>';
		}else{
			echo '<tr><th align="center" valign="middle" width="30">#</th><th align="left" valign="middle">Test Name</th><th align="left" valign="middle">Target User</th><th align="center" valign="middle">Completed</th><th align="center" valign="middle">Invites Sent</th><th align="left" valign="middle">Actions</th></tr>';
			if($uc>0){
				$i=1;
				while($test = mysql_fetch_array($tests)){
					$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[target]'"));
					if(!empty($ts))
						$targ = utf8_encode($ts[firstname]).' '.utf8_encode($ts[lastname]);
					else
						$targ = 'N/A';
         			$assign = mysql_num_rows(mysql_query("select * from testassign where `tid`='$test[tid]'"));
					if($assign==0)
						$noedit = "<a href='managetests.php?edittest=$test[key]'>Edit</a>";
					else
						$noedit = "<a href='invites.php?test=$test[key]'>Invite Users</a>";
					echo "<tr><td align='center' valign='middle'>$i</td><td align='left' valign='middle'>".utf8_encode($test[testname])."</td><td align='left' valign='middle'>$targ</td><td align='center' valign='middle'>$test[completed]</td><td align='center' valign='middle'>$test[invites]</td><td align='left' valign='middle'><a href='questions.php?test=$test[key]'>Manage</a> | <a href='results.php?test=$test[key]'>Results</a> | $noedit | <a class='confirdel' href='managetests.php?delete=$test[key]'>Delete</a></td></tr>";
					$i++;
				}
			}
			else echo '<tr><td colspan="6" align="center" valign="middle">There are no tests avilable in the account</td></tr>';
		}
    ?>
    </table>
<?php } ?>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>