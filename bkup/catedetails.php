<?php 
require_once("config.php");
checklogin();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
$cat=mysql_fetch_array(mysql_query("select * from categories where `key`='".$_REQUEST['cate']."'"));
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
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="catresults.php?test='.$test[key].'">Back</a>';
			?>
            </td>
        </tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr><td align="center" colspan="2" valign="middle"><?php echo "<a href='results.php?test=$test[key]'>Overall Report</a> | <a href='catresults.php?test=$test[key]'>Category Report</a> | <a href='print_".basename($_SERVER['REQUEST_URI'])."' target='_blank'>Take a print <img title='print' alt='print' border='0' src='images/print.png'></a>";
			?></td></tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr><td align="left" colspan="2" valign="middle" style="padding:5px 0;"><strong>Test :</strong> <?php echo $test['testname']; ?></td></tr>
        <tr>
        	<td align="left" valign="middle" colspan="2" style="padding:5px 0;"><?php  
					$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[target]'")); if(!empty($ts)) echo "<strong>Target User :</strong> $ts[firstname] $ts[lastname]"; else echo '<strong>Target User :</strong> N/A'; ?></td>
        </tr>
        <tr><td align="left" colspan="2" valign="middle" style="padding:5px 0;"><strong>Category :</strong> <?php echo $cat['category']; ?></td></tr>
    </table>		
	<?php	
	$score=mysql_fetch_array(mysql_query("select SUM(max) as sum, count(*) as cou from questions where tid=".$cat['tid']." AND cid=".$cat['cid']));
	$finscore[] = number_format($score['sum']/$score['cou'],2);
	$type[] = 'Max';
	$assign = mysql_query("select * from testassign where `tid`='$test[tid]' AND `process`='Completed'");
    $uc = mysql_num_rows($assign);
	if($uc>0){
		$i = 1;
		while($tests = mysql_fetch_array($assign)){
		$tester=mysql_fetch_array(mysql_query("select * from users where `uid`='".$tests['uid']."'"));		
		$type[] = $tester['firstname'].' '.$tester['lastname'];
		$score=mysql_fetch_array(mysql_query("select SUM(weight) as sum, count(*) as cou from results where tid=".$cat['tid']." AND cid=".$cat['cid']." AND uid=".$tests['uid']));
		$finscore[] = number_format($score['sum']/$score['cou'],2);
			$i++;
		}
	}
	$var = implode("','",$type);
	$val = implode(",",$finscore);
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
		unset($type);
		unset($finscore);
	$score=mysql_fetch_array(mysql_query("select SUM(max) as sum, count(*) as cou from questions where tid=".$cat['tid']." AND cid=".$cat['cid']));
	$finscore[] = number_format($score['sum']/$score['cou'],2);
	$type[] = 'Max';
	$type[] = 'Target';
	$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[target]'")); 
	if(!empty($ts)){
		$score=mysql_fetch_array(mysql_query("select SUM(weight) as sum, count(*) as cou from results where tid=".$cat['tid']." AND cid=".$cat['cid']." AND uid=".$ts['uid']));
		if(!empty($score))
			$finscore[] = number_format($score['sum']/$score['cou'],2);
		else
			$finscore[]=0;
	}
	else
	$finscore[]=0;
	$relation = array('Colleague','Chief','Customer','Employee');
	foreach($relation as $relation){
		$users = mysql_query("select * from users where `relationship`='$relation' AND `createby`='$test[uid]' AND `uid`!='$test[target]'");
		while($users = mysql_fetch_array($users)){			
			$score=mysql_fetch_array(mysql_query("select SUM(weight) as sum, count(*) as cou from results where tid=".$cat['tid']." AND cid=".$cat['cid']." AND uid=".$users['uid']));
			if(!empty($score)){
				$type[] = $relation;
				$finscore[] = number_format($score['sum']/$score['cou'],2);
			}
		}
	}
	$var = implode("','",$type);
	$val = implode(",",$finscore);
	?>
	<script type="text/javascript">
            var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'chartsq',
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
        <div id="chartsq"></div>
 <?php 
    $questions = mysql_query("select * from questions where uid='$test[uid]' AND tid=".$test['tid']." AND cid=".$cat['cid']);
    $uc = mysql_num_rows($questions);
    ?>
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
    <?php
       echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>Question</th><th align='left' valign='middle'>Type</th><th align='center' valign='middle'>Max. Avg. Score</th><th align='center' valign='middle'>Avg. Score</th></tr>";
		if($uc>0){
			$i = 1;
			while($qus = mysql_fetch_array($questions)){
				$cat = mysql_fetch_array(mysql_query("select * from categories where `cid`='$qus[cid]'"));
				$tuser = mysql_fetch_array(mysql_query("select * from results where `qid`='$qus[qid]'"));
				$score=mysql_fetch_array(mysql_query("select weight from results where tid=".$qus['tid']." AND cid=".$qus['cid']." AND qid=".$qus['qid']));
				echo "<tr><td align='center' valign='middle'>$i</td><td align='left' valign='middle'>$qus[question]</td><td align='left' valign='middle'>$qus[type]</td><td align='center' valign='middle'>$qus[max]</td><td align='center' valign='middle'>$qus[avg]</td></tr>";
				$i++;
			}
		}
		else echo '<tr><td colspan="5" align="center" valign="middle">There are no questions avilable for this test</td></tr>';	
    ?>
    </table>

</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>