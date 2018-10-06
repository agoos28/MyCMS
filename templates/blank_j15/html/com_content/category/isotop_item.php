<?php // @version $Id: blog_item.php 9718 2007-12-20 22:35:36Z eddieajau $
defined('_JEXEC') or die('Restricted access');
?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<?php if (isset ($this->item->toc)) :
	echo $this->item->toc;
endif; ?>

<?php echo JFilterOutput::ampReplace($this->item->text);  ?>

<?php echo $this->item->event->afterDisplayContent;
