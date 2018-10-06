<?php // @version $Id: default_login.php 9830 2008-01-03 01:09:39Z eddieajau $
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div id="content" class="splitbg no-padding">
  <div class="container container-md">
    <div class="cart_c">
      <div class="row gutter-60">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 p-t-80 p-b-100 p-t-xs-30 p-b-xs-30 white-bg">
          <div class="m-b-15">
            <h3 class="text-extra-large text-w-400 pink">Sign In</h3>
          </div>
          <form id="ckform" action="<?php echo JRoute::_( 'index.php', true, $this->params->get('usesecure')); ?>" method="post" name="login" class="login_form frm <?php echo $this->params->get( 'pageclass_sfx' ); ?>">
          <div class="row gutter-15">
            <div class="col-sm-6 col-xs-12">
              <input type="text" class="txtbox no-empty" name="username" id="user" placeholder="Your email" >
            </div>
            <div class="col-sm-6 col-xs-12">
              <input type="password" class="txtbox no-empty" name="passwd" placeholder="Password">
            </div>
            <div class="col-sm-6 col-xs-6 m-b-15">
              <label for="rem" class="checkbox-inline">
                <input type="checkbox" name="remember" class="inputbox" value="yes" id="rem" />
                <?php echo JText::_( 'Remember me' ); ?> </label>
            </div>
            <div class="col-sm-6 col-xs-6 text-right"> <a class="btn btn-link" href="<?php echo JURI::base(); ?>forgot-pass"><?php echo JText::_('Lost Password?'); ?></a> </div>
            <div class="col-xs-12">
              <input type="submit" name="submit" class="btn btn-block btn-primary sendck" value="<?php echo JText::_( 'SIGN IN' ); ?>" />
            </div>
            <div class="col-xs-12 m-t-15 m-b-15 text-center"> ------ or use ------ </div>
            <div class="col-md-6 col-xs-12 m-b-5 "> <a class="btn btn-block btn-social btn-facebook fb-login" ><i class="fa fa-facebook"></i> Sign in with Facebook</a> </div>
            <div class="col-md-6 col-xs-12" id="gConnect">
              <button type="button" id="g-login"
                  data-theme="dark"
                  class="g-signin btn btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i> Sign in with Google</button>
            </div>
            <div class="col-md-8  col-xs-12 m-t-15 m-b-15">
              <p>It's fast and easy. We will never post without your permission - pinky swear!, <a class="text-pink" href="#">Learn more </a> </p>
            </div>
          </div>
          
          <input type="hidden" name="option" value="com_user" />
          <input type="hidden" name="task" value="login" />
          <input type="hidden" name="return" value="<?php echo $this->return; ?>" />
          <?php echo JHTML::_( 'form.token' ); ?>
          </form>

        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-w-500 p-t-80 p-b-100 p-t-xs-0 p-b-xs-30">
          <div class="m-b-15">
            <h3 class="text-extra-large text-w-400 pink">Join</h3>
          </div>
          <p>Doesn't have account yet?, read all about the benefit creating an account <a class="text-pink" href="#">here.</a></p>
          <div class="row gutter-15">
            <div class="col-xs-12"> <a href="<?php echo JURI::base(); ?>user/register" class="btn btn-block btn-primary">Create Account</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
