<?php 
require_once("config.php");
checkuser();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
if(isset($_POST['answered'])){
	@extract($_POST);
	$w = explode('<>',$weight);
	$weight = $w[0];
	if(isset($w[1]))
	$answer = $w[1];
	mysql_query("INSERT INTO `results` (`uid`, `tid`, `cid`, `qid`, `answer`, `weight`) VALUES ('$uid', '$tid', '$cid', '$qid', '".addslashes($answer)."', '$weight')");
	//$res = mysql_num_rows(mysql_query("select * from results where `tid`='$test[tid]' AND `uid`=".$_SESSION['login']." ORDER by rid DESC"));
	//$qus = mysql_fetch_array(mysql_query("select * from questions where `tid`=$tid ORDER BY pos limit $res,1"));	
	$qus = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' AND `key`='".$_REQUEST['qus']."'"));
	$next = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' AND `pos`='".($qus[pos]+1)."'"));	
	if(empty($next)){
		header("location: writetest.php?test=$test[key]");
		exit;
	}	
	else{
		mysql_query("update testassign set `process`='Partialy Completed' where `uid`='$uid' AND `tid`='$tid'");
		header("location: writetest.php?test=$test[key]&qus=$next[key]");
		exit;
	}
}
if(isset($_POST['reanswered'])){
	@extract($_POST);
	$w = explode('<>',$weight);
	$weight = $w[0];
	if(isset($w[1]))
	$answer = $w[1];
	mysql_query("update `results` set `answer`='".addslashes($answer)."', `weight`='$weight' where `rid`=$rid");
	$qus = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' AND `key`='".$_REQUEST['qus']."'"));
	$next = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' AND `pos`='".($qus['pos']+1)."'"));	
	if(empty($next)){
		header("location: writetest.php?test=$test[key]");
		exit;
	}	
	else{
		mysql_query("update testassign set `process`='Partialy Completed' where `uid`='$uid' AND `tid`='$tid'");
		header("location: writetest.php?test=$test[key]&qus=$next[key]");
		exit;
	}
}
$res = mysql_fetch_array(mysql_query("select * from results where `tid`='$test[tid]' AND `uid`=".$_SESSION['login']." ORDER by rid DESC"));
$totqus = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]'"));
$cres = mysql_num_rows(mysql_query("select * from results where `tid`='$test[tid]' AND `uid`=".$_SESSION['login']." ORDER by rid DESC"));
$ctotqus = mysql_num_rows(mysql_query("select * from questions where `tid`='$test[tid]'"));
if(isset($_POST['finish'])){
	if($cres==$ctotqus)	{
		mysql_query("update testassign set `process`='Completed' where `uid`='".$_SESSION['login']."' AND `tid`='$test[tid]'");
		$invites = $test['completed']+1;
		mysql_query("UPDATE `tests` SET `completed`='$invites' where `tid`='$test[tid]'");
		setflash("<div class='success msg'>Successfully completed</div>,Your test has been successfully finished");
		sendmail(5,$_SESSION['login']);	
		header("location: managetest.php");
		exit;
	}	
	else{
		if(!empty($res))
		$qus = mysql_fetch_array(mysql_query("select * from questions where `qid`>'$res[qid]' AND `tid`='$test[tid]' ORDER BY pos"));
		else		
		$qus = mysql_fetch_array(mysql_query("select * from questions where `tid`='$fer[tid]' ORDER BY pos"));
		header("location: writetest.php?test=$test[key]&qus=$qus[key]");
		exit;
	}
}
if(isset($_POST['start'])){
	$qus = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' ORDER BY pos"));
	header("location: writetest.php?test=$test[key]&qus=$qus[key]");
}
if(isset($_POST['previous'])){
	$qus = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' AND `key`='".$_REQUEST['qus']."'"));
	print_r($qus);
	$qus = mysql_fetch_array(mysql_query("select * from questions where `pos`='".($qus[pos]-1)."'"));
	print_r($qus);
	exit;
}
if(empty($test)){
	header("location: managetest.php");
	exit;
}
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
?>
<?php require_once('newheader.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        	<td align="left" valign="middle"><h1>Available Test</h1></td>
            <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'].' '.$user['lastname']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
    </table>        
    <?php 
	if(isset($_REQUEST['qus'])){
        $qus = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' AND `key`='".$_REQUEST['qus']."'"));
		$previous = mysql_fetch_array(mysql_query("select * from questions where `tid`='$test[tid]' AND `pos`='".($qus[pos]-1)."'"));
		$ans = mysql_fetch_array(mysql_query("select * from results where `tid`='$test[tid]' AND `qid`='".$qus['qid']."' AND uid=".$_SESSION['login']));
        /*$qust = mysql_num_rows(mysql_query("select * from questions where `tid`='$test[tid]'"));
        $ans = mysql_num_rows(mysql_query("select * from results where `tid`='$test[tid]' AND uid=".$_SESSION['login']));
		if($qust==($ans+1))
		$btn = 'Next Question';
		else
		$btn = 'Next Question';*/
		if(!empty($ans)){
			$val = $ans['answer'];
			$btn = 'reanswered';
		}
		else{
			$val = '';
			$btn = 'answered';
		}
		if(!empty($previous)) $pbtn = '<input type="button" id="previous" name="previous" value="Previous Question">'; else $pbtn = '';
		if(!empty($qus)&& $cres!=$ctotqus){
			echo '
			<form action="" method="post" enctype="multipart/form-data" id="myForm">
			<input type="hidden" id="qid" name="qid" value="'.$qus['qid'].'" />
			<input type="hidden" id="tid" name="tid" value="'.$qus['tid'].'" />
			<input type="hidden" id="cid" name="cid" value="'.$qus['cid'].'" />
			<input type="hidden" id="uid" name="uid" value="'.$_SESSION['login'].'" />';
			if(!empty($ans))
			echo '<input type="hidden" id="rid" name="rid" value="'.$ans['rid'].'" />';
			if($qus['type']=='Text'){
				echo '<input type="hidden" id="weight" name="weight" value="0" />
				<table cellpadding="3" cellspacing="3" border="0" width="100%">			
				<tr>
					<th align="right" width="70" valign="top">'.$qus['pos'].' / '.$ctotqus.' ,</th>
					<th align="left" valign="top">'.utf8_encode($qus['question']).'</th>
				</tr>
				<tr>
					<td align="right" valign="middle">Answer :</td>
					<td align="left" valign="middle"><input type="text" id="answer" style="width:300px;" class="validate[required]" value="'.$val.'" name="answer"></td>
				</tr>
				<tr>
					<td align="center" colspan="2" valign="middle">'.$pbtn.'<input type="submit" id="loginsub" name="'.$btn.'" value="Next Question"></td>
				</tr>
				</table>';
			}
			else{
				echo '
				<table cellpadding="3" cellspacing="3" border="0" width="100%">			
				<tr>
					<th align="right" width="70" valign="top">'.$qus['pos'].' / '.$ctotqus.' ,</th>
					<th align="left" valign="top">'.utf8_encode($qus['question']).'</th>
				</tr>';
				$opt=mysql_fetch_array(mysql_query("select * from options where `qid`='$qus[qid]'"));
				for($x=1;$x<12;$x++){
					if($opt['option'.$x]!=''){
						if($opt['option'.$x]==$val) $chk = 'checked="checked"'; else $chk = '';
						echo '
						<tr>
							<td align="right" valign="middle"></td>
							<td align="left" valign="middle"><label><input type="radio" '.$chk.' id="weight'.$x.'" class="validate[minCheckbox[1]] checkbox" name="weight" value="'.$opt['weight'.$x].'<>'.utf8_encode($opt['option'.$x]).'" />'.utf8_encode($opt['option'.$x]).'</label></td>
						</tr>';
					}
				}
				echo '
				<tr>
					<td align="center" colspan="2" valign="middle">'.$pbtn.'<input type="submit" id="loginsub" name="'.$btn.'" value="Next Question"></td>
				</tr>
				</table>';
			}
			echo '</form>';
			if(!empty($previous)){ 	  
		?> 
			<script type="text/javascript">
            jQuery(document).ready(function(){
                $('#previous').live('click',function(){
                    window.location = 'writetest.php?test=<?php echo $test[key]; ?>&qus=<?php echo $previous[key]; ?>'
                });
            });
            </script>
		<?php
			}
		}else{
		  mysql_query("update testassign set `process`='Partialy Completed' where `uid`='$_SESSION[login]' AND `tid`='$test[tid]'");
		  setflash("<div class='success msg'>Successfully completed</div>,Your test has been successfully finished");
		  header("location: managetest.php");
		  exit;
	  }
	}
	else if($cres==$ctotqus)	{ ?>
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        <tr><td align="left" valign="middle" colspan="2"><?php echo utf8_encode($test['finish']);?></td></tr>
            <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="finish" value="Submit and Finish" style="color: red;font-size: 35px;"></td>
        </tr>
    </table>
    </form>
	<?php } else{?>
    <form action="" method="post" enctype="multipart/form-data" id="myForm">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr><td align="left" valign="middle" colspan="2" style="padding:10px 0;"><strong style="font-size:16px;font-style:italic;text-decoration:underline;"><?php echo $test['testname']; ?></strong></td>        </tr>
        <tr><td align="left" valign="middle" colspan="2"><?php echo utf8_encode($test['instruction']);?></td></tr>
        <tr>
            <td align="center" colspan="2" valign="middle"><input type="submit" id="loginsub" name="start" value="Start"></td>
        </tr>
    </table>
    </form>
    <?php 
	}
      ?>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>