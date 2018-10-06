<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="breadcrumb-content">
<ul class="no-padding m-b-0">
<?php for ($i = 0; $i < $count; $i ++) :
	echo '<li>';
	// If not the last item in the breadcrumbs add the separator
	if ($i < $count -1) {
		if(!empty($list[$i]->link)) {
			echo '<li><a href="'.$list[$i]->link.'">'.$list[$i]->name.'</a></li>';
		} else {
			echo '<li>'.$list[$i]->name.'<li>';
		}
		echo '<li><span>&nbsp;'.$separator.'&nbsp;</span></li>';
	}  else if ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
	    echo '<li class="active">'.$list[$i]->name.'<li>';
	}
	echo '</li>';
endfor; ?>
</ul>
</div>
