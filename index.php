<?php
ob_start();
session_start();
require('dts/dbaSis.php');
require('dts/getSis.php');
require('dts/setSis.php');
require('dts/othSis.php');
viewManager(10*60);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="<?=BASE?>/tpl/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?=BASE?>/js/shadowbox/shadowbox.css"/>
<link rel="stylesheet" type="text/css" href="<?=BASE?>/js/fancybox/jquery.fancybox-1.3.4.css"/>
<link rel="icon" type="image/png" href="<?=BASE?>/tpl/images/favicon.png" />

<!--[if IE]>
    <style type="text/css">
    #header .hnav li{margin-right:15px;}
    #header .hnav li a{padding:8px}
    #header .hnav li a:hover{background:#E21F26;}
    #header .hnav .last{margin:0; float:right;}
    </style>
<![endif]-->

<?php
getUrl();
?>

<div style="clear:both"></div><!-- /clear -->
</div><!-- ///site -->

<div id="footer">
	<h2>Comunic Notícias</h2>
    <p><?=date('Y')?> © Comunic - Todos os direitos reservados</p>
</div><!-- footer -->

</body>
<?php include('js/jscSis.php'); ob_end_flush();?>
</html>