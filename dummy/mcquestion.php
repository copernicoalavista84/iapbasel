<?php 
require_once("config.php");
checklogin();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
if(isset($_POST['addqus'])){
	@extract($_POST);
	$cid = implode(",",$cid);
	
	//$cid = implode(",",$cid);
	//print_r($_POST); 
	
	$key = str_rand(15);
	$pos = mysql_num_rows(mysql_query("select * from questions where `tid`='$tid'"))+1;
	mysql_query("INSERT INTO `questions` (`uid` ,`tid` ,`cid` ,`type` ,`pos` ,`question`,`answer` ,`key`)VALUES ('$uid', '$tid','$cid', '$type', '$pos','".addslashes($question)."', '".addslashes($answer)."', '$key')");
	$qid = mysql_insert_id();
	mysql_query("INSERT INTO `options` (`uid`, `tid`, `qid`, `option1`, `weight1`, `option2`, `weight2`, `option3`, `weight3`, `option4`, `weight4`, `option5`, `weight5`, `option6`, `weight6`, `option7`, `weight7`, `option8`, `weight8`, `option9`, `weight9`, `option10`, `weight10`, `option11`, `weight11`) VALUES ('$uid', '$tid','$qid','".addslashes($option1)."', '$weight1','".addslashes($option2)."','$weight2', '".addslashes($option3)."','$weight3','".addslashes($option4)."', '$weight4','".addslashes($option5)."','$weight5', '".addslashes($option6)."','$weight6','".addslashes($option7)."', '$weight7','".addslashes($option8)."','$weight8', '".addslashes($option9)."','$weight9','".addslashes($option10)."', '$weight10','".addslashes($option11)."','$weight11')");
	$max=mysql_query("select * from questions where `tid`='$test[tid]' AND `type`='MC'");
	$val = 0;
	while($qus = mysql_fetch_array($max)){
		$opt=mysql_fetch_array(mysql_query("select * from options where `qid`=$qus[qid]"));
		for($k=1; $k<12; $k++){ 
			if($opt['option'.$k]!='')
			  $var[]=$opt['weight'.$k];
		}
		mysql_query("UPDATE `questions` SET `max`=".max($var).", `option`=".count($var).", `avg`=".(array_sum($var)/count($var))." where `qid`=$qus[qid]");
		$val = $val+max($var);
		unset($var);
	}
	mysql_query("UPDATE `tests` SET `max`=$val where `tid`=$test[tid]");
	$max=mysql_query("select * from questions where `tid`='$test[tid]' ORDER BY pos");
	$x = 1;
	while($qus = mysql_fetch_array($max)){
		mysql_query("UPDATE `questions` SET `pos`=".$x." where `qid`=$qus[qid]");
		$x++;
	}
	setflash("<div class='success msg'>Successfully created</div>,Your new question has been successfully created");
	header("location: questions.php?test=".$test['key']);
	exit;
}
if(isset($_POST['copytest'])){
	@extract($_POST);
	$qus=mysql_fetch_array(mysql_query("select * from questions where `qid`='$qid'"));
	$cate=mysql_fetch_array(mysql_query("select * from categories where `cid`='$qus[cid]'"));
	$qcate=mysql_fetch_array(mysql_query("select * from categories where `tid`='$test[tid]' AND `category`='".addslashes($cate[category])."'"));
	if(empty($qcate)){
	$key = str_rand(15);
	mysql_query("INSERT INTO `categories` (`uid` ,`tid` ,`category` ,`key`)VALUES ('$qus[uid]', '$test[tid]', '".addslashes($cate[category])."', '$key')");
	$cid = mysql_insert_id();
	}
	else{
		$cid = $qus[cid];
	}	
	$key = str_rand(15);
	$pos = mysql_num_rows(mysql_query("select * from questions where `tid`='$test[tid]'"))+1;
	mysql_query("INSERT INTO `questions` (`uid` ,`tid` ,`cid` ,`type` ,`pos` ,`question`,`answer` ,`key`)VALUES ('$qus[uid]', '$test[tid]','$cid', '$qus[type]','$pos','".addslashes($qus[question])."', '".addslashes($qus[answer])."', '$key')");
	$qid = mysql_insert_id();
	$opt=mysql_fetch_array(mysql_query("select * from options where `qid`='$qus[qid]'"));
	mysql_query("INSERT INTO `options` (`uid`, `tid`, `qid`, `option1`, `weight1`, `option2`, `weight2`, `option3`, `weight3`, `option4`, `weight4`, `option5`, `weight5`, `option6`, `weight6`, `option7`, `weight7`, `option8`, `weight8`, `option9`, `weight9`, `option10`, `weight10`, `option11`, `weight11`) VALUES ('$opt[uid]', '$test[tid]','$qid','".addslashes($opt[option1])."', '$opt[weight1]', '".addslashes($opt[option2])."', '$opt[weight2]', '".addslashes($opt[option3])."', '$opt[weight3]', '".addslashes($opt[option4])."', '$opt[weight4]', '".addslashes($opt[option5])."', '$opt[weight5]', '".addslashes($opt[option6])."', '$opt[weight6]', '".addslashes($opt[option7])."', '$opt[weight7]', '".addslashes($opt[option8])."', '$opt[weight8]', '".addslashes($opt[option9])."', '$opt[weight9]', '".addslashes($opt[option10])."', '$opt[weight10]', '".addslashes($opt[option11])."', '$opt[weight11]')");
	
	$max=mysql_query("select * from questions where `tid`='$test[tid]' AND `type`='MC'");
	$val = 0;
	while($qus = mysql_fetch_array($max)){
		$opt=mysql_fetch_array(mysql_query("select * from options where `qid`=$qus[qid]"));
		for($k=1; $k<12; $k++){ 
			if($opt['option'.$k]!='')
			  $var[]=$opt['weight'.$k];
		}
		mysql_query("UPDATE `questions` SET `max`=".max($var).", `option`=".count($var).", `avg`=".(array_sum($var)/count($var))." where `qid`=$qus[qid]");
		$val += max($var);
		unset($var);
	}
	mysql_query("UPDATE `tests` SET `max`=$val where `tid`=$test[tid]");
	$max=mysql_query("select * from questions where `tid`='$test[tid]' ORDER BY pos");
	$x = 1;
	while($qus = mysql_fetch_array($max)){
		mysql_query("UPDATE `questions` SET `pos`=".$x." where `qid`=$qus[qid]");
		$x++;
	}
	setflash("<div class='success msg'>Successfully created</div>,Your new question has been successfully created");
	header("location: questions.php?test=".$test['key']);
	exit;
}
if(isset($_POST['updatequs'])){

	$del=mysql_fetch_array(mysql_query("select * from questions where `key`='".$_REQUEST['editqus']."'"));
	$opt=mysql_fetch_array(mysql_query("select * from options where `qid`=$del[qid]"));
	@extract($_POST);
	
	$cid = implode(",",$cid);
	//	print_r($_POST); die;
	mysql_query("UPDATE `questions` SET `question`='".addslashes($question)."',`answer`='".addslashes($answer)."', `cid`='$cid'  where `qid`=$del[qid]");
	mysql_query("UPDATE `options` SET `option1`='".addslashes($option1)."', `weight1`='$weight1', `option2`='".addslashes($option2)."', `weight2`='$weight2', `option3`='".addslashes($option3)."', `weight3`='$weight3', `option4`='".addslashes($option4)."', `weight4`='$weight4', `option5`='".addslashes($option5)."', `weight5`='$weight5', `option6`='".addslashes($option6)."', `weight6`='$weight6', `option7`='".addslashes($option7)."', `weight7`='$weight7', `option8`='".addslashes($option8)."', `weight8`='$weight8', `option9`='".addslashes($option9)."', `weight9`='$weight9', `option10`='".addslashes($option10)."', `weight10`='$weight10', `option11`='".addslashes($option11)."', `weight11`='$weight11' where `oid`=$opt[oid]");
	$max=mysql_query("select * from questions where `tid`='$del[tid]' AND `type`='MC'");
	$val = 0;
	while($qus = mysql_fetch_array($max)){
		$opt=mysql_fetch_array(mysql_query("select * from options where `qid`=$qus[qid]"));
		for($k=1; $k<12; $k++){ 
			if($opt['option'.$k]!='')
			  $var[]=$opt['weight'.$k];
		}
		mysql_query("UPDATE `questions` SET `max`=".max($var).", `option`=".count($var).", `avg`=".(array_sum($var)/count($var))." where `qid`=$qus[qid]");
		$val += max($var);
		unset($var);
	}
	mysql_query("UPDATE `tests` SET `max`=$val where `tid`=$del[tid]");
	$max=mysql_query("select * from questions where `tid`='$del[tid]' ORDER BY pos");
	$x = 1;
	while($qus = mysql_fetch_array($max)){
		mysql_query("UPDATE `questions` SET `pos`=".$x." where `qid`=$qus[qid]");
		$x++;
	}
	setflash("<div class='success msg'>Successfully updated</div>,Your question has been successfully updated");
	header("location: questions.php?test=".$test['key']);
	exit;
}
if(isset($_REQUEST['delete'])){	
	$del=mysql_fetch_array(mysql_query("select * from questions where `key`='".$_REQUEST['delete']."'"));
	@extract($del);
	mysql_query("delete from questions where `qid`='".$qid."'");
	mysql_query("delete from options where `qid`='".$qid."'");
	$max=mysql_query("select * from questions where `tid`='$del[tid]' AND `type`='MC'");
	$val = 0;
	while($qus = mysql_fetch_array($max)){
		$opt=mysql_fetch_array(mysql_query("select * from options where `qid`=$qus[qid]"));
		for($k=1; $k<12; $k++){ 
			if($opt['option'.$k]!='')
			  $var[]=$opt['weight'.$k];
		}
		mysql_query("UPDATE `questions` SET `max`=".max($var).", `option`=".count($var).", `avg`=".(array_sum($var)/count($var))." where `qid`=$qus[qid]");
		$val += max($var);
		unset($var);
	}
	mysql_query("UPDATE `tests` SET `max`=$val where `tid`=$del[tid]");
	$max=mysql_query("select * from questions where `tid`='$del[tid]' ORDER BY pos");
	$x = 1;
	while($qus = mysql_fetch_array($max)){
		mysql_query("UPDATE `questions` SET `pos`=".$x." where `qid`=$qus[qid]");
		$x++;
	}
	setflash("<div class='success msg'>Successfully deleted</div>,Your question has been deleted in your management portal");
	header("location: questions.php?test=".$test['key']);
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
			if(isset($_REQUEST['addqus']) || isset($_REQUEST['editqus']))
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="questions.php?test='.$test['key'].'">Back</a>';
			else			
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="managetests.php?addtest">Add test</a>';
			?>
            </td>
        </tr>
        <tr>
        	<td align="left" valign="middle"><h1>Managing MC Questions</h1></td>
            <td align="right" valign="middle" style="padding-right:10px;"><a href='mcquestion.php?test=<?php echo $test['key'];?>&addqus'>Add MC Question</a> | <a href='textquestion.php?test=<?php echo $test['key'];?>&addqus'>Add Text Question</a> | <a href='invites.php?test=<?php echo $test['key'];?>'>Invite Users</a></td>
        </tr>
    </table>
	<?php if(isset($_REQUEST['addqus'])){ 
    $tests = mysql_query("select * from questions where uid='$user[uid]' AND `tid`!='$test[tid]' AND `type`='MC'");
	if(mysql_num_rows($tests) > 0){?>
    <form action="" method="post" id="myForm1">
        <input type="hidden" value="<?php echo $user['uid']; ?>" id='createby' name='createby'>
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Copy MC Question :</td>
            	<td align="left" valign="middle">
                	<select id="qid" name="qid" style="max-width:500px;">
                    <?php while($foo = mysql_fetch_array($tests)){ 
					echo "<option value='$foo[qid]'>$foo[question]</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="center" valign="middle" colspan="2"><input type="submit" id="loginsub" name="copytest" value="Copy Question"></td>
            </tr>
            <tr><td align="center" valign="middle" colspan="2"><h1>OR Create MC Question</h1></td></tr>
        </table>
    </form>	
 	<?php } ?>
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
    <input type="hidden" id="tid" value="<?php echo $test['tid']; ?>" name="tid">
    <input type="hidden" id="uid" value="<?php echo $test['uid']; ?>" name="uid">
    <input type="hidden" id="type" value="MC" name="type">
    <input type="hidden" id="answer" name="answer">
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Category :</td>
            	<td align="left" valign="middle">
                	<select id="cid" name="cid[]" multiple>
                    <?php $tests = mysql_query("select * from categories where uid='$test[uid]' AND tid=".$test['tid']);
					while($foo = mysql_fetch_array($tests)){
					echo "<option value='$foo[cid]'>$foo[category]</option>";
					} ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Question :</td>
                <td align="left" valign="middle"><input type="text" style="width:500px;" id="question" class="validate[required]" name="question"></td>
            </tr>
            <?php for($x=1;$x<12;$x++){ ?>
            <tr>
            	<td align="right" valign="middle">Choice <?php echo $x; ?>:</td>
            	<td align="left" valign="middle">
                	<input type="text" <?php if($x<3) echo 'class="validate[required]"'; ?> style="width:300px;" id="option<?php echo $x; ?>" name="option<?php echo $x; ?>">
                	Weight :&nbsp;&nbsp;
                	<select id="weight<?php echo $x; ?>" name="weight<?php echo $x; ?>">
                    <?php 
					for($k=0; $k<11; $k++){ 
					echo "<option value='$k'>$k</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="addqus" value="Create question">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td>
            </tr>
        </table>
    </form>
    <?php } else if(isset($_REQUEST['editqus'])){ 	
$edit=mysql_fetch_array(mysql_query("select * from questions where `key`='".$_REQUEST['editqus']."'"));
@extract($edit);
$opt=mysql_fetch_array(mysql_query("select * from options where `qid`=$qid"));
	?> 
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Category :</td>
            	<td align="left" valign="middle">
                	<select id="cid" name="cid[]" multiple>
                    <?php $tests = mysql_query("select * from categories where uid='$test[uid]' AND tid=".$test['tid']);
					$cid = explode(",",$cid);
					while($foo = mysql_fetch_array($tests)){ 
						if(in_array($foo[cid],$cid)) $sel = "selected='selected'"; else $sel = '';
					echo "<option value='$foo[cid]' $sel>$foo[category]</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td align="right" valign="middle">Question :</td>
                <td align="left" valign="middle"><input type="text" id="question" style="width:500px;" class="validate[required]" value="<?php echo $question; ?>" name="question"></td>
            </tr>
            <?php for($x=1;$x<12;$x++){ ?>
            <tr>
            	<td align="right" valign="middle">Choice <?php echo $x; ?>:</td>
            	<td align="left" valign="middle">
                	<input type="text" <?php if($x<3) echo 'class="validate[required]"'; ?> style="width:300px;" id="option<?php echo $x; ?>" value="<?php echo $opt['option'.$x];?>" name="option<?php echo $x; ?>">
                	Weight :&nbsp;&nbsp;
                	<select id="weight<?php echo $x; ?>" name="weight<?php echo $x; ?>">
                    <?php 
					for($k=0; $k<11; $k++){ 
					if($opt['weight'.$x]==$k) $sel = "selected='selected'"; else $sel = '';
					echo "<option value='$k' $sel>$k</option>"; 
					} ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="updatequs" value="Update question">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td>
            </tr>
        </table>
    </form>
    <?php } ?>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>