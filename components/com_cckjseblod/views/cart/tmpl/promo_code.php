<?php 


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$model = &$this->getModel();

if(JRequest::getVar('update')){
	if($model->updateJne(JRequest::getVar('update'), JRequest::getVar('reg'), JRequest::getVar('exp'), JRequest::getVar('cod')) == 'Succcess update'){
		echo 'ok';
	}
	exit();die();
}

$promo = $model->getPromocode(JRequest::getVar('code'));

$i = 1;
?>
<div class="componentheading">Local Shipment Destinations</div>
<div style="padding: 20px 0;">
	<form method="get">
	Search <input type="text" name="code" value="<?php echo JRequest::getVar('code'); ?>" /> <button type="submit">GO</button>
    </form>
</div>
<div style="padding: 20px 0;">
	<form method="post">
    Generate new code
	Discount value% <input type="text" name="value" value="" /> <button type="submit">GO</button>
    </form>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="category"><tbody>
    <tr>
        <td width="30" align="center" class="sectiontableheader">ID</td>
        <td align="center" class="sectiontableheader">Code</td>
        <td  width="30" align="center" class="sectiontableheader">Value</td>
        <td align="left" class="sectiontableheader">Owner</td>
        <td align="left" class="sectiontableheader">Used by</td>
        <td width="15%" align="center" class="sectiontableheader">Used date</td>
        <td width="50" align="center" class="sectiontableheader">Delete</td>
    </tr>
<?php foreach($promo->result as $item){ ?>
	<tr class="sectiontableentry<?php if($i % 2){ echo 2; }else{ echo 1; }; ?>">
    	<td align="center"><?php echo $item->id; ?></td>
		<td align="center"><?php echo $item->code; ?></td>
        <td align="center"><?php echo $item->owner; ?></td>
        <td align="center"><?php echo $item->used_by; ?></td>
        <td align="center"><?php echo $item->used_in; ?></td>
        <td align="center"><a class="editshipment" href="#" id="<?php echo $item->id; ?>">Delete</a></td>
	</tr>
<?php $i++; }; ?>
</tbody></table>
<?php echo $jne->pageNav->getPagesLinks(); ?>