<?php // @version $Id: default.php  $
defined('_JEXEC') or die('Restricted access');
?>


<div id="content">
<div class="container">
<form id="ckform" action="<?php echo JURI::current(); ?>?task=requestreset" method="post" class="form-validate frm">
	<div class="alert alert-danger hide">
    <div class="notification"></div>
  </div>
	<div class="row">
            <div style="margin-bottom: 10px;" class="col-lg-6 col-md-6 col-sm-12">
                <p><?php echo JText::_('RESET_PASSWORD_REQUEST_DESCRIPTION'); ?></p>
			</div>
	</div>
	<div class="row">
   		<div style="margin-bottom: 10px;" class="col-lg-6 col-md-6 col-sm-6">
        <div class="lbltxt"><?php echo JText::_( 'Email' ); ?><span class="req">*</span></div>
			<input id="email" name="email" type="text" class="txtbox no-empty check-mail" placeholder="Your email address"/> <br />
      <button type="submit" class="btn btn-lg btn-dark-red rounded submitck"><?php echo JText::_('Submit'); ?></button>
		</div>
        <div style="margin-bottom: 10px;" class="col-lg-3 col-md-3 col-sm-3">
        	<div class="lbltxt">&nbsp;</div>
			
		</div>
    </div>
	
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div>