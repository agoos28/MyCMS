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



function saveBrand($brand){
	if(checkBrands($brand)){
		return false;
	}else{
		$brandlower = strtolower($brand);
		$db = JFactory::getDBO();
		$query = "INSERT INTO #__brands ".
				"(title, name) ".
				"VALUES ('$brandlower', '$brand') ";
		$db->setQuery($query);
		$db->query();
		$error = $db->getErrorMsg();
		if($error){
			echo $error;die();
		}
	}
}
function checkBrands($brand = null){
	if(!$brand){
		return false;
	}
	$brand = strtolower($brand);
	$db = JFactory::getDBO();
	$query = "SELECT title FROM #__brands ".
			 "WHERE title = '$brand'";
	$db->setQuery($query);
	$result = $db->loadResultArray();
	$error = $db->getErrorMsg();
	if($error){
		echo $error;die();
	}
	
	return $result;
}
function updateBrand($id = 0, $brand = 'undefined'){
	$brandlower = strtolower($brand);
	$db = JFactory::getDBO();
	$query = "UPDATE #__brands SET title = '$brandlower', name = '$brand'  WHERE id = ".$id;
	$db->setQuery($query);
	$db->query();
	$error = $db->getErrorMsg();
	if($error){
		echo $error;die();
	}
}
$newbrand = CCK::CONTENT_getValue( $row->introtext, 'pr_newbrand' );
$brand = CCK::CONTENT_getValue( $row->introtext, 'pr_brand' );
if($newbrand){
	saveBrand($newbrand);
}


?>