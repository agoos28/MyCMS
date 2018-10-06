<?php // @version $Id: default_form.php 9830 2008-01-03 01:09:39Z eddieajau $
defined('_JEXEC') or die('Restricted access');
$user	= JFactory::getUser();
?>

<div class="frm">
  <div class="row">
  	<div class="col-sm-9 col-xs-12 pull-right">
      <div class="alert alert-danger hide">
        <div class="notification"></div>
      </div>
    </div>
  </div>
  <form action="<?php echo JURI::current(); ?>" class="form-validate" method="post" name="emailForm" id="ckform">
    <div class="row">
      <div class="form-group">
        <label for="name" class="col-sm-3 text-right m-t-10">Nama Lengkap*</label>
        <div class="col-sm-9">
          <input name="name" class="form-control txtbox no-empty" id="name" value="<?php echo $user->name; ?>" required="" type="text" placeholder="Your full name">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <label for="email" class="col-sm-3 text-right m-t-10">Email*</label>
        <div class="col-sm-9">
          <input name="email" class="form-control txtbox no-empty" id="email" value="<?php echo $user->email; ?>" required="" type="text" placeholder="Your email address">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <label for="phone" class="col-sm-3 text-right m-t-10">Telepon / Handphone*</label>
        <div class="col-sm-9">
          <input name="phone" class="form-control txtbox no-empty" id="phone" value="<?php echo $user->phone; ?>" required="" type="text" placeholder="Your phone number">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <label for="subject" class="col-sm-3 text-right m-t-10">Subject*</label>
        <div class="col-sm-9">
          <input name="subject" class="form-control txtbox no-empty" id="subject" value="" required="" type="text" placeholder="Message subject">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <label for="text" class="col-sm-3 text-right m-t-10">Pesan*</label>
        <div class="col-sm-9">
          <textarea id="text" name="text" class="form-control txtbox no-empty" rows="8" cols="80" placeholder="Type your message"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-2">
          <button class="btn btn-lg btn-red btn-block text-small padding-10 sendck" type="submit">Kirim</button>
        </div>
      </div>
    </div>
    <input type="hidden" name="view" value="contact" />
    <input type="hidden" name="id" value="<?php echo $this->contact->id; ?>" />
    <input type="hidden" name="task" value="submit" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
