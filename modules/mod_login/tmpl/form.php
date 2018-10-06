<?php // @version $Id: default.php 9830 2008-01-03 01:09:39Z eddieajau $
defined('_JEXEC') or die('Restricted access');
$u =& JURI::getInstance();
$b =& JURI::base();
?>
<?php if ($type == 'logout') : ?>
<?php else : ?>


    <form id="login-form" action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" class="form-login" style="display: none;">
      <div class="m-b-15">
        <h3 class="text-extra-large text-w-400 pink">Customer information</h3>
      </div>
      <div class="form-group">
        <input type="text" name="username" id="mod_login_username" class="txtbox" placeholder="Your registered email"  />
      </div>
      <div class="form-group">
        <input type="password" id="mod_login_password" name="passwd" class="txtbox" placeholder="<?php echo JText::_('PASSWORD'); ?>"  />
      </div>
      <div class="row">
        <div class=" col-xs-7">
          <label class="checkbox-inline">
            <input type="checkbox" class="chkbox icheckbox_minimal" />
            Remember me</label>
        </div>
        <div class=" col-xs-5 text-right"> <a class="btn btn-link" href="<?php echo $b; ?>forgot-pass" title="Reset password"><?php echo JText::_('FORGOT_LOGIN'); ?></a> </div>
      </div>
      <input type="hidden" name="option" value="com_user" />
      <input type="hidden" name="task" value="login" />
      <input type="hidden" name="return" value="<?php echo base64_encode($u->toString()); ?>" />
      <?php echo JHTML::_( 'form.token' ); ?>
      <div class="row">
        <div class="col-xs-12 text-right m-b-10">
          <input type="submit" name="Submit" class="btn btn-block btn-light-green" value="<?php echo JText::_('BUTTON_LOGIN'); ?>" />
        </div>
      </div>
    </form>

<?php endif; ?>
