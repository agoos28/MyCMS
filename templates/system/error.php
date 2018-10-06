<?php
/**
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
if (!isset($this->error)) {
	$this->error = JError::raiseWarning( 403, JText::_('ALERTNOTAUTH') );
	$this->debug = false; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->code ?></title>
	<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/blank_j15/css/master.css?ver=3" />
</head>
<body class="err-page" style="height: 100%;">

	<div class="text-center">
    	
    	<img class="logo" src="<?php echo JURI::base(); ?>images/logo.png" />
      <div class="code"><?php echo $this->error->code ?></div>
        <div class="info">
        	<h3><?php echo $this->error->message; ?></h3>
          <p></p>
          <a class="btn btn-red btn-lg btn-rounded" href="<?php echo JURI::base(); ?>">go to front page</a>.</div>
    </div>
</body>
</html>
