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

// On Prepare Submission (Article)
$dispatcher	=&	JDispatcher::getInstance();
JPluginHelper::importPlugin( 'content' );
$isNew	=	( $cckId < 1 );

$jcontent			=	JRequest::getVar( 'jcontent', array(), 'post', 'array');
$jcontentdetails	=	JRequest::getVar( 'jcontentdetails', array(), 'post', 'array');
$jcontentparams		=	JRequest::getVar( 'jcontentparams', array(), 'post', 'array');
$jcontentmeta		=	JRequest::getVar( 'jcontentmeta', array(), 'post', 'array');

if ( @$jcontentdetails['created'] ) {
	$jcontentdetails['created']  = date('Y-m-d', strtotime($jcontentdetails['created']));
}
if ( @$jcontentdetails['modified'] ) {
	$jcontentdetails['modified']  = date('Y-m-d', strtotime($jcontentdetails['modified']));
}
if ( @$jcontentdetails['publish_up'] ) {
	$jcontentdetails['publish_up']  = date('Y-m-d', strtotime($jcontentdetails['publish_up']));
}
if ( @$jcontentdetails['publish_down'] ) {
	$jcontentdetails['publish_down']  = date('Y-m-d', strtotime($jcontentdetails['publish_down']));
}
//
$form['catid']	=	( $textObj->save && $textObj->save != 0 ) ? $textObj->save : $form['catid'];
//

/**
 * On Prepare Submission (Article)
 **/
$datenew	=&	JFactory::getDate();
$unixTime	=	$datenew->toUnix();
$second		=	date('s');
$modifdate	=	date('Y-m-d H:i:'.$second, $unixTime);
$second		=	$second - 2;
$createdate =	date('Y-m-d H:i:'.$second, $unixTime);

$datenow	=&	JFactory::getDate();

$row		=&	JTable::getInstance( 'content' );
$row->id	=	$cckId;

if ( $row->id ) {
	$rowStored	=&	JTable::getInstance( 'content', 'JTable' );
	$rowStored->load( $row->id );
	if ( $form['override'] ) {
		$stateByUser	=	$rowStored->state;
	}
	$row->modified	=	$datenow->toFormat( "%Y-%m-%d %H:%M:%S" );
}

$title 	=	@$jcontent['title'];
// Substitute!
if ( sizeof( $textObj->substitute ) ) {
	$title	=	'';
	foreach( $textObj->substitute as $sub ) {
		$sub	=	trim( $sub );
		if ( $sub ) {
			if (strpos( $sub, '[created_date]' ) !== false ) {
				$sub	=	str_replace( '[created_date]', '', $sub );
				$title .=	( $row->id ) ? date( $sub, strtotime($rowStored->created) ).' ' : date( $sub, strtotime($createdate) ).' ';
			} else if (strpos( $sub, '[modified_date]' ) !== false ) {
				$sub	=	str_replace( '[modified_date]', '', $sub );
				$title	.=	( $row->id ) ? date( $sub, strtotime($modifdate) ).' ' : date( $sub, strtotime($createdate) ).' ';
			} else {
				$title	.=	$sub.' ';
			}
		}
	}
	$title	=	trim( $title );
}
if ( $title ) {
	if( empty( $jcontent['alias'] ) ) {
		$jcontent['alias']	=	$title;
	}
	$jcontent['alias'] = JFilterOutput::stringURLSafe( $jcontent['alias'] );
	
	if(trim(str_replace('-','',$jcontent['alias'])) == '') {
		$datenow =& JFactory::getDate();
		$jcontent['alias'] = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
	}
}
//

$textObj->text = str_replace( '<br>', '<br />', $textObj->text );
$pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
$tagPos	= preg_match( $pattern, $textObj->text );
if ( $tagPos == 0 )	{
	$row->introtext	= $textObj->text;
	$row->fulltext = '';
} else 	{
	list( $row->introtext, $row->fulltext ) = preg_split( $pattern, $textObj->text, 2 );
}

$row->bind( $form );
if ( $form['catid'] ) {
	$catid	=	$form['catid'];
	if ( $jcontent['catid'] && ! $jcontent['sectionid'] ) {
		$catid	=	$jcontent['catid'];
	}
	$row->sectionid	=	HelperjSeblod_Helper::getJoomlaSectionId( $catid );
}

$row->bind( $jcontent );

if ( $title ) {
	$row->title	=	$title;
}
if ( ! $row->title ) {
	$row->title	=	$datenow->toFormat( "%Y %m %d %H %M %S" );
}
if ( ! $row->alias ) {
	if ( @$rowStored->alias ) {
		$row->alias	=	$rowStored->alias;
	} else {
		$row->alias = JFilterOutput::stringURLSafe( $row->title );
		if( trim( str_replace( '-', '', $row->alias ) ) == '' ) {
			$row->alias = $datenow->toFormat( "%Y-%m-%d-%H-%M-%S" );
		}
	}
}
if ( $actionMode == 2 && @$newUser['userid'] ) {
	$jcontentdetails['created_by']	=	$newUser['userid'];
}
$row->bind( $jcontentdetails );

