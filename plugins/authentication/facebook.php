<?php
/**
 * @version		$Id: example.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	JFramework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Example Authentication Plugin
 *
 * @package		Joomla
 * @subpackage	JFramework
 * @since 1.5
 */
class plgAuthenticationFacebook extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param	object	$subject	The object to observe
	 * @param	array	$config		An array that holds the plugin configuration
	 * @since	1.5
	 */
	function plgAuthenticationFacebook(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param	array	$credentials	Array holding the user credentials
	 * @param	array	$options		Array of extra options
	 * @param	object	$response		Authentication response object
	 * @return	boolean
	 * @since	1.5
	 */
	function onAuthenticate( $credentials, $options, &$response )
	{
		
		/*
		 * Here you would do whatever you need for an authentication routine with the credentials
		 *
		 * In this example the mixed variable $return would be set to false
		 * if the authentication routine fails or an integer userid of the authenticated
		 * user if the routine passes
		 */
		$db = JFactory::getDBO();
		
		if($credentials['fbid'] || $credentials['gpid']){
			$query = "SELECT id, fbid, gpid "
				. " FROM #__users"
				. " WHERE email = '".$credentials['email']."'";
		}else{
			$response->status = JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message = 'For login with facebook or G+ only';
			return false;
		}
		
		
		
		
			$db->setQuery( $query );
			$result = $db->loadObject();
			
			 
			
			if(!$result->id){//create new user
				if($this->saveUser($credentials)){
					$response->status			= JAUTHENTICATE_STATUS_SUCCESS;
					$response->error_message	= '';
				}else{
					$response->status = JAUTHENTICATE_STATUS_FAILURE;
					$response->error_message = 'User creation error';
					return false;
				}
			}else{
				$user = JUser::getInstance($result->id);
				$response->username = $user->username;
					$response->email = $user->email;
					$response->fullname = $user->name;
					$response->status = JAUTHENTICATE_STATUS_SUCCESS;
					$response->error_message = '';
			}
	}
	
	function saveUser($credentials)
	{
		global $mainframe;
		
		$credentials = (object) $credentials;
		
		$instance =& JFactory::getUser();
		
		jimport( 'joomla.user.helper' );
		jimport('joomla.application.component.helper');
		$config   = &JComponentHelper::getParams( 'com_users' );
		$usertype = $config->get( 'new_usertype', 'Registered' );
		
		$acl =& JFactory::getACL();
		
		$salt  = JUserHelper::genRandomPassword(32);
		if($credentials->fbid){
			$crypt = JUserHelper::getCryptedPassword($credentials->fbid, $salt);
			$instance->set( 'fbid'				, $credentials->fbid );
		}
		if($credentials->gpid){
			$crypt = JUserHelper::getCryptedPassword($credentials->gpid, $salt);
			$instance->set( 'gpid'				, $credentials->gpid );
		}
		$password = $crypt.':'.$salt;
		
		
		$instance->set( 'id'					, 0 );
		$instance->set( 'name'				, $credentials->name );
		$instance->set( 'username'		, $credentials->email );
		$instance->set( 'password'		, $password );
		$instance->set( 'email'				, $credentials->email );	// Result should contain an email (check)
		$instance->set( 'gid'					, $acl->get_group_id( '', $usertype));
		$instance->set( 'usertype'		, $usertype );
		
		
		if(!$instance->save()) {
			return false;
		}else{
			return true;
		}
		
	}
}
