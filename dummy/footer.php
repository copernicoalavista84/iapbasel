    </div>
    <div id="footer">Copyright &copy; 2013 by IAP Basel. All rights reserved. Powered by <a href="http://www.portfolio.cajadelapices.com/">CdL</a>.</div>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33130548-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    <?php $msg=findFlash(); if(!empty($msg)) echo '<script type="text/javascript">message("'.getFlash().'");</script>'; ?>
</body>
</html>