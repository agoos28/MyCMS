<?php
/**
 * @version		$Id: user.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	User
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');


/**
 * User Component User Model
 *
 * @package		Joomla
 * @subpackage	User
 * @since 1.5
 */
class UserModelUser extends JModel
{
	/**
	 * User id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * User data
	 *
	 * @var array
	 */
	var $_data = null;
	var $transaction = null;
	var $tr_total = null;
	var $pageNav = null;
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId($id);
	}

	/**
	 * Method to set the weblink identifier
	 *
	 * @access	public
	 * @param	int Weblink identifier
	 */
	function setId($id)
	{
		// Set weblink id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a user
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the weblink data
		if ($this->_loadData()) {
			//do nothing
		}

		return $this->_data;
	}

	/**
	 * Method to store the user data
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		$user		= JFactory::getUser();
		$username	= $user->get('username');

		// Bind the form fields to the user table
		if (!$user->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$user->save()) {
			$this->setError( $user->getError() );
			return false;
		}

		$session =& JFactory::getSession();
		$session->set('user', $user);

		// check if username has been changed
		if ( $username != $user->get('username') )
		{
			$table = $this->getTable('session', 'JTable');
			$table->load($session->getId());
			$table->username = $user->get('username');
			$table->store();

		}

		return true;
	}
	
	function gLogin($access_token) {	
	
		global $mainframe;
		
		$instance =& JFactory::getUser();
		
		$url = 'https://www.googleapis.com/plus/v1/people/me';			
		
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
		$data = (object) json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get user information');
			
			//echo'<pre>';print_r($data);echo'</pre>';
			$credential = array( 
				'name' => $data->displayName,
				'username' => $data->emails[0]['value'], 
				'email' => $data->emails[0]['value'],
				'gpid' => $data->id
				);
				
		
		$options = array();
		$options['remember'] = JRequest::getBool('remember', true);
		$options['return'] =  JRequest::getVar('return');
		
		//echo'<pre>';print_r($credential);echo'</pre>';die();
		
		$auth = $mainframe->login($credential, $options);
		
		$redirect = base64_decode(JRequest::getVar('return'));

		if($data->emails[0]['value']){
			if($auth){
				$mainframe->redirect($redirect,'Welcome, '.$data->displayName, 'Success');
			}else{
				$mainframe->redirect($redirect,'Error login you in', 'Danger');
			}
		}else{
			$mainframe->redirect($redirect,'Error using G+ login', 'Danger');
		}
			
		return $data;
	}
	
	function fblogin($token = null){
		
		global $mainframe;
		
		$instance =& JFactory::getUser();

		//require_once(JPATH_COMPONENT.DS.'vendor'.DS.'facebook'.DS.'autoload.php' );
		
		/*$fb = new Facebook\Facebook([
			'app_id'                => '312985772505702',
			'app_secret'            => 'a75049f496e43fc7c05a1bf772541ee5',
			'default_graph_version' => 'v2.3',
		]);*/
		
		$session = JFactory::getSession();
		//$helper = $fb->getJavaScriptHelper();
		$redirect = JRequest::getVar('redirect');
		//$helper = $fb->getRedirectLoginHelper();
		
		if(!$token){
			$token = JRequest::getVar('fbtoken');
		}
		
		if(!$token){
			$token = $session->get('fbtoken');
		}
		
		if(!$token){
			$token = $helper->getAccessToken();
		}
		
		if(!$token){
			return false;
		}
		
		$session->set('fbtoken', $token);
		//$fb->setDefaultAccessToken($token);
		
		//get fb user
		//$res = $fb->get('/me/?fields=name,email');

		
		
		$ch = curl_init('https://graph.facebook.com/v2.8/me?access_token='.$token.'&fields=id%2Cname%2Cemail&format=json&method=get&pretty=0&suppress_http_code=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);


		$fbuser = json_decode($json);
		
		$credential = array( 
				'name' => $fbuser->name,
				'username' => $fbuser->email, 
				'email' => $fbuser->email, 
				'fbid' => $fbuser->id
				);
				
		
		$options = array();
		$options['remember'] = JRequest::getBool('remember', true);
		$options['return'] =  JRequest::getVar('return');
		
		$auth = $mainframe->login($credential, $options);
		
		$redirect = base64_decode(JRequest::getVar('return'));

		if($fbuser->email){
			if($auth){
				$mainframe->redirect($redirect,'Welcome, '.$fbuser->name, 'Success');
			}else{
				$mainframe->redirect($redirect,'Error login you in', 'Danger');
			}
		}else{
			$mainframe->redirect($redirect,'Error using fb login', 'Danger');
		}
	}

	/**
	 * Method to load user data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$this->_data =& JFactory::getUser();
			return (boolean) $this->_data;
		}
		return true;
	}
	
	function viewTransaction($id){
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		$query = 	"SELECT a.*, b.*,c.name FROM #__cart_order AS a".
					" LEFT JOIN #__cart_payment AS b ON b.order_id = a.id".
					" LEFT JOIN #__users AS c ON c.id = a.user".
					" WHERE a.id = ".(int)$id;
		$db->setQuery($query);
		$result = $db->loadObject();
		$error = $db->getErrorMsg();
		if($error){
			die($error);
		}
		$this->transaction = $result;
		return $result;
	}
	
	function getTransaction(){
		global $mainframe;
		$user	= JFactory::getUser();
		$userId = $user->get('id');
		$db = JFactory::getDBO();
		
		$lim	= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 14, 'int');
		$lim0	= JRequest::getVar('limitstart', 0, '', 'int');
		
		$query = 	"SELECT a.*, b.* FROM #__cart_order AS a".
					" LEFT JOIN #__cart_payment AS b ON b.order_id = a.id WHERE a.user = ".$userId.
					" GROUP BY a.id ORDER BY a.order_date DESC";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$error = $db->getErrorMsg();
		
		$db->setQuery('SELECT FOUND_ROWS();');  //no reloading the query! Just asking for total without limit
		$this->tr_total = $db->loadResult();
		jimport('joomla.html.pagination');
		$this->pageNav = new JPagination( $db->loadResult(), $lim0, $lim );
		
		if($error){
			die($error);
		}
		$this->transaction = $result;
		return $result;
	}
	
	function getRentedProducts($userid = 0){
		$user	= JFactory::getUser();
		
		if(!$userid){
			$userid = $user->id;
		}
		$db = JFactory::getDBO();
		$query = 	"SELECT b.*, c.title, c.introtext FROM #__cart_order AS a".
							" INNER JOIN #__booking AS b ON b.order_id = a.id".
							" LEFT JOIN #__content AS c ON c.id = b.product_id".
							" WHERE a.user = ".$userid." AND a.status = 'paid'".
							" AND b.pickup >= CURDATE()".
							" ORDER BY b.pickup";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$error = $db->getErrorMsg();
		
		if($error){
			JFactory::getApplication()->enqueueMessage('DB Query ERROR!, '.$error, 'ERROR');
		}
		return $result;
	}
}
?>
