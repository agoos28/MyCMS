<?php // @version $Id: default.php 9830 2008-01-03 01:09:39Z eddieajau $
defined( '_JEXEC' ) or die( 'Restricted access' );



?>

<div id="content" class="splitbg no-padding">
  <div class="container container-md">
    <div class="cart_c">
      <div class="row gutter-60">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-w-500 p-t-80 p-b-100 p-t-xs-30 p-b-xs-30 pull-right">
          <div class="m-b-15">
            <h3 class="text-extra-large text-w-400 pink">Join with Another Account</h3>
          </div>
          <p> It's fast and easy. We always respect your privacy, we will never post without your permission, <a class="text-blue" href="#">Learn more </a> </p>
          <div class="row">
            <div class="col-xs-12 m-b-10"> <a class="btn btn-block btn-social btn-facebook fb-login" ><i class="fa fa-facebook"></i> Join using Facebook account</a> </div>
            <div class="col-xs-12" id="gConnect">
              <button type="button" id="g-login"
                  data-theme="dark"
                  class="g-signin btn btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i> Join using Google account</button>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 p-t-80 p-b-100 p-t-xs-0 p-b-xs-30 white-bg">
          <div class="m-b-15">
            <h3 class="text-extra-large text-w-400 pink">Create an Account</h3>
          </div>
          <p>Complete form below.</p>
          <div class="alert alert-danger hide">
            <div class="notification"></div>
          </div>
          <form action="<?php echo JRoute::_('index.php?option=com_user#content'); ?>" method="post" id="ckform" name="josForm" class="form-validate user frm">
            <div class="row gutter-15">
            <div class="col-sm-12 col-xs-12">
              <input type="text" name="name" class="txtbox no-empty form-control" placeholder="Your full name">
            </div>
            <div class="col-sm-6 col-xs-12">
              <input type="text" name="phone" class="txtbox no-empty form-control" placeholder="Phone number">
            </div>
            <div class="col-sm-6 col-xs-12">
              <input type="text" name="email" class="txtbox no-empty check-mail form-control" placeholder="Email address">
            </div>
            <div class="col-sm-6 col-xs-12">
              <input type="password" name="password" class="txtbox no-empty form-control" placeholder="Password">
            </div>
            <div class="col-sm-6 col-xs-12">
              <input type="password" name="password2" class="txtbox no-empty form-control" placeholder="Confirm password">
            </div>
            <div class="col-sm-12 col-xs-12 m-b-15">
              <label class="checkbox-inline">
                <input type="checkbox" name="newsletter" value="1" checked="checked" />
                Recieve newsletter </label>
            </div>
            <div class="col-sm-12 col-xs-12"> <a class="btn btn-block btn-primary sendck">Submit Registration</a> </div>
            <input type="hidden" name="task" value="register_save" />
            <input type="hidden" name="id" value="0" />
            <input type="hidden" name="gid" value="0" />
            <?php echo JHTML::_( 'form.token' ); ?>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
