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

jimport('joomla.application.component.model');

/**
 * Article		Model Class
 **/
class CCKjSeblodModelNewsletter extends JModel
{
	/**
	 * Vars
	 **/
	var $_data		=	null;
	var $_pagination = null;
	var $_total = null;
	/**
	 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		$mainframe = JFactory::getApplication();
		$user		=&	JFactory::getUser();
		
		$userId		=	$user->get('id');
		$userGId	=	$user->get('gid');
		$this->setValues( $userId, $userGId );
		$this->_request = (object)JRequest::get('default');
		$this->_request->email_content = JRequest::getVar('email_content', '', 'post', 'string', JREQUEST_ALLOWRAW);
		
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
	 
		// In case limit has been changed, adjust it
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	 
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		
		
		if($this->_request->task == 'send_newsletter'){
			
			if($this->_request->save){
				$this->saveHistory();
			}
			if($this->_request->test){
				$this->sendtest();
			}else{
				$this->sendNewsletter();
			}
			
		}
		
		if($this->_request->task == 'delete'){
			$cids = $this->_request->cid;
			for($i=0; $i < count($cids); $i++){
				$this->delete($cids[$i]);
			}
			
		}
		
		if($this->_request->layout == 'unsubscribe'){
			$this->unsubscribe($this->_request->secret);
		}
		
		
	}

	/**
	 * Set Values
	 **/
	function setValues( $userId, $userGId )
	{
		// Set Values
		$this->_data	=	null;
		$this->_userId	=	$userId;
		
		$this->_userGId	=	$userGId;
	}
	
	/**
	 * Get Data from Database
	 **/
	function &getData()
	{
		if ( empty( $this->_data ) )
		{
			global $mainframe;
			$params	=&	$mainframe->getParams();
				
			//if ( $params->get( 'category_id', 0 ) ) {
			$all_authors		=	$params->get( 'enable_all_authors', 0 );
			$all_authors_access	=	$params->get( 'enable_all_authors_access', 18 );
			if ( $this->_userId && ( ! $all_authors || ( $all_authors && $all_authors_access && $this->_userGId >= $all_authors_access ) ) ) {
				global $mainframe;
				
				$orderby = JRequest::getVar('order', 'full_name');
				
				$query	= 'SELECT a.*, a.full_name AS name, b.id AS userid, b.name'
						. ' FROM #__newsletter AS a LEFT JOIN #__users AS b ON b.email = a.email ORDER BY a.email ASC'
						//. $where
						//. $orderby 
						;
				//$this->_db->setQuery( $query );
				//$this->_data	=	$this->_db->loadObjectList();
				$this->_data	=   $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
				
				
			}
		}
		
		return $this->_data;
	}
	
	/**
	 * Get Data from Database
	 **/
	
	function getTotal()
	{
	  // Load the content if it doesn't already exist
	  $query	= 'SELECT *'
				. ' FROM #__newsletter';
	  $this->_total   =   $this->_getListCount($query);
	  return $this->_total;
	}
	
