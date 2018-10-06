<?php // @version $Id: default.php 9718 2007-12-20 22:35:36Z eddieajau $
defined('_JEXEC') or die('Restricted access');
$cparams = JComponentHelper::getParams ('com_media');
$messages = JApplication::getMessageQueue();
$user = JFactory::getUser();
$model		= &$this->getModel();
if($messages){
	foreach($messages as $message){
		if($message['type'] == 'message'){
			$notif = $message['message'];
		}
	}
}
$content = $model->getRawContent('501');

$form = $this->loadTemplate('form');
?>
<div id="content">
<div class="container">
		<div style="position: relative;">
		<?php
		if($user->usertype == 'Super Administrator'){
			echo '<a class="btn btn-xs btn-red btn-edit" href="'.JURI::base().'component/cckjseblod/?view=type&layout=form&typeid=30&cckid=501">edit</a>';
		}
		?>
    </div>
		<div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-9 m-t-20">
        <?php echo $content->ct_subtitle; ?>
      </div>
    </div>
    <?php if ($this->contact->params->get('show_email_form')) :
        echo $this->loadTemplate('form');
    endif; ?>
    <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-9 m-t-20">
      	<?php echo $content->ct_text; ?>
      </div>
    </div>
</div>
</div>
