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



<!-- start: MAIN CSS -->
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,200,100,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/iCheck/skins/all.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/animate.css/animate.min.css">
<!-- end: MAIN CSS -->
<!-- start: CSS REQUIRED FOR SUBVIEW CONTENTS -->
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/owl-carousel/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/owl-carousel/owl-carousel/owl.theme.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/owl-carousel/owl-carousel/owl.transitions.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/summernote/dist/summernote.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/fullcalendar/fullcalendar/fullcalendar.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-select/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/DataTables/media/css/DT_bootstrap.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<!-- end: CSS REQUIRED FOR THIS SUBVIEW CONTENTS-->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/weather-icons/css/weather-icons.min.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/nvd3/nv.d3.min.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CORE CSS -->
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/styles.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/styles-responsive.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/plugins.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/themes/theme-default.css" type="text/css" id="skin_color">
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/print.css" type="text/css" media="print"/>

<!-- end: CORE CSS -->


<script type="text/javascript">
	var baseUrl = '<?php echo JURI::base(); ?>'
</script>


</head>

<body>

<div class="main-wrapper">
	<a class="closedbar inner hidden-sm hidden-xs" href="#"></a>
    <nav id="pageslide-left" class="pageslide inner">
    	<div class="navbar-content">
            <div class="main-navigation left-wrapper transition-left">
            	<div class="navigation-toggler hidden-sm hidden-xs">
                    <a href="#main-navbar" class="sb-toggle-left">
                    </a>
                </div>
                <jdoc:include type="modules" name="main-navbar" />
                <ul class="main-navigation-menu">
                <li>
                    <a href="<?php echo JURI::base(); ?>administration"><i class="fa fa-home"></i> <span class="title">Dashboard</span></a>
                </li>
              	</ul>
                <jdoc:include type="modules" name="main-navigation-menu" />
            </div>
        </div>
    </nav>
    <div class="main-container inner">
    
        <div class="main-content">
            <div class="container">
                <div class="toolbar row">
                		<div class="hidden-lg hidden-md pull-left">
                      <a style="display: inline-block;margin: 15px 0px 0px 15px;font-size: 28px;/*! transform: translate(0px,6px); */color: #000;" class="sb-toggle-left hidden-md hidden-lg" href="#main-navbar">
                      <i class="fa fa-bars"></i>
                      </a>
                    </div>
                    <div class="col-md-6 col-sm-5 hidden-xs">
                    		
                        <div class="page-header">
                            <h1 style="font-size: 26px; line-height: 1.3; font-weight: 300; white-space: nowrap;"><?php echo $this->getTitle(); ?><small>Administrations</small></h1>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-11">
                        
                        <a href="#" class="back-subviews">
                            <i class="fa fa-chevron-left"></i> BACK
                        </a>
                        <a href="#" class="close-subviews">
                            <i class="fa fa-times"></i> CLOSE
                        </a>
                        <div class="toolbar-tools pull-right">
                            <!-- start: TOP NAVIGATION MENU -->
                            <ul class="nav navbar-right">
                                <!-- start: TO-DO DROPDOWN -->
                                <li class="menu-go">
                                    <a target="_blank" href="<?php echo JURI::base(); ?>">
                                        <i class="fa fa-link"></i> VIEW SITE
                                    </a>
                                </li>
                                
                                <li class="menu-search">
                                    <a href="#">
                                        <i class="fa fa-search"></i> SEARCH
                                    </a>
                                    <!-- start: SEARCH POPOVER -->
                                    <div class="popover bottom search-box transition-all">
                                        <div class="arrow"></div>
                                        <div class="popover-content">
                                            <!-- start: SEARCH FORM -->
                                            <form class="" id="searchform" action="#">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-main-color btn-squared" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button> </span>
                                                </div>
                                            </form>
                                            <!-- end: SEARCH FORM -->
                                        </div>
                                    </div>
                                    <!-- end: SEARCH POPOVER -->
                                </li>
                                
                            </ul>
                            <!-- end: TOP NAVIGATION MENU -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <div><jdoc:include type="modules" name="breadcrumbs" /></div>
                    </div>
                </div>
                <?php if ($this->getBuffer('message')) { ?>
                
                <div class="system-message">
                    <jdoc:include type="message" />
                  </div>
                 
                <?php } ?>
                <jdoc:include type="component" />
            </div>
        </div>
    </div>
</div>
<jdoc:include type="modules" name="debug" />
<!-- start: MAIN JAVASCRIPTS -->
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/blockUI/jquery.blockUI.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/iCheck/jquery.icheck.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/moment/min/moment.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootbox/bootbox.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jquery.scrollTo/jquery.scrollTo.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/ScrollToFixed/jquery-scrolltofixed-min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jquery.appear/jquery.appear.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/velocity/jquery.velocity.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jquery-mockjax/jquery.mockjax.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/toastr/toastr.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/truncate/jquery.truncate.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/summernote/dist/summernote.min.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/js/subview.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/js/subview-examples.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/nestable/jquery.nestable.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->

<!-- start: CORE JAVASCRIPTS  -->

<script src="<?php echo $tmpTools->templateurl(); ?>/js/form-elements.js"></script>
<script src="<?php echo $tmpTools->templateurl(); ?>/js/main.js"></script>
<!-- end: CORE JAVASCRIPTS  -->
<script>
    jQuery(document).ready(function() {
        Main.init();
        //SVExamples.init();
        //Index.init();
    });
</script>
</body>

</html>
