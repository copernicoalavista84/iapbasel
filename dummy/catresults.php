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
        <tr><td align="left" colspan="2" valign="middle" style="padding:5px 0;"><strong>Test :</strong> <?php echo $test['testname']; ?></td></tr>
        <tr>
        	<td align="left" valign="middle" colspan="2" style="padding:5px 0;"><?php  
					$ts = mysql_fetch_array(mysql_query("select * from users where `uid`='$test[target]'")); if(!empty($ts)) echo "<strong>Target User :</strong> $ts[firstname] $ts[lastname]"; else echo '<strong>Target User :</strong> N/A'; ?></td>
        </tr>
    </table>		
	<?php	
	$cates = mysql_query("select * from categories where `tid`='$test[tid]'");
	while($cag = mysql_fetch_array($cates)){
		$type[] = $cag['category'];		
		$score=mysql_fetch_array(mysql_query("select SUM(weight) as sum, count(*) as cou from results where tid=".$cag['tid']." AND cid=".$cag['cid']));
		$finscore[] = number_format($score['sum']/$score['cou'],2);
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
                            text: 'Overall Test Category Report'
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
 $ques = mysql_query("select cid from questions where `tid`='$test[tid]'");
 while($id  = mysql_fetch_array($ques)){
 	$a[] = $id['cid'];
 }
$fa = explode(',',implode(',',$a));
$cidarr = array_count_values($fa);
ksort($cidarr);

    $cates = mysql_query("select * from categories where `tid`='$test[tid]'");
    $uc = mysql_num_rows($cates);
    ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <?php
       echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>Category</th><th align='center' valign='middle'>No. of Qs</th><th align='center' valign='middle'>Max. Avg. Score</th><th align='center' valign='middle'>Avg. Score</th><th align='left' valign='middle'>Process</td></tr>";
        if($uc>0){
			$i = 1;
    while($cag = mysql_fetch_array($cates)){
		$catid = $cag['cid'];
		$rs = mysql_num_rows(mysql_query("select * from questions where `tid`='$cag[tid]'"." AND cid=".$cag['cid']));
		// echo $rs;
		$scoreq = "select SUM(max) as sum, count(*) as cou from questions where tid=".$cag['tid']." AND cid in (".$cag['cid'].")";
//		echo $scoreq; 
		$score=mysql_fetch_array(mysql_query($scoreq));
		$maxscore = number_format($score['sum']/$score['cou'],2);
		$score=mysql_fetch_array(mysql_query("select SUM(avg) as sum, count(*) as cou from questions where tid=".$cag['tid']." AND cid=".$cag['cid']));
		$avgscore = number_format($score['sum']/$score['cou'],2);
        echo "<tr><td align='center' valign='middle'>$i</td><td>$cag[category]</TD><TD align='center'>$cidarr[$catid]</TD><TD align='center'>$maxscore</TD><td align='center'>$avgscore</td><td align='left'><a href='catedetails.php?test=$test[key]&cate=$cag[key]'>Details.</a></td></TR>";
		$i++;
    }}
      else echo '<tr><td colspan="6" align="center" valign="middle">There are no test avilable in the account</td></tr>';      
      ?>
    </table>

</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>