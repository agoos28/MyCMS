<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<li>
<form id="searchform" method="post" action="<?php echo JURI::current(); ?>">
 
    	<input name="keyword" value="<?php echo JRequest::getVar('keyword'); ?>" type="text" placeholder="Search Product"> <button type="submit" class="btn btn-sm btn-primary">GO</button>
        <input type="hidden" name="view" value="article" />
        <input type="hidden" name="layout" value="user" />
        <input type="hidden" name="title" value="Search Product" />
</form>
<script>
jQuery(document).ready(function(e) {
    jQuery('.reset').click(function(){
		jQuery('#searchform').find('input').val('')
		jQuery('#searchform').submit()
	})
});
</script>
</li>