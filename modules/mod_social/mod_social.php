<?php
/**
* @package    modtemplate
* @author     agoos28
* @copyright  bebas
* @license    bebas
**/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$modulepath = dirname ( __FILE__ );
require_once ($modulepath . "/simple_html_dom.php");
require_once ($modulepath . "/helper.php");

jimport('joomla.filesystem.file');
require(JModuleHelper::getLayoutPath( 'mod_social' ));

?>