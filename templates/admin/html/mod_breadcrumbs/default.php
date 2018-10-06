<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<ol class="breadcrumb">
<?php for ($i = 0; $i < $count; $i ++) :

	// If not the last item in the breadcrumbs add the separator
	if ($i < $count -1) {
		if(!empty($list[$i]->link)) {
			echo '<li><a href="'.$list[$i]->link.'">'.$list[$i]->name.'</a></li>';
		}else if(trim($list[$i]->name)){
			echo '<li>'.$list[$i]->name.'</li>';
		}
	}  else if ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
	    echo '<li class="active">'.$list[$i]->name.'</li>';
	}
endfor; ?>
</ol>
