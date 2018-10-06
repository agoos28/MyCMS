<?php // @version $Id: default.php 9830 2008-01-03 01:09:39Z eddieajau $
defined('_JEXEC') or die('Restricted access');
$u =& JURI::getInstance();
$b =& JURI::base();
$c = JURI::current();
$tcount = modLoginHelper::getTransactionCount();
$rcount = modLoginHelper::getRentedProducts();
?>
<?php if ($type == 'logout') : ?>

<div class="panel menu_c acc_menu" style="width: 250px;">
  <div class="panel-heading partition-purple">
    <h5><?php echo JText::sprintf('HINAME', $user->get('name')); ?></h5>
  </div>
  <form action="index.php" method="post" name="login" class="log">
    <div class="panel-body no-padding">
      <div class="menu list-group no-margin no-radius type-sm-bl">
        <a class="list-group-item <?php if($c == $b.'transactions'){ echo 'current'; } ?>" href="<?php echo $b; ?>transactions" title="<?php echo JText::_('TRANSACTION_HISTORY'); ?>"> <span class="badge"><?php echo $tcount; ?></span> <span class="fa fa fa-angle-right"></span> <?php echo JText::_('TRANSACTION_HISTORY'); ?></a> 
        <a class="list-group-item <?php if($c == $b.'my-rented-items'){ echo 'current'; } ?>" href="<?php echo $b; ?>my-rented-items" title="My Rented Items"> <span class="badge"><?php echo $rcount; ?></span> <span class="fa fa fa-angle-right"></span> My Rented Items</a>
        <a class="list-group-item <?php if($c == $b.'my-account'){ echo 'current'; } ?>" href="<?php echo $b; ?>my-account" title="<?php echo JText::_('MY_ACCOUNT'); ?>"><span class="fa fa fa-angle-right"></span> <?php echo JText::_('MY_ACCOUNT'); ?></a>
        <?php if($user->usertype == 'Super Administrator'){ ?>
        <a class="list-group-item" target="_blank" href="<?php echo $b; ?>administration" title="<?php echo JText::_('ADMIN_PAGE'); ?>"><span class="fa fa fa-angle-right"></span> <?php echo JText::_('ADMIN_PAGE'); ?></a>
        <?php }else{ ?>
        <a class="list-group-item" href="<?php echo $b; ?>contact" title="<?php echo JText::_('HELP'); ?>"><span class="fa fa fa-angle-right"></span> <?php echo JText::_('HELP'); ?></a>
        <?php } ?>
      </div>
      <input type="hidden" name="option" value="com_user" />
      <input type="hidden" name="task" value="logout" />
      <input type="hidden" name="return" value="<?php echo base64_encode('index.php'); ?>" />
    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-xs-12 text-right">
          <button type="submit" name="Submit" class="btn btn-text btn-xs"><?php echo JText::_('BUTTON_LOGOUT'); ?> <i class="fa fa-power-off"></i> </button>
        </div>
      </div>
    </div>
  </form>
</div>
<?php else : ?>
<div class="panel menu_c acc_menu">
  <form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" class="form-login fancy">
    <div class="panel-heading partition-purple">
      <h4 class="panel-title"><?php echo JText::_('ACCOUNT'); ?></h4>
    </div>
    <div class="panel-body">
    	<p>Have an account? please sign in.</p>
      <div class="form-group">
        <input type="text" name="username" id="mod_login_username" class="form-control" placeholder="<?php echo JText::_('EMAIL'); ?>"  />
      </div>
      <div class="form-group">
        <input type="password" id="mod_login_password" name="passwd" class="form-control" placeholder="<?php echo JText::_('PASSWORD'); ?>"  />
      </div>
      <div class="row">
        <div class=" col-xs-7">
          <label class="checkbox-inline">
            <input type="checkbox" class="chkbox icheckbox_minimal" />
            Remember</label>
        </div>
        <div class=" col-xs-5 text-right"> <a class="btn btn-link" style="text-transform: none;" href="<?php echo $b; ?>forgot-pass" title="Reset password"><?php echo JText::_('FORGOT_LOGIN'); ?></a> </div>
      </div>
      <input type="hidden" name="option" value="com_user" />
      <input type="hidden" name="task" value="login" />
      <input type="hidden" name="return" value="<?php echo base64_encode($u->toString()); ?>" />
      <?php echo JHTML::_( 'form.token' ); ?> </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-12 text-right m-b-10">
          <input type="submit" name="Submit" class="btn btn-block btn-primary" value="Sign In" />
        </div>
        <div class="col-md-12 m-b-5"> <a class="btn btn-block btn-social btn-facebook fb-login"><i class="fa fa-facebook"></i> Sign in with Facebook</a> </div>
        <div class="col-md-12 m-b-5">
          <button type="button" id="g-login"
              data-theme="dark"
						  class="g-signin btn btn-block btn-social btn-google-plus" title=""><i class="fa fa-google-plus"></i> Sign in with Google</button>
        </div>
        <div class="col-md-12 text-right">
        <a class="btn btn-link" style="text-transform: none;" href="<?php echo $b; ?>user/register" title="Create new account using form.">Create New Account <span class="fa fa-angle-right " aria-hidden="true"></span></a>
        </div>
      </div>
    </div>
  </form>
</div>
<?php endif; ?>
