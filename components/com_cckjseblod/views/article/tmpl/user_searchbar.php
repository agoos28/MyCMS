<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<form id="searchform" method="post" action="<?php echo JURI::base().$_SERVER["REQUEST_URI"]; ?>">
	<p style="float: right;"> Search title 
    	<input name="keyword" value="<?php echo JRequest::getVar('keyword'); ?>" type="text"> &nbsp; &nbsp;  Search SKU <input name="sku" value="<?php echo JRequest::getVar('sku'); ?>" type="text"> <button type="submit">GO</button> <button class="reset" type="reset">Reset</button></p>
</form>
<script>
jQuery(document).ready(function(e) {
    jQuery('.reset').click(function(){
		jQuery('#searchform').find('input').val('')
		jQuery('#searchform').submit()
	})
});
</script>