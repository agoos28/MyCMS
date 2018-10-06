<?php // @version $Id: confirm.php  $
defined('_JEXEC') or die('Restricted access');
?>

<script>
$(document).ready(function(e) {
  <?php if(JRequest::getVar('token') && JRequest::getVar('email')){ ?>
	$('#confirm_reset').submit()
	<?php } ?>
});
</script>
<div id="content">
<div class="container">
<form id="confirm_reset" action="index.php?option=com_user&amp;task=confirmreset" method="post" class="josForm form-validate frm">
	<div class="row">
      <div style="margin-bottom: 10px;" class="col-lg-6 col-md-6 col-sm-6">
         <p><?php echo JText::_('RESET_PASSWORD_CONFIRM_DESCRIPTION'); ?></p>
			</div>
	</div>
	<div class="row">
   		<div style="margin-bottom: 10px;" class="col-lg-6 col-md-6 col-sm-6">
        <div class="lbltxt"><?php echo JText::_( 'Token' ); ?><span class="req">*</span></div>
			<input id="token" name="token" type="text" class="required txtbox nd" value="<?php echo JRequest::getVar('token'); ?>"/>
      <input type="hidden" name="email" value="<?php echo JRequest::getVar('email'); ?>" />
		</div>
        <div style="margin-bottom: 10px;" class="col-lg-3 col-md-3 col-sm-3">
        	<div class="lbltxt">&nbsp;</div>
			<button type="submit" class="validate btn" style="line-height: 33px; width: 125px;"><?php echo JText::_('Submit'); ?></button>
		</div>
    </div>
	
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div> 