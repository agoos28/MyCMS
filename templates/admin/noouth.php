<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::_('bootstrap.framework');

$baseUrl = JURI::base(true);
include_once (dirname(__FILE__).DS.'adm_vars.php');
//remove mootools.js and caption.js
$headerstuff = $this->getHeadData();
//echo'<pre>';print_r($headerstuff);echo'</pre>';
unset($headerstuff['styleSheets'][$baseUrl.'/media/system/css/modal.css']);
unset($headerstuff['styleSheets'][$baseUrl.'/components/com_cckjseblod/assets/css/site.css']);
unset($headerstuff['scripts'][$baseUrl.'/includes/js/joomla.javascript.js']);
unset($headerstuff['scripts'][$baseUrl.'/media/system/js/mootools.js']);
unset($headerstuff['scripts'][$baseUrl.'/media/system/js/modal.js']);
//echo'<pre>';print_r($headerstuff);echo'</pre>';die();	
$this->setHeadData($headerstuff);
$this->setGenerator('agoos28');

?>

<!DOCTYPE html>
<html lang="en">
<head>

<jdoc:include type="head" />

<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/animate.css/animate.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/iCheck/skins/all.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/styles.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/styles-responsive.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/iCheck/skins/all.css">


<script type="text/javascript">
	var baseUrl = '<?php echo JURI::base(); ?>'
</script>


</head>

<body class="login">
<jdoc:include type="component" />		
<jdoc:include type="modules" name="debug" />

<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/iCheck/jquery.icheck.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jquery.transit/jquery.transit.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/js/main.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/js/login.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
	jQuery(document).ready(function() {
		Login.init();
	});
</script>
</body>

</html>
