<?php 
require_once("config.php");
checkuser($con);
$test=mysqli_fetch_array(mysqli_query($con, "select * from tests"), MYSQLI_ASSOC);
$user=mysqli_fetch_array(mysqli_query($con, "select * from users where uid=".$_SESSION['login']), MYSQLI_ASSOC);
?>
<?php require_once('header.php'); ?>
<div class="contenttopbg"></div>
<div class="contentcenbg">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
        <tr>
        	<td align="left" valign="middle"><h1>Available Test</h1></td>
            <td align="right" valign="middle" style="padding-right:30px;">Welcome <?php print $user['firstname'].' '.$user['lastname']; ?>, <a href=logout.php>Logout</a></td>
        </tr>
    </table>        
    <?php 
         $tests = mysqli_query($con, "select * from testassign where `print`=0 AND `uid`='$user[uid]'");
    $uc = mysqli_num_rows($tests);
    ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="content">
        <?php
       echo "<TR><th align='center' valign='middle' width='30'>#</th><th align='left' valign='middle'>Test Name</th><th align='center' valign='middle'>No. of Qs</th><th align='left' valign='middle'>Actions</td></tr>";
        if($uc>0){
			$i = 1;
    while($fer = mysqli_fetch_array($tests)){
		$ts = mysqli_fetch_array(mysqli_query($con, "select * from tests where `tid`='$fer[tid]'"), MYSQLI_ASSOC);
		$rs = mysqli_num_rows(mysqli_query($con, "select * from questions where `tid`='$fer[tid]'"));
		
		$res = mysqli_fetch_array(mysqli_query($con, "select * from results where `tid`='$fer[tid]' AND `uid`=".$_SESSION['login']." ORDER by rid DESC"), MYSQLI_ASSOC);
		if(empty($res))
		$qus = mysqli_fetch_array(mysqli_query($con, "select * from questions where `tid`='$fer[tid]' ORDER BY pos"), MYSQLI_ASSOC);
		else{					
			$res = mysqli_num_rows(mysqli_query($con, "select * from results where `tid`='$fer[tid]' AND `uid`=".$_SESSION['login']." ORDER by rid DESC"));
			$qus = mysqli_fetch_array(mysqli_query($con, "select * from questions where `tid`=$fer[tid] ORDER BY pos limit $res,1"), MYSQLI_ASSOC);	
		}
		if($fer[process]=='Completed' && $ts['print']==1)
			$process = "Completed | <a href='print.php?test=$ts[key]&user=$user[key]' target='_blank'><img title='print' alt='print' src='images/print.png' border='0'></a>";
		elseif($fer[process]=='Completed')
			$process = "Completed";
		else if($fer[process]=='Assigned')
			$process = "Assigned | <a href='writetest.php?test=$ts[key]'>Take Test.</a>";
		else
			$process = "Partialy Completed | <a href='writetest.php?test=$ts[key]&qus=$qus[key]'>Continue Test</a>";
        echo "<tr><td align='center' valign='middle'>$i</td><td>$ts[testname]</TD><TD align='center'>$rs</TD><td>$process</td></TR>";
		$i++;
    }}
      else echo '<tr><td colspan="5" align="center" valign="middle">There are no test avilable in the account</td></tr>';      
      ?>
    </table>
</div>
<div class="contentbotbg"></div>
<?php require_once('footer.php'); ?>