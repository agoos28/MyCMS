<?php 


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$model = &$this->getModel();
$session =& JFactory::getSession();
$try = $session->get('code_try');
if($try <= 10){
	$result = $model->validateCode(JRequest::getVar('discount_code'));
	if(!$result->id){
		$session->set('code_try', (int)$try + 1);
		$session->set('promo_code', '');
		$session->set('discount', '');
		echo '<div class="alert alert-danger">'.JText::_("CODE_INVALID").', '.JText::_("YOU_HAVE").' '.(10 - $try).' '.JText::_("TRY_LEFT").'</div>';
	}else{
		$session->set('promo_code', '');
		$session->set('discount', '');
		if($result->error){
			echo '<div class="disc alert alert-danger">'.$result->text.'</span></div>';
		}else{
		$session->set('promo_code', JRequest::getVar('discount_code'));
		$session->set('discount', $result->value);
		$session->set('discount_type', $result->type);
		echo '<div class="disc alert alert-success">'.JText::_("YOU_GOT").' <span class="value" data-value="'.$result->value.'" data-type="'.$result->type.'">'.$result->text.'</span> Off from the code</div>';
		}
	}
}else{
	echo '<div class="alert alert-danger">Try again tomorrow.</div>';
}
//$session->set('code_try', 0);
//print_r($result);
die();exit();

?>