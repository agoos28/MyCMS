<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );

$params = $this->menu_params;

function getName($keyword = null, $params = null){
	$db = JFactory::getDBO();
	$result = array();
	$result = (object) array('query' => 'unit');
	if($params->get('area')){
		$query = "SELECT country_id AS data, short_name AS value FROM #__country WHERE short_name LIKE '%".$keyword."%' LIMIT 0,10" ;
	}else{
		$query = "SELECT id AS data, CONCAT(kecamatan, ' - ', kota) AS value FROM #__jne WHERE kecamatan LIKE '%".$keyword."%' LIMIT 0,10" ;
	}
	$db->setQuery($query);
	$result->suggestions = $db->loadObjectList();
	$error = $db->getErrorMsg();
		if($error){
			die($error);
		}
	return $result;
}
function is_free(){
	$session =& JFactory::getSession();
	$cartItems = $session->get('cart');
	$cartItems = (array)json_decode($cartItems);
	$is_free = 0;
	for($i = 0; $i < count($cartItems); $i++){
		if($cartItems[$i]->is_free == 1){
			$is_free = 1;
		}
	}
	if($is_free > 0){
		return true;
	}else{
		return false;
	}
}
function getCost($id = null, $params = null){
	$db = JFactory::getDBO();
	if($params->get('area')){
		$query = "SELECT regular AS reg, express AS yes FROM #__country WHERE  country_id = ".(int)$id;
	}else{
		$query = "SELECT * FROM #__jne WHERE id = ".(int)$id;
	}
	$db->setQuery($query);
	$result = $db->loadObject();
 	return $result;
}

$request = (object)JRequest::get('default'); 

if($request->getcost){
		$cost = getCost($request->getcost, $params);
		if(!count($cost)){
			echo '<select name="service"><option value="87500||- Berlaku harga tertinggi." selected="selected">-  Berlaku harga tertinggi (87.500)</option></select>';die();
		}
		
		$s = 0;
		if($params->get('area')){
			$html = '<select name="serviceint">';
		}else{
			$html = '<select name="service">';
		}
		
		if($cost->reg){
			if(JRequest::getVar('debug')){
				print_r(is_free());
			}
			if(is_free() == 1 && $cost->group == 'jabodetabek'){
				$html .= '<option selected="selected" value="0||REGULAR">REGULAR (Free Promo)</option>';
			}else if($cost->reg == 1){
				$html .= '<option selected="selected" value="0||REGULAR">REGULAR (Free)</option>';
			}else{
				$html .= '<option selected="selected" value="'.$cost->reg.'||REGULAR">REGULAR ('.number_format($cost->reg, 0, '', '.').')</option>';
			}
		}
		if($cost->yes){
			if($cost->yes == 1){
				if($params->get('area')){
					$html .= '<option value="'.$cost->yes.'||YES">EXPRESS ('.number_format($cost->yes, 0, '', '.').')</option>';
				}else{
					$html .= '<option value="'.$cost->yes.'||YES">YES ('.number_format($cost->yes, 0, '', '.').')</option>';
				}
			}else{
				if($params->get('area')){
					$html .= '<option value="'.$cost->yes.'||YES">EXPRESS ('.number_format($cost->yes, 0, '', '.').')</option>';
				}else{
					$html .= '<option value="'.$cost->yes.'||YES">YES ('.number_format($cost->yes, 0, '', '.').')</option>';
				}
			}
		}
		if($cost->cod){
			if($cost->cod == 1){
				$html .= '<option value="0||COD">COD (Free)</option>';
			}else{
				$html .= '<option value="'.$cost->cod.'||COD">COD ('.number_format($cost->cod, 0, '', '.').')</option>';
			}
		}
		if($cost->yes == 0 && $cost->reg == 0 && $cost->cod == 0){
			$html .= '<option selected="selected" value="0||PENDING">Your shipment cost/methode will be updated with confirmation by out staff.</option>';
		}
		$html .= '</select>';
		
		echo $html;die();
}else{
	echo json_encode(getName($request->query, $params)); die();
}

?>


