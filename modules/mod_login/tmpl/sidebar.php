<?php // @version $Id: default.php 9830 2008-01-03 01:09:39Z eddieajau $
defined( '_JEXEC' )or die( 'Restricted access' );
$u = & JURI::getInstance();
$b = & JURI::base();
$c = JURI::current();
$tcount = modLoginHelper::getTransactionCount();
$rcount = modLoginHelper::getRentedProducts();


if ( $type == 'logout' ): ?>

<form action="index.php" method="post" name="login" class="log">

	<ul class="menu list-group">
		<div class="list-group-item partition-purple">
			<h5>Account</h5>
		</div>
		<a class="list-group-item <?php if($c == $b.'transactions'){ echo 'current'; } ?>" href="<?php echo $b; ?>transactions" title="<?php echo JText::_('TRANSACTION_HISTORY'); ?>"> <span class="badge"><?php echo $tcount; ?></span> <span class="fa fa fa-angle-right"></span> <?php echo JText::_('TRANSACTION_HISTORY'); ?></a>
		<a class="list-group-item <?php if($c == $b.'my-rented-items'){ echo 'current'; } ?>" href="<?php echo $b; ?>my-rented-items" title="My Rented Items"> <span class="badge"><?php echo $rcount; ?></span> <span class="fa fa fa-angle-right"></span> My Rented Items</a>
		<a class="list-group-item <?php if($c == $b.'my-account'){ echo 'current'; } ?>" href="<?php echo $b; ?>my-account" title="<?php echo JText::_('MY_ACCOUNT'); ?>"><span class="fa fa fa-angle-right"></span> <?php echo JText::_('MY_ACCOUNT'); ?></a>
		<?php if($user->usertype == 'Super Administrator'){ ?>
		<a class="list-group-item" target="_blank" href="<?php echo $b; ?>administration" title="<?php echo JText::_('ADMIN_PAGE'); ?>"><span class="fa fa fa-angle-right"></span> Admin Page</a>
		<?php }else{ ?>
		<a class="list-group-item" href="<?php echo $b; ?>contact" title="<?php echo JText::_('HELP'); ?>"><span class="fa fa fa-angle-right"></span> <?php echo JText::_('HELP'); ?></a>
		<?php } ?>
		<div class="list-group-item text-right">
			<button type="submit" name="Submit" class="btn btn-dark btn-xs">
				<?php echo JText::_('BUTTON_LOGOUT'); ?> <i class="fa fa-power-off"></i> </button>
		</div>
	</ul>
	<input type="hidden" name="option" value="com_user"/>
	<input type="hidden" name="task" value="logout"/>
	<input type="hidden" name="return" value="<?php echo base64_encode('index.php'); ?>"/>

</form>

<?php else :?>
	<div class="menu list-group">
		<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" class="form-login fancy">
			<div class="list-group-item partition-purple text-uppercase">
				<h5>
					<?php echo JText::_('LOGIN'); ?>
				</h5>
			</div>
			<div class="list-group-item">
				<div class="form-group">
					<input type="text" name="username" id="mod_login_username" class="form-control" placeholder="<?php echo JText::_('EMAIL'); ?>"/>
				</div>
				<div class="form-group">
					<input type="password" id="mod_login_password" name="passwd" class="form-control" placeholder="<?php echo JText::_('PASSWORD'); ?>"/>
				</div>
				<div class="row">
					<div class=" col-xs-7">
						<label class="checkbox-inline">
          <input type="checkbox" class="chkbox icheckbox_minimal" />
          Remember me</label>
					
					</div>
					<div class=" col-xs-5 text-right">
						<a class="btn btn-link" href="<?php echo $b; ?>forgot-pass" title="Reset password">
							<?php echo JText::_('FORGOT_LOGIN'); ?>
						</a>
					</div>
				</div>
				<input type="hidden" name="option" value="com_user"/>
				<input type="hidden" name="task" value="login"/>
				<input type="hidden" name="return" value="<?php echo base64_encode($u->toString()); ?>"/>
				<?php echo JHTML::_( 'form.token' ); ?>

				<div class="row">
					<div class="col-xs-12 text-right m-b-15">
						<input type="submit" name="Submit" class="btn btn-block btn-green" value="<?php echo JText::_('BUTTON_LOGIN'); ?>"/>
					</div>
					<div class="col-md-12 m-b-5">
						<a class="btn btn-block btn-social btn-facebook fb-login"><i class="fa fa-facebook"></i> Sign in with Facebook</a>
					</div>
					<div class="col-md-12" id="gConnect">
						<button type="button" id="g-login" data-scope="email" data-clientid="613694771360-da8e01tph5nshkava5s4j2kl79fn3261.apps.googleusercontent.com" data-callback="onSignInCallback" data-theme="dark" data-cookiepolicy="single_host_origin" class="g-signin btn btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i> Sign in with Google</button>
					</div>
				</div>
			</div>
		</form>
	</div> 
<?php endif;?>