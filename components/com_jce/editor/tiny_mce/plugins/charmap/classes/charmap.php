<?php

/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2017 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('WF_EDITOR') or die('RESTRICTED');

require_once( WF_EDITOR_LIBRARIES . '/classes/plugin.php' );

class WFCharacterMapPlugin extends WFEditorPlugin {

    public function display() {
        parent::display();

        $document = WFDocument::getInstance();

        $document->addScript(array('charmap'), 'plugins');
        $document->addStyleSheet(array('charmap'), 'plugins');
				$document->addStyleSheet(array('font-awesome'), 'plugins');
    }
		
	public function getChar() {
    // Retrieve Fontawesome icons as an array, based on the minimized css file
		
		jimport('joomla.filesystem.file');
 
  	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
     
		$uri = dirname(dirname(__FILE__)) . DS . 'css'. DS .'font-awesome.css';
    $subject = JFile::read( $uri );   
		
		      
     
    preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
    $icons = array();
    
		
		foreach($matches as $match){
			$icons[] = array('&#x'.$match[2], '<span class="fa '.$match[1].'"></span>',  1, str_replace('-', ' ', str_replace('fa','',$match[1])));
		}


		return $icons;
	}
}

?>
