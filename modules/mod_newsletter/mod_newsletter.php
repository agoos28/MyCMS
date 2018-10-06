<?php
/**
* @package    modtemplate
* @author     agoos28
* @copyright  bebas
* @license    bebas
**/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once (dirname ( __FILE__ ) . "/helper.php");

//require(JModuleHelper::getLayoutPath( 'mod_newsletter' ));

$layout = $params->get('layout', 'default');

$path = JModuleHelper::getLayoutPath('mod_newsletter', $layout);
if (file_exists($path)) {
	require($path);
}

?>