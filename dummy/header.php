<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="no" />
<title>IAP Basel Surveying</title>	
<link rel="stylesheet" type="text/css" href="css/style.css" />	
<link rel="stylesheet" type="text/css" href="css/jquery.confirm/jquery.confirm.css" />
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css" />		
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript" src="js/charts/highcharts.js"></script>
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>	

<script type="text/javascript">
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#myForm").validationEngine();
		jQuery("#myForm1").validationEngine('attach', {autoPositionUpdate : true});
	});
</script>

</head>
<body>
    <div class="wrapper">
        <img src="images/IAP-BASEL.jpg" style="padding:5px 0 5px 10px;width:63%;">
        <img src="images/txt.png" style="padding:0 0 0 10px;width:63%;">
        <div style="position:absolute;top:5px;right:50px">
        <?php if(basename($_SERVER['PHP_SELF'])=='writetest.php'){
			 if($test['logo']=='') echo '<img src="images/no_preview.jpg" alt="logo" title="logo" width="100" />';
            else echo '<img src="files/'.$test['logo'].'" alt="logo" title="logo" width="100" />';
		}?>
		</div>