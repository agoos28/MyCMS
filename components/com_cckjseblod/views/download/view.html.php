<?php
/**
* @version 			1.9.0
* @author       	http://www.seblod.com
* @copyright		Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
* @package			SEBLOD 1.x (CCK for Joomla!)
**/

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Article			View Class
 **/
class CCKjSeblodViewDownload extends JView
{
	function decrypt($string = null) {
		$cryptKey  = 'apei';
		$qDecoded  =  base64_decode( $string );
		return $qDecoded ;
	}
	/**
	 * Display Default View
	 **/
	function display( $tpl = null )
	{
		// Get Request Vars
		global $mainframe, $option;
		$user 		=&	JFactory::getUser();
		$file = $this->decrypt(JRequest::getVar('file'));
		$ajax = JRequest::getVar('ajax');
		$filename = basename($file);
		
		if ( !$user->id ) {
			$mainframe->redirect( 'index.php', JText::_( 'CONTENT TYPE NOTAUTH' ), "error" );
		} else {
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Pragma: public");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			
			readfile($file);
			exit();
		}
		
		
	}
	
}
?>
