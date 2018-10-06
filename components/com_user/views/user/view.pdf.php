<?php
/**
* @version		$Id: view.html.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @subpackage	Weblinks
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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class UserViewUser extends JView
{
	function display( $tpl = null)
	{
		global $mainframe;

		$layout	= $this->getLayout();
		$model 		=&	$this->getModel();
		$dispatcher	=& JDispatcher::getInstance();
		
		$document	= &JFactory::getDocument();
		if(JRequest::getVar('id')){
		$id = base64_decode(JRequest::getVar('id'));
			$transaction = $model->viewTransaction($id);
			$user	= JFactory::getUser($transaction->user);
			$shipment = json_decode($transaction->shipment);
			$products = json_decode($transaction->products);
		}
		$product_html = '';
		$product_total = '';
		foreach($products as $item){
			$product_html .= '<tr class="product-row">
				<td><img class="thumbnail" style="width: 200px;height: 200px;" src="'.JURI::base().$item->thumb.'" /></td>
				<td colspan="2">
					<strong>'.str_replace('u2013','-', $item->title).'</strong>
					<div style="font-size: 9pt;">
					<strong>Delivery Date :</strong> '.JHtml::_('date', $item->deliver).'<br/>
					<strong>Pickup Date :</strong> '.JHtml::_('date', $item->pickup).'<br/>
					<strong>Duration :</strong> '.$item->duration.' days
					</div>
				</td>
				<td class="align-right item-total" width=""><span class="woocommerce-Price-amount amount"><br /><span class="woocommerce-Price-currencySymbol">Rp</span>&nbsp;'.number_format($item->price, 0, '', '.').'</span></td>
			</tr>';
			$product_total += $item->price;
		}
		// set document information
		$document->setTitle('Transaction #'.$transaction->id);
		$document->setName('Transaction #'.$transaction->id);
		
		if($transaction->status == 'paid' || $transaction->status == 'complete'){
			$document->addMask(JPATH_BASE.DS.'images'.DS.'lunas.png');
		}
		//echo'<pre>';print_r($transaction);print_r($user);
		// prepare header lines
		//$document->setHeader($this->_getHeaderText($article, $params));
		
		if($transaction->disc_code){
			$discount = '<tr class="shipping after-products">
      <td colspan="2"></td>
      <td colspan="1">Discount<br /></td>
      <td class="align-right"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp</span>&nbsp;'.number_format($transaction->value - ($product_total + $shipment->pricing), 0, '', '.').'</span></td>
    </tr>';
		}else{
			$discount = '';
		}
		
		echo '
		<style>
		ul{
	padding: 0;
	margin: 0;
	line-height: 1;
}
li{
	padding: 0;
	margin: 0;
	line-height: 1;
}
		table {
	font-family: opensans;
	color: #333
}
h1.company-logo {
	color: black;
}
table {
	border-collapse: collapse;
	font-size: .9em;
	width: 100%;
	color: #757575;
}
.align-left {
	text-align: left;
}
.align-right {
	text-align: right;
}
.align-center {
	text-align: center;
}
.company .info,  .company .logo {
	text-align: left;
	vertical-align: middle;
	font-size: 14pt;
}
table.two-column {
	margin: 40px 0;
	width: 100%;
}
.two-column td {
	text-align: left;

}
table.products th {
	border-bottom: 2px solid #A5A5A5;
}
table.products td {

}
table.products td, table.products th {
	padding: 5px;
}
#terms-notes {
	margin-top: 30px;
}
tr.product-row td {
	border-bottom: 1px solid #CECECE;
}
td.total, td.grand-total {
	border-top: 4px solid #8D8D8D;
	padding-top: 4pt;
	margin-top: 4pt;
}

table, tbody, h1 {
	margin: 0;
	padding: 0;
}
h1.title {
	font-size: 2em;
}
span.payment-status {
	font-size: 14pt;
	font-weight: normal;
}
.nowrap {
	white-space: nowrap;
}
.invoice-head {
	margin-bottom: 30px;
	margin-right: -64px;
}
.invoice-head td {
	text-align: left;
}
.invoice-head .title {
	color: #525252;
}
td.invoice-details {


}
td.invoice-details{
	font-size: .9em;
}
.number {
	font-size: 16pt;
}
.small-font {
	font-size: .9em;
}
.amount{
	
}
.total-amount {
	padding-top: 100em;
	width: 54%;
	vertical-align: middle;
}
.total-amount, .total-amount h1 {
	color: white;
}
div.item-attribute {
	
}
.invoice {
	margin-bottom: 20px;
}
.foot {
	margin: 0 -64px;
}
.foot td.border {
	padding: 20px 40px;
	width: 100%;
	text-align: center;
}
td.company-details, td.payment {
	padding: 20px 40px 0;
	text-align: center;
	vertical-align: top;
	width: 50%;
}
.foot td {
	border: 1px solid white;
}
.refunded {
	color: #a00 !important;
}
.total-without-refund {
	color: #757575 !important;
}
/* End change colors */


