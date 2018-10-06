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
class CCKjSeblodViewCart extends JView
{
	
	function display( $tpl = null )
	{
		// Get Request Vars
		global $mainframe, $option;
		
		$model 		=&	$this->getModel();
		$user 		=&	JFactory::getUser();
		$document	=&	JFactory::getDocument();
		
		$menus		=	&JSite::getMenu();
		$menu 		=	$menus->getActive();
		$view		=	JRequest::getVar('view');
		
		if ( is_object( $menu ) ) {
			$menu_params	=	new JParameter( $menu->params );
			$this->assignRef( 'menu_params', $menu_params );
		}
		
		if(JRequest::getVar('layout') == 'admin' && !JRequest::getVar('invoice')){
			$model->getOrders();
		}
		
		if(JRequest::getVar('invoice')){
			//$model->getOrders();
		}
		
		if($view){
			parent::display();
		}else{
			parent::display($view);
		}
	}
	
}
?>