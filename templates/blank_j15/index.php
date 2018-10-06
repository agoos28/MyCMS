<?php
defined('_JEXEC') or die('Restricted access');
$curentUrl = JURI::getInstance();
$baseUrl = JURI::base();
$conf   =& JFactory::getConfig();
$sitename   = $conf->getValue('config.sitename');
$user	= JFactory::getUser();
$headerstuff=$this->getHeadData();
reset($headerstuff['styleSheets']);
foreach($headerstuff['styleSheets'] as $key=>$value){
	unset($headerstuff['styleSheets'][$key]);
}
reset($headerstuff['scripts']);
foreach($headerstuff['scripts'] as $key=>$value){
	unset($headerstuff['scripts'][$key]);
}
reset($headerstuff['script']);
foreach($headerstuff['script'] as $key=>$value){
	unset($headerstuff['script'][$key]);
}		
$this->setHeadData($headerstuff);
$this->setGenerator('agoos28');
$this->setMimeEncoding('application/json');
$menu = & JSite::getMenu();
$ishome = false;
if ($menu->getActive() == $menu->getDefault()){
	$ishome = true;
	$jquery = 'jquery.112.js?v=3';
}else{
	$jquery = 'jquery.js?v=3';
}

$content = new stdClass();
$content->data = json_decode($this->getBuffer()['component']['']);
$content->display_message = 'Get '.$this->getTitle().' Successfully';
$content->message = $content->display_message;
$content->status = 200;
echo json_encode($content);
?>