	/**
	 * Get Data from Database
	 **/
	
		
	/**
	 * Publish / Unpublish
	 **/
	function publish( $cid = array(), $publish = 1 )
	{
		global $mainframe;
		
		if ( count( $cid ) ) {
			JArrayHelper::toInteger( $cid );
			$cids	=	implode( ',', $cid );
				
			$query	= 'UPDATE #__content'
					. ' SET state = '.(int)$publish
					. ' WHERE id IN ( '.$cids.' )'
					;
			$this->_db->setQuery( $query );
			if ( ! $this->_db->query() ) {
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Delete
	 **/
	function trash()
	{
		global $mainframe;
		JTable::addIncludePath( JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'database'.DS.'table' );
				
		$cids	=	JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row	=&	JTable::getInstance( 'content', 'JTable' );
		
		if ( $n = count( $cids ) )
		{
			foreach($cids as $cid) {
				if ( ! $row->delete( $cid ) ) {
					$this->setError( $this->_db->getErrorMsg() );
					return false;
				}
			}						
		}
		
		return $n;
	}
	
	function unsubscribe($secret){
		$query = "DELETE FROM #__newsletter WHERE secret = '".$secret."'";
		$this->_db->setQuery($query);
		$this->_db->query();
		$error = $this->_db->getErrorMsg();
		if($error){
			$this->_errors[] = $error;
			return false;
		}else{
			echo 'You have unsubsribe, Thankyou'; die();
		}
	}
	
	function merge_template($email = null, $var = array())
	{
		$secret = strtr(base64_encode($email), '+/=', '-_,');
		//$html = str_replace(
		//$html = '<html>'.str_replace('"images/','"'.JURI::base().'images/',$html).'<html>'
		$var['{unsubscribe}'] = '<a href="'.JURI::base().'newsletter?task=unsubscribe&secret='.$secret.'">Unsubscribe</a>' ;
		$content = str_replace('"images/','"'.JURI::base().'images/',$this->_request->email_content);
		return strtr('<html>'.$_POST['customhead'].'<body class="full-padding" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;">'.$content.'</body></html>', $var);
	}
	
	function getHistory($id = null)
    {
		if($id == null){
			return false;
		}
		$query = "SELECT * FROM #__newsletter_history WHERE id = ".$id;
		$this->_db->setQuery($query);
		$result =$this->_db->loadObject();
		$error = $this->_db->getErrorMsg();
		
		if($error){
			$this->_errors[] = $error;
			return false;
		}else{
			return $result;
		}
    }
	
	function saveHistory(){
		$subject = JRequest::getVar('subject');
		$content =  $this->_request->email_content;
		if($this->_request->templateid){
			$query = "UPDATE #__newsletter_history SET subject = '$subject', content = '$content' WHERE id=".(int)$this->_request->templateid;
		}else{
			$query = "INSERT INTO #__newsletter_template (subject,content)
        		  VALUES ('".$subject."','".$content."')";
		}
		$this->_db->setQuery($query);
		$this->_db->query();
		
		$insertid = $this->_db->insertid();
		$error = $this->_db->getErrorMsg();
		
		if($error){
			$this->_errors[] = $error;
			JFactory::getApplication()->enqueueMessage($error, 'ERROR');
			return false;
		}else{
			return $insertid;
		}
	}
	
	function sendNewsletter()
	{
		global $mainframe;
		jimport( 'joomla.error.log' );
		
		$from = $mainframe->getCfg('mailfrom');
		$replyto = $mainframe->getCfg('mailfrom');
		
		$logfile = 'newsletter_'.time().'.txt';
		$log = JLog::getInstance($logfile,'',JPATH_BASE.DS.'logs');
		
		$subscribers = $this->getData();
		
		jimport('joomla.filesystem.file');
		$cssuri = JPATH_BASE.DS.'templates'.DS.'blank_j15'.DS.'css'.DS.'email.css';
		if(JFile::exists($cssuri)){
			$emailcss = JFile::read($cssuri);
		}
		$css = '<style type="text/css">'.$emailcss.'</style>';
		
		$html = $this->_request->email_content;
		$html = str_replace('img src="images','img src="'.JURI::base().'images',$html);
		$html = str_replace('url(\'images/','url(\''.JURI::base().'images/',$html);
		
		
		for($i = 0; $i < count($subscribers); $i++){
			$subscriber = $subscribers[$i];
			
			$var = array(
				'{name}' => $subscriber->name,
				'{unsubscribe}' => '<a href="'.JURI::base().'unsubscribe?secret='.$subscriber->secret.'">Unsubscribe</a>',
			);
			
			$html = strtr($html, $var);
			$html = '<html><body>'.$css.$html.'</body></html>';
			$subject = strtr($this->_request->subject, $var);
			
			$status = $this->sendEmail($subscriber->email,$from,$html,$subject);

			$log->addEntry(array('LEVEL' => 'Send test email : '.$this->_request->subject, 'STATUS' => 'Status : '. $status, 'COMMENT' => 'To: '.$subscriber->email ));
		}
		$log->_closeLog(); 
		$this->_errors[] = 'See log file ('.$logfile.') to view sending report';
	}
	
	function sendtest(){
		global $mainframe;
		jimport( 'joomla.error.log' );
		
		$from = $mainframe->getCfg('mailfrom');
		$replyto = $mainframe->getCfg('mailfrom');
		
		$logfile = 'newsletter_'.time().'.txt';
		$log = JLog::getInstance($logfile,'',JPATH_BASE.DS.'logs');
		
		$subscribers = $this->getData();
		
		jimport('joomla.filesystem.file');
		$cssuri = JPATH_BASE.DS.'templates'.DS.'blank_j15'.DS.'css'.DS.'email.css';
		if(JFile::exists($cssuri)){
			$emailcss = JFile::read($cssuri);
		}
		$css = '<style type="text/css">'.$emailcss.'</style>';
		
		
		
		$html = $this->_request->email_content;
		
		
		$html = str_replace('img src="images','img src="'.JURI::base().'images',$html);
		$html = str_replace('url(\'images/','url(\''.JURI::base().'images/',$html);
		
		
		$var = array(
			'{name}' => 'User Name',
			'{unsubscribe}' => '<a href="'.JURI::base().'unsubscribe?secret=xxxxxxx">Unsubscribe</a>',
		);
		
		$html = strtr($html, $var);
		$html = '<html><body>'.$css.$html.'</body></html>';
		
		
		$subject = strtr($this->_request->subject, $var);
		
		$status = $this->sendEmail($this->_request->testmail,$from,$html,$subject);
		
		
	
		$log->addEntry(array('LEVEL' => 'Send test email : '.$this->_request->subject, 'STATUS' => 'Status : '. $status, 'COMMENT' => 'To: '.$this->_request->testmail ));
		$log->_closeLog(); 
		
		JFactory::getApplication()->enqueueMessage('See logfile - <a target="_blank" href="'.JURI::base().'logs/'.$logfile.'">'.$logfile.'</a> to view sending report', 'Info');
	}
	
	
	function sendEmail($to,$from,$content,$subject)
	{
		global $mainframe;
		$from = $mainframe->getCfg('mailfrom');
		$replyto = $mainframe->getCfg('mailfrom');
		
		$mail =& JFactory::getMailer();
		$mail->isHTML(true);

		$mail->setBody($content); 
		$mail->addReplyTo(array($replyto));
		$mail->setSender($from);
		$mail->setSubject($mainframe->getCfg('sitename').' - '.$subject);
		$mail->addRecipient($to);
		//$mail->setAltBody($content);
	
		if(!$mail->Send()){
			return 'error';
		}else{
			return 'success';
		}
	}
	
	function getPagination()
	{
	  // Load the content if it doesn't already exist
	  if (empty($this->_pagination)) {
		  jimport('joomla.html.pagination');
		  $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		  //print_r($this->getTotal());die();
	  }
	  //print_r($this->_pagination);die();
	  return $this->_pagination;
	}
}
?>