.space td {
	padding-bottom: 30px;
}
table.products td {
	overflow: hidden;
}
th.border {
	border-bottom: 2px solid #A5A5A5;
}
.total-amount{
	 padding: 100px;
	vertical-align: middle !important;
}
.total-amount p {
	font-weight: bold;
}
tr.product-row td:nth-child(2),tr.product-row td:nth-child(3),tr.product-row td:nth-child(4){ width: 16.6666666667%; }
tr.product-row td:nth-child(1) {
	width: 48%;
}

		</style>
		<div style="color: #555555;">
		<table class="two-column">
    <tr>
      <td>
				<img style="width: 800px;" src="'.str_replace('http://','',JURI::base()).'images/logo.png">
			</td>
      <td><br/><br/><br/><br/><br/>&nbsp;&nbsp;&nbsp;info@toiss.id <br/>&nbsp;&nbsp;&nbsp;www.instagram.com/toiss.id/
			</td>
    </tr>
</table>
<br/><br/>
		<table class="two-column customer">
    <tr>
      <td class="address" width="50%"><strong>Invoice to</strong><br/><div style="font-size: 9pt;">'.$user->name.'<br/>Phone: '.$user->phone.'</div></td>
      <td class="address" width="50%"><strong>Ship to</strong><br/><div style="font-size: 9pt;">'.$shipment->address->address.' '.$shipment->address->address_opt.'<br/>'.$shipment->address->province.' '.$shipment->address->postal.'<br/>'.$shipment->address->country_name.'</div>
			</td>
    </tr>
</table>
<br/><br/>
<table class="invoice-head">
  <tbody>
    <tr>
      <td class="invoice-details">
				<h1 class="title" style="font-size: 22pt;">Invoice</h1>
        <h4 class="number" style="color: #7bdbc5;"><strong>Transaction ID #'.$transaction->id.'</strong></h4>
        <div class="font-size: 9;">Order Date: '.JHtml::_('date', $transaction->order_date).'</div>
        </td>
      <td class="total-amount" bgcolor="#7bdbc5"><br/>
				<div style="font-size: 3em; font-weight: bold; line-height: 1em;"> &nbsp;Rp '.number_format($transaction->value, 0, '', '.').'</div>
       <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Thank you for your purchase!<br/>
			</td>
    </tr>
  </tbody>
</table>
<br/><br/><br/>
<table class="products small-font" cellpadding="1em">
    <tr class="table-headers">
      <th width="20%" class="align-left border"><strong>Description</strong></th>
      <th width="30%" class="align-left border"></th>
      <th width="30%" class="align-center border"></th>
      <th width="20%" class="align-right border"><strong>Price</strong></th>
    </tr>
		'.$product_html.'
    <tr class="space">
      <td colspan="4"></td>
    </tr>
    <tr class="subtotal after-products">
      <td colspan="2"></td>
      <td colspan="1">Subtotal</td>
      <td class="align-right"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp</span>&nbsp;'.number_format($product_total, 0, '', '.').'</span></td>
    </tr>
    <tr class="shipping after-products">
      <td colspan="2"></td>
      <td colspan="2" width="50%">'.html_entity_decode($shipment->method_desc).'</td>
    </tr>
    '.$discount.'
    <tr class="after-products">
      <td colspan="2"></td>
      <td colspan="1" class="total"><br /><br />Total</td>
      <td class="grand-total align-right" style="color: #7bdbc5;font-size: 12pt;"><br /><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><br />Rp</span>&nbsp;'.number_format($transaction->value, 0, '', '.').'</span></td>
    </tr>
    
</table>
<table id="terms-notes">
  
  <!-- Notes & terms -->
  
  <tr>
    <td class="border" colspan="3"><br/>
      </td>
  </tr>
  </table></div>';
	//die();
	}

	function _displayForm($tpl = null)
	{
		global $mainframe;

		// Load the form validation behavior
		JHTML::_('behavior.formvalidation');

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		// check to see if Frontend User Params have been enabled
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		$check = $usersConfig->get('frontend_userparams');

		if ($check == '1' || $check == 1 || $check == NULL)
		{
			if($user->authorize( 'com_user', 'edit' )) {
				$params		= $user->getParameters(true);
			}
		}
		$params->merge( $params );
		$menus	= &JSite::getMenu();
		$menu	= $menus->getActive();

		// because the application sets a default page title, we need to get it
		// right from the menu item itself
		if (is_object( $menu )) {
			$menu_params = new JParameter( $menu->params );
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title',	JText::_( 'Edit Your Details' ));
			}
		} else {
			$params->set('page_title',	JText::_( 'Edit Your Details' ));
		}
		$document	= &JFactory::getDocument();
		$document->setTitle( $params->get( 'page_title' ) );

		$this->assignRef('user'  , $user);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
}
