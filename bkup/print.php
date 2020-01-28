<?php 
require_once("config.php");
checkuser();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
$tester=mysql_fetch_array(mysql_query("select * from users where `key`='".$_REQUEST['user']."'"));
$result=mysql_fetch_array(mysql_query("select * from testassign where `uid`='".$tester['uid']."' AND `tid`='".$test['tid']."'"));
mysql_query("update testassign set `print`=1 where `uid`='".$tester['uid']."' AND `tid`='".$test['tid']."'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="no" />
<title>IAP Basel Surveying</title>	
<link rel="stylesheet" type="text/css" href="css/style.css" />	
</head>
<body style="margin:0 auto;width:1000px;" onload="javascript:print();">
<table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr>
        	<td align="left" valign="middle" style="padding:5px 0;"><strong>User :</strong> <?php echo $tester['firstname'].' '.$tester['lastname']; ?></td>
            <td align="center" valign="middle" style="padding:5px 0;" rowspan="4"><?php if($test['logo']=='') echo '<img src="images/no_preview.jpg" alt="logo" title="logo" width="100" />'; else echo '<img src="files/'.$test['logo'].'" alt="logo" title="logo" width="100" />';?></td>
        </tr>
        <tr>
            <td align="left" valign="middle" style="padding:5px 0;"><strong>Test :</strong> <?php echo $test['testname']; ?></td>
        </tr>
        <tr>
        	<td align="left" valign="middle" style="padding:5px 0;"><strong>Position :</strong> <?php echo $tester['relationship']; ?></td>
        </tr>
        <tr>
            <td align="left" valign="middle" style="padding:5px 0;"><strong>Status :</strong> <?php echo $result['process']; ?></td>
        </tr>
    </table>
    <?php 
    $questions = mysql_query("select * from questions where tid=".$test['tid']." ORDER BY pos");
	$qcount = mysql_num_rows($questions);
    ?>
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
    <?php
			$i = 1;
			while($qus = mysql_fetch_array($questions)){
				$res = mysql_fetch_array(mysql_query("select * from results where `qid`='$qus[qid]' AND uid=".$_SESSION['login']));		
				echo "<tr><td align='left' valign='middle'><strong>$i / $qcount ,</strong> $qus[question]</td></tr>";
				if($qus[type]=='Text'){
				echo "<tr><td align='left' valign='middle'><strong>Question Answer :</strong> $qus[answer]</td></tr>";
				echo "<tr><td align='left' valign='middle'><strong>User Answer :</strong> $res[answer]</td></tr>";
				}
				else{
					$opt=mysql_fetch_array(mysql_query("select * from options where `qid`='$qus[qid]'"));
					$options = '<ul>';
					for($x=1;$x<12;$x++){
						if($opt['option'.$x]!='')
							$options .='<li>'.$opt['option'.$x].'</li>';
					}
					$options .= '</ul>';
					echo "<tr><td align='left' valign='middle'>$options</td></tr>";
					echo "<tr><td align='left' valign='middle'><strong>User Answer :</strong> $res[answer]</td></tr>";
				}
				$i++;
			}
    ?>
    </table>
        </body>
</html>