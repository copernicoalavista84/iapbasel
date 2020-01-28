<?php 
require_once("config.php");
checklogin();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
$cat=mysql_fetch_array(mysql_query("select * from categories where `key`='".$_REQUEST['cate']."'"));
$tester=mysql_fetch_array(mysql_query("select * from users where `key`='".$_REQUEST['user']."'"));
$result=mysql_fetch_array(mysql_query("select * from testassign where `uid`='".$tester['uid']."' AND `tid`='".$test['tid']."'"));
?>
<?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        	<td align="left" valign="middle"><h1>Results</h1></td>
            <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'].' '.$user['lastname'].', '.$user['actype']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
        <tr>
        	<td align="center" colspan="2" valign="middle">
       		<?php 
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="details.php?test='.$test[key].'&user='.$tester['key'].'">Back</a>';
			?>
            </td>
        </tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr><td align="center" colspan="2" valign="middle"><?php echo "<a href='results.php?test=$test[key]'>Overall Report</a> | <a href='catresults.php?test=$test[key]'>Category Report</a> | <a href='print_".basename($_SERVER['REQUEST_URI'])."' target='_blank'>Take a print <img title='print' alt='print' border='0' src='images/print.png'></a>";
			?></td></tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr>
        	<td align="left" valign="middle" style="padding:5px 0;"><strong>User :</strong> <?php echo $tester['firstname'].' '.$tester['lastname']; ?></td>
            <td align="left" valign="middle" style="padding:5px 0;"><strong>Test :</strong> <?php echo $test['testname']; ?></td>
        </tr>
        <tr>
        	<td align="left" valign="middle" style="padding:5px 0;"><strong>Position :</strong> <?php echo $tester['relationship']; ?></td>
        	<td align="left" valign="middle" style="padding:5px 0;"><?php  
					$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[target]'")); if(!empty($ts)) echo "<strong>Target User :</strong> $ts[firstname] $ts[lastname]"; else echo '<strong>Target User :</strong> N/A'; ?></td>
        </tr>
        <tr>
            <td align="left" valign="middle" style="padding:5px 0;"><strong>Status :</strong> <?php echo $result['process']; ?></td>
            <td align="left" valign="middle" style="padding:5px 0;"><strong>Category :</strong> <?php echo $cat['category']; ?></td>
        </tr>
    </table>		
	<?php
    $questions = mysql_query("select * from questions where uid='$test[uid]' AND tid=".$test['tid']." AND cid=".$cat['cid']);
    $uc = mysql_num_rows($questions);
	if($uc>0){
		$i = 1;
		while($qus = mysql_fetch_array($questions)){			
		$type[] = 'Q'.$i;		
		$score=mysql_fetch_array(mysql_query("select weight from results where tid=".$qus['tid']." AND cid=".$qus['cid']." AND qid=".$qus['qid']." AND uid=".$tester['uid']));
		$finscore[] = $score['weight'];
			$i++;
		}
	$var = implode("','",$type);
	$val = implode(",",$finscore);
	}
	?>
	<script type="text/javascript">
            var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'charts',
                            defaultSeriesType: 'column'
                        },
                        title: {
                            text: 'Category <?php echo $cat[category]; ?> Report'
                        },
                        xAxis: {
                            categories: ['<?php echo $var; ?>']
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Total based on results'
                            },
                            stackLabels: {
                                enabled: true,
                                style: {
                                    fontWeight: 'bold',
                                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                                }
                            }
                        },
                        legend: {
                            align: 'right',
                            x: -100,
                            verticalAlign: 'top',
                            y: 20,
                            floating: true,
                            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                            borderColor: '#CCC',
                            borderWidth: 1,
                            shadow: false
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.x +'</b><br/>'+
                                     this.series.name +': '+ this.y;
                            }
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                dataLabels: {
                                    enabled: false,
                                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                                }
                            }
                        },
                        series: [{
                            name: 'Count',
                            data: [<?php echo $val; ?>]
                        }]
                    });                  
                    
                });
                    
            </script>
        <div id="charts"></div>
 <?php 
    $questions = mysql_query("select * from questions where uid='$test[uid]' AND tid=".$test['tid']." AND cid=".$cat['cid']);
    $uc = mysql_num_rows($questions);
	$tester=mysql_fetch_array(mysql_query("select * from users where `key`='".$_REQUEST['user']."'"));
    ?>
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
    <?php
       echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='center' valign='middle'>Max. Avg. Score</th><th align='center' valign='middle'>Avg. Score</th><th align='center' valign='middle'>His Avg. Score</th></tr>";
		if($uc>0){
			$i = 1;
			while($qus = mysql_fetch_array($questions)){
				$cat = mysql_fetch_array(mysql_query("select * from categories where `cid`='$qus[cid]'"));
				$tuser = mysql_fetch_array(mysql_query("select * from results where `qid`='$qus[qid]' AND uid=$tester[uid]"));
				$score=mysql_fetch_array(mysql_query("select weight from results where tid=".$qus['tid']." AND cid=".$qus['cid']." AND qid=".$qus['qid']." AND uid=".$tester['uid']));
				echo "<tr><td align='center' valign='middle'>Q $i</td><td align='center' valign='middle'>$qus[max]</td><td align='center' valign='middle'>$qus[avg]</td><td align='center' valign='middle'>$score[weight]</td></tr>";
				$i++;
			}
		echo '<tr><td colspan="5" align="center" style="border:0px solid;" valign="middle">&nbsp;</td></tr>';	
		?>
    </table>
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <?php
    $questions = mysql_query("select * from questions where uid='$test[uid]' AND tid=".$test['tid']." AND cid=".$cat['cid']);
		echo '<tr><th align="center" valign="middle" width="30">#</th><th align="left" valign="middle">Question</th><th align="left" valign="middle">Type</th><th align="left" valign="middle">Answer</th></tr>';
			$i = 1;
			while($qus = mysql_fetch_array($questions)){
				$cat = mysql_fetch_array(mysql_query("select * from categories where `cid`='$qus[cid]'"));
				$tuser = mysql_fetch_array(mysql_query("select * from results where `qid`='$qus[qid]' AND uid=$tester[uid]"));
				echo "<tr><td align='center' valign='middle'>$i</td><td align='left' valign='middle'>$qus[question]</td><td align='left' valign='middle'>$qus[type]</td><td align='left' valign='middle'>$tuser[answer]</td></tr>";
				$i++;
			}
		}
		else echo '<tr><td colspan="5" align="center" valign="middle">There are no questions avilable for this test</td></tr>';	
    ?>
    </table>

</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>