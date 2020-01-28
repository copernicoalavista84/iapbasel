<?php 
require_once("config.php");
checklogin();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
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
            	echo '<a href="index.php">Home</a> | <a href=profile.php>My Profile</a> | <a href=mailsettings.php>Mail Settings</a> | <a href="manageusers.php">Managing Users</a> | <a href="managetests.php">Manage Tests</a> | <a href="managetests.php">Back</a>';
			?>
            </td>
        </tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr><td align="center" colspan="2" valign="middle"><?php echo "<a href='results.php?test=$test[key]'>Overall Report</a> | <a href='catresults.php?test=$test[key]'>Category Report</a> | <a href='print_".basename($_SERVER['REQUEST_URI'])."' target='_blank'>Take a print <img title='print' alt='print' border='0' src='images/print.png'></a>";
			?></td></tr>
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr><td align="left" colspan="2" valign="middle" style="padding:5px 0;"><strong>Test :</strong> <?php echo utf8_encode($test['testname']); ?></td></tr>
        <tr>
        	<td align="left" valign="middle" colspan="2" style="padding:5px 0;"><?php  
					$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[target]'")); if(!empty($ts)) echo "<strong>Target User :</strong> ".utf8_encode($ts[firstname])." ".utf8_encode($ts[lastname]); else echo '<strong>Target User :</strong> N/A'; ?></td>
        </tr>
    </table>		
	<?php
	$cate = mysql_num_rows(mysql_query("select * from categories where `tid`='$test[tid]'"));
	$qus = mysql_num_rows(mysql_query("select * from questions where `tid`='$test[tid]'"));
	$assign = mysql_num_rows(mysql_query("select * from testassign where `tid`='$test[tid]'"));
	$fin = mysql_num_rows(mysql_query("select * from testassign where `tid`='$test[tid]' AND `process`='Completed'"));
	$notfin = mysql_num_rows(mysql_query("select * from testassign where `tid`='$test[tid]' AND `process`='Partialy Completed'"));
	$val = $cate.','.$qus.','.$assign.','.$fin.','.$notfin;
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
                            text: 'Overall Test Report'
                        },
                        xAxis: {
                            categories: ['Categories','Questions','Invites','Completed','Not fully completed']
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
         $tests = mysql_query("select * from testassign where `tid`='$test[tid]' AND `process`!='Assigned'");
    $uc = mysql_num_rows($tests);
    ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <?php
       echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>User Name</th><th align='center' valign='middle'>No. of Qs</th><th align='center' valign='middle'>Max. Avg. Score</th><th align='center' valign='middle'>His Score</th><th align='left' valign='middle'>Process</td></tr>";
        if($uc>0){
			$i = 1;
    while($fer = mysql_fetch_array($tests)){
		$rs = mysql_num_rows(mysql_query("select * from questions where `tid`='$fer[tid]'"));		
		$tester=mysql_fetch_array(mysql_query("select * from users where uid=".$fer['uid']));	
		$score=mysql_fetch_array(mysql_query("select SUM(weight) from results where tid=".$fer['tid']." AND uid=".$fer['uid']));
        echo "<tr><td align='center' valign='middle'>$i</td><td>".utf8_encode($tester[firstname])." ".utf8_encode($tester[lastname])."</TD><TD align='center'>$rs</TD><TD align='center'>$test[max]</TD><td align='center'>$score[0]</td><td align='left'>$fer[process] | <a href='details.php?test=$test[key]&user=$tester[key]'>Details.</a></td></TR>";
		$i++;
    }}
      else echo '<tr><td colspan="6" align="center" valign="middle">There are no test avilable in the account</td></tr>';      
      ?>
    </table>

</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>