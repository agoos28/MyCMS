<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php

$this->document->addScript( _PATH_ROOT._PATH_CALENDAR.'calendar.js');
//
$lang     =&  JFactory::getLanguage();
$langTag =   $lang->getTag();
if ( JFile::exists( JPATH_SITE._PATH_FORMVALIDATOR.$langTag.'_formvalidator.js' ) ) {
  $this->document->addScript( _PATH_ROOT._PATH_FORMVALIDATOR.$langTag.'_formvalidator.js' );
} else {
  $this->document->addScript( _PATH_ROOT._PATH_FORMVALIDATOR.'formvalidator.js' );
}
//
$this->document->addStyleSheet( _PATH_ROOT._PATH_FORMVALIDATOR.'formvalidator.css' );
$this->document->addScript( _PATH_ROOT._PATH_MOOTIPS.'mootips.js' );
$this->document->addStyleSheet( _PATH_ROOT._PATH_MOOTIPS.'mootips.css' );


$tipsOnClick		=	( _SITEFORM_ONCLICK ) ? _SITEFORM_ONCLICK : 0;
$validationAlert	=	( _VALIDATION_ALERT ) ? JText::_( 'ONE OR MORE FIELDS' ) : '';
$formName			=	'newsletter';

?>
<?php if(count($this->errors)){ ?>

<div class="status" style="padding: 20px 0;"> <?php echo implode('<br />', $this->errors);?> </div>
<?php } ?>
<div class="col-md-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title">Send Newsletter</h4>
      <div class="panel-tools">
        <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
          <ul class="dropdown-menu dropdown-light pull-right" role="menu" style="display: none;">
            <li> <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a> </li>
            <li> <a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a> </li>
            <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <form action="<?php echo JURI::current(); ?>" method="post" name="newsletter" id="newsletter">
        <div class="form-group">
          <label for="subject"><span class="text-bold">Email Subject</span></label>
          <input class="form-control" type="text" id="subject" name="subject" maxlength="255" size="50" value="<?php echo JRequest::getVar('subject'); ?>"  />
        </div>
        
        <div class="form-group">
          <label for="email_content" >Email Content</label>
          <?php 
						$wysEditor = JFactory::getEditor(); 
						$content = JRequest::getVar('email_content', '', 'post', 'string', JREQUEST_ALLOWRAW);
						
						if(!trim($content)){
							jimport('joomla.filesystem.file');
							$templateuri = JPATH_BASE.DS.'images'.DS.'newsletter-template.html';
							if(JFile::exists($templateuri)){
								$content = JFile::read($templateuri);
							}
						}
						
						echo $wysEditor->display('email_content',$content,'100%','500px',60,15);
					?>
        </div>
        <div class="row">
        <div class="col-xs-12">
        <div class="form-group" style="margin-bottom: 0;">
          <div class="checkbox-inline" style="padding-left: 0;"> 
          <input id="test" type="checkbox" name="test" value="1" class="grey"> <label for="test" >Send test email only to address below</label>
          </div>
          
          
        </div>
        </div>
        <div class="col-sm-6 col-xs-12">
        <div class="form-group">
        	<input class="form-control" type="text" id="testmail" name="testmail" maxlength="255" size="50" value="" placeholder="Tester email address"  />
        </div>
        
        </div>
        <div class="col-sm-6 col-xs-12">
          <div class="form-group button_submit-wrap" data-type="27" data-visibility="0">
            <div class="text-right">
              <button class="color-button btn btn-default" type="button" onclick="javascript: history.go(-1);" name="button_back" style="">Back </button>
              &nbsp;
              <button class="color-button btn btn-primary" type="submit" name="button_submit" style="">Send !</button>
            </div>
          </div>
        </div>
        </div>

        <input name="current_url" value="<?php echo JURI::current(); ?>" type="hidden">
        <input name="option" value="com_cckjseblod" type="hidden">
        <input type="hidden" name="task" value="send_newsletter" />
        <input type="hidden" name="controller" value="newsletter" />
        <input type="hidden" name="templateid" value="<?php echo $this->template->id; ?>" />
        <input type="hidden" name="actionmode" value="send" />
        <?php echo JHTML::_('form.token'); ?>
      </form>
    </div>
  </div>
</div>
