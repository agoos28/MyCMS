<?php // @version $Id: default_login.php 9830 2008-01-03 01:09:39Z eddieajau $
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div id="content">
<div class="container">
<form action="<?php echo JRoute::_( 'index.php', true, $this->params->get('usesecure')); ?>" method="post" name="login" id="login" class="login_form frm <?php echo $this->params->get( 'pageclass_sfx' ); ?>">

        <div class="row">
        	<?php if ($this->params->get('description_login')) : ?>
			<div style="margin-bottom: 10px;" class="col-lg-12 col-md-12 col-sm-12">
				<div class="lbltxt"><?php echo $this->params->get('description_login_text'); ?></div>
			</div>
			<?php endif; ?>
        </div>
    	<div class="row">
            <div style="margin-bottom: 10px;" class="col-lg-3 col-md-3 col-sm-12">
                <div class="lbltxt"><?php echo JText::_( 'Username' ); ?><span class="req">*</span></div>
                <input type="text" class="txtbox nd" name="username" id="user" >
            </div>
            <div style="margin-bottom: 10px;" class="col-lg-3 col-md-3 col-sm-12">
                <div class="lbltxt"><?php echo JText::_( 'Password' ); ?><span class="req">*</span></div>
                <input type="password" class="txtbox nd num" name="passwd">
            </div>
            <div style="margin-bottom: 10px;" class="col-lg-3 col-md-3 col-sm-12">
            	<div class="lbltxt">&nbsp;</div>
            	<input type="submit" name="submit" class="btn" style="line-height: 33px; width: 125px;" value="<?php echo JText::_( 'Login' ); ?>" />
            </div>
        </div>
		<div class="row">
        	<div style="margin-bottom: 10px;" class="col-lg-3 col-md-3 col-sm-12">
            	<label for="rem"><?php echo JText::_( 'Remember me' ); ?></label>
				<input type="checkbox" name="remember" class="inputbox" value="yes" id="rem" />
            </div>
            <div style="margin-bottom: 10px;" class="col-lg-3 col-md-3 col-sm-12">
            	<a href="<?php echo JURI::base(); ?>forgot-pass">
			<?php echo JText::_('Lost Password?'); ?></a>
            </div>
        </div>
	<noscript><?php echo JText::_( 'WARNJAVASCRIPT' ); ?></noscript>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="return" value="<?php echo $this->return; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div>