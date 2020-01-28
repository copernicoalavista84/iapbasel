<?php 
require_once("config.php");
checklogin();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
$assign = mysql_num_rows(mysql_query("select * from testassign where `tid`='$test[tid]'"));
if(isset($_POST['addcate'])){
	@extract($_POST);
	$key = str_rand(15);
	mysql_query("INSERT INTO `categories` (`uid` ,`tid` ,`category` ,`key`)VALUES ('$uid', '$tid', '".addslashes($category)."', '$key')");
	setflash("<div class='success msg'>Successfully created</div>,Your new category has been successfully created");
	header("location: questions.php?test=".$test['key']);
	exit;
}
if(isset($_POST['savepos'])){
	foreach($_POST[data][qus] as $value){		
		mysql_query("UPDATE `questions` SET `pos`=".$value['pos']." where `qid`=$value[qid]");
	}
	setflash("<div class='success msg'>Successfully changed</div>,Your question order has been successfully changed");
	header("location: questions.php?test=".$test['key']);
	exit;
}
if(isset($_POST['updatecate'])){
	$del=mysql_fetch_array(mysql_query("select * from categories where `key`='".$_REQUEST['editcate']."'"));
	@extract($_POST);
	mysql_query("UPDATE `categories` SET `category`='".addslashes($category)."' where `cid`=$del[cid]");
	setflash("<div class='success msg'>Successfully updated</div>,Your category has been successfully updated");
	header("location: questions.php?test=".$test['key']);
	exit;
}
if(isset($_REQUEST['delete'])){	
	$del=mysql_fetch_array(mysql_query("select * from categories where `key`='".$_REQUEST['delete']."'"));
	@extract($del);
	mysql_query("delete from categories where `cid`='".$cid."'");
	mysql_query("delete from questions where `cid`='".$cid."'");
	$max=mysql_query("select * from questions where `tid`='$test[tid]' ORDER BY pos");
	$x = 1;
	while($qus = mysql_fetch_array($max)){
		mysql_query("UPDATE `questions` SET `pos`=".$x." where `qid`=$qus[qid]");
		$x++;
	}
	setflash("<div class='success msg'>Successfully deleted</div>,Your category has been deleted in your management portal");
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
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="managetests.php">Back</a>';
			?>
            </td>
        </tr>
        <tr><td align="left" valign="middle" colspan="2" style="padding:10px 0;"><strong style="font-size:16px;font-style:italic;text-decoration:underline;"><?php echo $test['testname']; ?></strong></td>        </tr>
        <tr><td align="left" valign="middle" colspan="2"><?php echo $test['instruction'];?></td></tr>
        <tr>
        	<td align="left" valign="middle" colspan="2" style="padding:10px 0;"><?php  
					$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[target]'")); if(!empty($ts)) echo "<strong>Target User :</strong> $ts[firstname] $ts[lastname]"; else echo '<strong>Target User :</strong> N/A'; ?></td>
        </tr>
    </table>
	<?php if(isset($_REQUEST['addcate'])){ ?>
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
    <input type="hidden" id="tid" value="<?php echo $test['tid']; ?>" name="tid">
    <input type="hidden" id="uid" value="<?php echo $test['uid']; ?>" name="uid">
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Category Name :</td>
                <td align="left" valign="middle"><input type="text" id="category" class="validate[required]" name="category"></td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="addcate" value="Create Category">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td>
            </tr>
        </table>
    </form>
    <?php } else if(isset($_REQUEST['editcate'])){ 	
$edit=mysql_fetch_array(mysql_query("select * from categories where `key`='".$_REQUEST['editcate']."'"));
@extract($edit);
	?> 
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
        <table cellpadding="3" cellspacing="3" border="0" align="center">
            <tr>
            	<td align="right" valign="middle">Category Name :</td>
                <td align="left" valign="middle"><input type="text" id="category" class="validate[required]" name="category" value="<?php echo $category; ?>"></td>
            </tr>
            <tr>
                <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="updatecate" value="Update Test">&nbsp;<input type="button" name="cancel" onclick="window.history.go(-1)" value="Cancel" /></td>
            </tr>
        </table>
    </form>
    <?php } else { 
    $tests = mysql_query("select * from categories where uid='$test[uid]' AND tid=".$test['tid']);
    $uc = mysql_num_rows($tests);
    ?>
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <tr>
        	<td align="left" colspan="2" valign="middle" style="border:0px;"><h1>Managing Category</h1></td>
            <td align="right" valign="middle" style="border:0px;">
            <?php if(isset($_REQUEST['addcate']) || isset($_REQUEST['editcate'])){ ?><a href="questions.php?test=<?php echo $test['key'];?>">Back</a><?php } else if($assign>0) { ?>Add Category<?php } else { ?><a href='questions.php?test=<?php echo $test['key'];?>&addcate'>Add Category</a> <?php } ?></td>
            <td rowspan="<?php echo $uc+2; ?>" align="right" valign="top" width="220" style="border:0px;">
            <a href='invites.php?test=<?php echo $test['key'];?>'>Invite Users</a><br /><br />
            <?php if($test['logo']=='') echo '<img src="images/no_preview.jpg" alt="logo" title="logo" width="200" />';
            else echo '<img src="files/'.$test['logo'].'" alt="logo" title="logo" width="200" />';?></td>
        </tr>
    <?php
		echo '<tr><th align="center" valign="middle" width="30">#</th><th align="left" valign="middle">Test Name</th><th align="left" valign="middle">Actions</th></tr>';
		if($uc>0){
			$i = 1;
			while($cate = mysql_fetch_array($tests)){
				$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[uid]'"));
				if($assign>0)
				echo "<tr><td align='center' valign='middle'>$i</td><td align='left' valign='middle'>$cate[category]</td><td align='left' valign='middle'>Edit | Delete</td></tr>";
				else
				echo "<tr><td align='center' valign='middle'>$i</td><td align='left' valign='middle'>$cate[category]</td><td align='left' valign='middle'><a href='questions.php?test=$test[key]&editcate=$cate[key]'>Edit</a> | <a class='confirdel' href='questions.php?test=$test[key]&delete=$cate[key]'>Delete</a></td></tr>";
				$i++;
			}
		}
		else echo '<tr><td colspan="3" align="center" valign="middle">There are no categories avilable for this test</td></tr>';	
    ?>
    </table>
<?php } ?><br /><br />
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        	<td align="left" valign="middle"><h1>Managing Questions</h1></td>
            <td align="right" valign="middle" style="padding-right:10px;">
            <?php if($assign>0){ ?>
            Add MC Question | Add Text Question
			<?php } else { ?>
            <a href='mcquestion.php?test=<?php echo $test['key'];?>&addqus'>Add MC Question</a> | <a href='textquestion.php?test=<?php echo $test['key'];?>&addqus'>Add Text Question</a>
            <?php } ?>
             | <a href='invites.php?test=<?php echo $test['key'];?>'>Invite Users</a></td>
        </tr>
    </table>
    <?php 
    $questions = mysql_query("select * from questions where uid='$test[uid]' AND tid=".$test['tid']." ORDER BY pos");
    $uc = mysql_num_rows($questions);
    ?>
    <form action="" method="post" name="forum">
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
    <?php
		if($assign>0)
		echo '<tr><th align="center" valign="middle" width="30">#</th><th align="left" valign="middle">Question</th><th align="left" valign="middle">Type</th><th align="left" valign="middle">Category</th><th align="left" valign="middle">Actions</th></tr>';
		else
		echo '<tr><th align="center" valign="middle" width="30"><input type="submit" name="savepos" id="savebtn" title="Save" class="savebutton" value="" /></th><th align="left" valign="middle">Question</th><th align="left" valign="middle">Type</th><th align="left" valign="middle">Category</th><th align="left" valign="middle">Actions</th></tr>';
		if($uc>0){
			$i = 1;
			while($qus = mysql_fetch_array($questions)){
				$cid = $qus['cid'];
				$cat = mysql_query("SELECT category FROM categories WHERE cid IN (".$cid.")");
				
				while($category = mysql_fetch_array($cat))
				{ 
				 	$abc[] = $category['category'];
				}
				$abc = implode(',',$abc);
				if($assign>0){
				if($qus[type]=='Text')
				echo "<tr><td align='center' valign='middle'>$qus[pos]</td><td align='left' valign='middle'>$qus[question]</td><td align='left' valign='middle'>$qus[type]</td><td align='left' valign='middle'>$cat[category]</td><td align='left' valign='middle'>Edit | Delete</td></tr>";
				else
				echo "<tr><td align='center' valign='middle'>$qus[pos]</td><td align='left' valign='middle'>$qus[question]</td><td align='left' valign='middle'>$qus[type]</td><td align='left' valign='middle'></td><td align='left' valign='middle'>Edit | Delete</td></tr>";
				}
				else{
				if($qus[type]=='Text')
				echo "<tr><td align='center' valign='middle'><input type='hidden' id='qid' name='data[qus][$i][qid]' value='$qus[qid]'><input type='text' id='pos' class='savetxt' name='data[qus][$i][pos]' value='$qus[pos]'></td><td align='left' valign='middle'>$qus[question]</td><td align='left' valign='middle'>$qus[type]</td><td align='left' valign='middle'>".$abc."</td><td align='left' valign='middle'><a href='textquestion.php?test=$test[key]&editqus=$qus[key]'>Edit</a> | <a class='confirdel' href='textquestion.php?test=$test[key]&delete=$qus[key]'>Delete</a></td></tr>";
				else
				echo "<tr><td align='center' valign='middle'><input type='hidden' id='qid' name='data[qus][$i][qid]' value='$qus[qid]'><input type='text' id='pos' class='savetxt' name='data[qus][$i][pos]' value='$qus[pos]'></td><td align='left' valign='middle'>$qus[question]</td><td align='left' valign='middle'>$qus[type]</td><td align='left' valign='middle'>".$abc."</td><td align='left' valign='middle'><a href='mcquestion.php?test=$test[key]&editqus=$qus[key]'>Edit</a> | <a class='confirdel' href='mcquestion.php?test=$test[key]&delete=$qus[key]'>Delete</a></td></tr>";
				}
				$abc = "";
				$i++;
			}
		}
		else echo '<tr><td colspan="5" align="center" valign="middle">There are no questions available for this test.</td></tr>';	
    ?>
    </table>
    </form>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>