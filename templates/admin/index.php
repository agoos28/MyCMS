<?php

$document	=& JFactory::getDocument();
$user		=& JFactory::getUser();
if(!$user->id){
	include dirname(__FILE__).DIRECTORY_SEPARATOR.'noouth.php';
}else if($user->usertype == 'Super Administrator'){
	include dirname(__FILE__).DIRECTORY_SEPARATOR.'outh.php';
}else{
	JFactory::getApplication()->redirect(JURI::base(),'Admin only!', 'warning');
}