if ( is_array( $jcontentparams ) )
{
	$attribs	=	array();
	foreach ( $jcontentparams as $k => $v ) {
		$attribs[]	=	"$k=$v";
	}
	$row->attribs	=	implode( "\n", $attribs );
}

$row->bind( $jcontentmeta );
if ( is_array( $jcontentmeta ) )
{
	$attribs = array();
	foreach ( $jcontentmeta as $k => $v ) {
		if ( $k == 'meta_desc' ) {
			$row->metadesc = $v;
		} else if ( $k == 'meta_key' ) {
			$row->metakey = $v;
		} else {
			$k	=	str_replace( 'meta_', '', $k );
			$attribs[] = "$k=$v";
		}
	}
	$row->metadata	=	implode("\n", $attribs);
}


$row->created		=	( ! $row->created ) ? ( ( @$rowStored->created ) ? $rowStored->created : $createdate ) : $row->created;
$row->publish_up	=	( ! $row->publish_up ) ? ( ( @$rowStored->publish_up ) ? $rowStored->publish_up : $createdate ) : $row->publish_up;
//$stock = CONTENT_getSyntax_Group( $fieldname, $groupname, $value, $gx = '(.*?)' );
$opt = CCK::CONTENT_getXValues( $row->introtext, 'pr_options' );

//update all stock
$totstock = 0;
for($s=0;$s < count($opt); $s++ ){
	$totstock = $totstock + $opt[$s]->pr_stock;
}


$row->price  		= 	CCK::CONTENT_getValue( $row->introtext, 'pr_price' );
$row->brand  		= 	CCK::CONTENT_getValue( $row->introtext, 'pr_brand' );
$row->stock  		= 	$totstock;
$row->options		=	json_encode($opt);
$row->gender  		= 	CCK::CONTENT_getValue( $row->introtext, 'pr_gender' );
$row->staf_pick  	= 	CCK::CONTENT_getValue( $row->introtext, 'pr_pick' );
$row->group  		= 	CCK::CONTENT_getValue( $row->introtext, 'pr_group' );
$row->special  		= 	CCK::CONTENT_getValue( $row->introtext, 'pr_special' );
$row->sku  			= 	CCK::CONTENT_getValue( $row->introtext, 'pr_sku' );
$row->shipping  	= 	CCK::CONTENT_getValue( $row->introtext, 'pr_shipping' );
$row->new  			= 	CCK::CONTENT_getValue( $row->introtext, 'pr_new' );

if(CCK::CONTENT_getValue( $row->introtext, 'pr_brand' ) == ' '){
	$row->brand = strtolower(CCK::CONTENT_getValue( $row->introtext, 'pr_newbrand' ));
}

$row->tag  			= 	CCK::CONTENT_getValue( $row->introtext, 'tags' );
if ( @$rowStored && @$form['override'] ) {
	$row->state		=	$stateByUser;
}

if ( $isNew === FALSE ) {
	if ( ! $row->modified_by ) {
		$row->modified_by	=	@$userC->id;
	}
}
//Trigger onBeforeContentSave
$result	=	$dispatcher->trigger( 'onBeforeContentSave', array( &$row, $isNew ) );
if( in_array( false, $result, true ) ) {
	return false;
}
// Store
if ( ! $row->store() ) {
	$this->setError( $this->_db->getErrorMsg() );
	return false;
}
$row->reorder('catid = '.(int) $row->catid.' AND state >= 0');
//Trigger OnAfterContentSave
$dispatcher->trigger( 'onAfterContentSave', array( &$row, $isNew ) );

$ct_email = CCK::CONTENT_getValue( $row->introtext, 'ct_email' );

if($ct_email){
	$query = "UPDATE #__contact_details SET email_to = '$ct_email' WHERE id = 1";
	$this->_db->setQuery( $query );
	$max = $this->_db->query();
}

// Frontpage
if ( isset( $jcontent['frontpage'] ) ) {
	if ( @$jcontent['frontpage'] == 1 ) {
		$query = 'SELECT MAX(ordering) FROM #__content_frontpage';
		$this->_db->setQuery( $query );
		$max = $this->_db->loadResult();
		$order = ( $max ) ? $max + 1 : 1;
		$query = 'INSERT IGNORE INTO #__content_frontpage ( content_id, ordering ) VALUES( '.$row->id.', '.$order.' )';
		$this->_db->setQuery( $query );
		if ( ! $this->_db->query() ) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
	} else {
		$query = 'DELETE FROM #__content_frontpage WHERE content_id = '.$row->id;
		$this->_db->setQuery( $query );
		if ( ! $this->_db->query() ) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
	}
}

// Menu
$textObj->isNew			=	( $cckId ) ? 0 : 1;

$textObj->item_title	=	$row->title;
$textObj->item_id		=	$row->id;
$textObj->item_alias	=	$row->alias;
$textObj->item_state	=	$row->state;
$textObj->item_access	=	$row->access;
?>