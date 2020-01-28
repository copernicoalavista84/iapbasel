<?php 
require_once("config.php");
checklogin();
$test=mysql_fetch_array(mysql_query("select * from tests where `key`='".$_REQUEST['test']."'"));
$user=mysql_fetch_array(mysql_query("select * from users where uid=".$_SESSION['login']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="no" />
<title>IAP Basel Surveying</title>	
<link rel="stylesheet" type="text/css" href="css/style.css" />	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript" src="js/charts/highcharts.js"></script>
</head>
<body style="margin:0 auto;width:1000px;">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr><td align="center" colspan="2" valign="middle">&nbsp;</td></tr>
        <tr><td align="center" colspan="2" valign="middle"><?php echo "<a href='results.php?test=$test[key]'>Overall Report</a> | <a href='catresults.php?test=$test[key]'>Category Report</a>";
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
        $cates = mysql_query("select * from categories where `tid`='$test[tid]'");
    $uc = mysql_num_rows($cates);
    ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <?php
       echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>Category</th><th align='center' valign='middle'>No. of Qs</th><th align='center' valign='middle'>Max. Avg. Score</th><th align='center' valign='middle'>Avg. Score</th><th align='left' valign='middle'>Process</td></tr>";
        if($uc>0){
			$i = 1;
    while($cag = mysql_fetch_array($cates)){
		$rs = mysql_num_rows(mysql_query("select * from questions where `tid`='$cag[tid]'"." AND cid=".$cag['cid']));
		$score=mysql_fetch_array(mysql_query("select SUM(max) as sum, count(*) as cou from questions where tid=".$cag['tid']." AND cid=".$cag['cid']));
		$maxscore = number_format($score['sum']/$score['cou'],2);
		$score=mysql_fetch_array(mysql_query("select SUM(avg) as sum, count(*) as cou from questions where tid=".$cag['tid']." AND cid=".$cag['cid']));
		$avgscore = number_format($score['sum']/$score['cou'],2);
        echo "<tr><td align='center' valign='middle'>$i</td><td>$cag[category]</TD><TD align='center'>$rs</TD><TD align='center'>$maxscore</TD><td align='center'>$avgscore</td><td align='left'><a href='catedetails.php?test=$test[key]&cate=$cag[key]'>Details.</a></td></TR>";
		$i++;
    }}
      else echo '<tr><td colspan="6" align="center" valign="middle">There are no test avilable in the account</td></tr>';      
      ?>
    </table>
    <script type="text/javascript">
	setTimeout('print()',3000);
	</script>
        </body>
</html>