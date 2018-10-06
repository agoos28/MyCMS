<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<?php
//JHTML::_( 'behavior.mootools' );
//JHTML::_( 'behavior.modal' );
//$this->document->addScript( _PATH_ROOT._PATH_CALENDAR.'calendar.js');
//

JHTML::_( 'jquery.sortable' );
$lang     =&  JFactory::getLanguage();
$langTag =   $lang->getTag();
if ( JFile::exists( JPATH_SITE._PATH_FORMVALIDATOR.$langTag.'_formvalidator.js' ) ) {
  //$this->document->addScript( _PATH_ROOT._PATH_FORMVALIDATOR.$langTag.'_formvalidator.js' );
} else {
  //$this->document->addScript( _PATH_ROOT._PATH_FORMVALIDATOR.'formvalidator.js' );
}
//
//$this->document->addStyleSheet( _PATH_ROOT._PATH_FORMVALIDATOR.'formvalidator.css' );
//$this->document->addScript( _PATH_ROOT._PATH_MOOTIPS.'mootips.js' );
//$this->document->addStyleSheet( _PATH_ROOT._PATH_MOOTIPS.'mootips.css' );

$tipsOnClick		=	( _SITEFORM_ONCLICK ) ? _SITEFORM_ONCLICK : 0;
$validationAlert	=	( _VALIDATION_ALERT ) ? JText::_( 'ONE OR MORE FIELDS' ) : '';
$formName			=	$this->formName;

$javascript ='
	window.addEvent("domready",function(){	
		var siteFormValidator = new FormValidator(document.getElementById("'.$formName.'"));
		var tipsOnClick = "'.$tipsOnClick.'";
		if(tipsOnClick==1){var AjaxTooltips=new MooTips($$(".DescriptionTip"),{className:"ajaxTool",showOnClick:true,showOnMouseEnter:false,fixed:true})}else{var AjaxTooltips=new MooTips($$(".DescriptionTip"),{className:"ajaxTool",fixed:true})}
	});
	
	function submitbutton(pressbutton) {
		var siteFormValidator = new FormValidator(document.getElementById("'.$formName.'"));
		
		if ( pressbutton == "save" ) {
			if (siteFormValidator.validate()) {
				document.'.$formName.'.submit();
				return;
			} else {
				if ( ! $("validation-alert-elem") ) {
					var p = $("validation-alert-container");
					var newElement = document.createElement("div");
					var message = document.createTextNode("'.$validationAlert.'");					
					newElement.appendChild(message);
					newElement.setAttribute("id", "validation-alert-elem");
					newElement.className = "validation-advice";
					if(p) { p.adopt(newElement); }
				}
			}
		}		
	}
	';
//$this->document->addScriptDeclaration( $javascript );
?>

<?php echo $this->data; ?>

<?php echo $this->formHidden; ?>

<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />
<?php if(JRequest::getVar('asnew') == 1){ ?>
<input type="hidden" name="id" value="0" />
<?php }else{ ?>
<input type="hidden" name="id" value="<?php echo $this->cckId; ?>" />
<?php } ?>
<input type="hidden" name="itemid" value="<?php echo $this->itemId; ?>" />
<input type="hidden" name="current_url" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
<input type="hidden" name="typeid" value="<?php echo $this->typeid; ?>" />
<input type="hidden" name="templateid" value="<?php echo $this->templateid; ?>" />
<input type="hidden" name="formname" value="<?php echo $formName; ?>" />
<input type="hidden" name="actionmode" value="<?php echo $this->actionMode; ?>" />
<input type="hidden" name="captcha_enable" value="<?php echo $this->captchaEnable; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
<div class="modal fade" id="iframemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button id="iframemodal-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <iframe src="<?php echo JURI::base(); ?>index.php?option=com_media&view=images&layout=default&tmpl=component" frameborder="0" scrolling="yes"></iframe>
      </div>
      
    </div>
  </div>
</div>
<script>
$(document).ready(function(e) {
	$('body').on('click', '.modal-button', function(e){
		e.preventDefault()
		imgOpt = $(this)
		var url = imgOpt.attr('href')
		$('#iframemodal').find('iframe').attr('src', url).css({width: '100%', height: '475px'})
		$('#iframemodal').modal()
	})
	$('body').on('click', '#iframemodal', function(e){
		var th = $(this)
		th.css({
			width: '100%',
			height: th.contents().height() + 20
		})
	})
});
</script>