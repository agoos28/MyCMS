<?php // @version $Id: default.php 9836 2008-01-03 16:41:32Z tsai146 $
defined('_JEXEC') or die('Restricted access');
?>

    <?php echo $this->article->event->beforeDisplayContent; ?>
    <?php if (isset ($this->article->toc)) :
        echo $this->article->toc;
    endif; ?>
    <?php echo JFilterOutput::ampReplace($this->article->text); ?>
    <?php echo $this->article->event->afterDisplayContent; ?>
