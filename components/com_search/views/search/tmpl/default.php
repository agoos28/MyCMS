<?php // @version $Id: default.php 9837 2008-01-03 16:49:24Z tsai146 $
defined('_JEXEC') or die('Restricted access');
?>



<?php if (!$this->error) :
	echo $this->loadTemplate('results');
else :
	echo $this->loadTemplate('error');
endif; ?>

