<?php // @version $Id: default_address.php 9164 2007-10-05 15:58:58Z jinx $
defined('_JEXEC') or die('Restricted access');
$db 	=& JFactory::getDBO();

$query = 'SELECT *' .
	  ' FROM #__content' .
	  ' WHERE id = 23';
$db->setQuery($query);
$row = $db->loadObject();
echo $row->introtext;
?>

