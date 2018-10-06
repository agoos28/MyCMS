<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$return = base64_encode(JURI::base());
?>
<?php if($type == 'logout') : ?>
<form action="index.php" method="post" name="form-login" id="form-login">
  <div class="user-profile border-top padding-horizontal-10 block">
      <div class="inline-block">
          <img src="<?php echo $user->get('propict'); ?>" alt="">
      </div>
      <div class="inline-block">
          <h5 class="no-margin"> Welcome </h5>
          <h4 class="no-margin"> <?php echo $user->get('name'); ?> </h4>
          <a href="<?php echo JURI::base(); ?>?option=com_user&amp;task=logout&amp;return=<?php echo $return; ?>" class="btn user-options sb_toggle" type="submit" title="Logout">
              <i class="fa fa-power-off"></i>
          </a>
      </div>
  </div>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<?php endif; ?>
