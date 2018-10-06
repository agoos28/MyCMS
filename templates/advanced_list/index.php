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
?>

<?php
// Init jSeblod Process Object { !Important; !Required; }
$jSeblod	=	clone $this;
if ( array_key_exists( 'cckitems', get_object_vars( $jSeblod ) ) ) {
	$cckitems	=	$jSeblod->cckitems;
	$cckwidth	=	@$jSeblod->cckwidth;
	$columns	=	count( $cckitems );
	if ( ! is_array( $cckwidth ) ) {
		$col_width	=	( $columns ) ? round( 100 / $columns ).'%' : null;
	}
} else {
	return true;
}
?>

<?php
// Init Style Parameters
include( dirname(__FILE__) . '/params.php' );
?>

<table class="admintable" width="100%" cellpadding="0" cellspacing="0" border="0">

<?php
$cut	=	$columnNum;

$num	=	count( $jSeblod->list );
if ( $num) {
	switch ( $listLayout ) {
		case 'catalog':
			// *** CATALOG *** //		
			echo '<tr><td width="100%">';
			echo '<'.$typeListLayout.' style="list-style: '.$styleListLayout.'; padding-left: '.$pxLeftMargin.'px;">';
			echo '<div style="float: left;">';
		
			for ( $i = 0, $j = 0, $c = 0; $i < $num; $i++ ) {
	
				$c	=	$i - 1;
				if ( $i == 0 || ( ( $catalogName == 'category' ) && ( @$jSeblod->list[$c]->$catalogName != @$jSeblod->list[$i]->$catalogName ) )
							 || ( ( $catalogName != 'category' ) && ( @$jSeblod->list[$c]->$catalogName->value != @$jSeblod->list[$i]->$catalogName->value ) ) ) {
					if  ( ( $j >= $cut ) && ( $j % $cut == 0 ) ) {
						echo '</div><div style="float: left; padding-left: '.$pxIntervalMargin.'px;">';
					} else {
						echo ( $i != 0 ) ? '<br />' : '';
					}
					echo '<h3>';
					echo ( $catalogName == 'category' ) ? @$jSeblod->list[$i]->$catalogName : @$jSeblod->list[$i]->$catalogName->value;
					echo '</h3>';
					$j++;
				}
				echo '<li class="cck_list">';
					if ( $columns ) {
						for ( $k = $start_col; $k < $columns; $k++ ) {
							$item	=	$cckitems[$k];
							echo ( $k != $start_col ) ? '<br />' : '';
							echo CCK_CONTENT_DefaultContent( @$jSeblod->list[$i]->$item->value, @$jSeblod->list[$i]->$item, false );
						} 
					}
				
				echo '</li>';    
			} 
			echo '</div>';
			echo '</'.$typeListLayout.'>';
			echo '</td></tr>';
			// *** CATALOG *** //
			break;
		case 'list':
		default:
			// *** LIST *** //
			echo '<tr><td width="100%">';
			echo '<'.$typeListLayout.' style="list-style: '.$styleListLayout.'; padding-left: '.$pxLeftMargin.'px;">';
			echo '<div style="float: left;">';
			for ( $i = 0; $i < $num; $i++ ) {
				if  ( ( $i >= $cut ) && ( $i % $cut == 0 ) ) {
					echo '</div><div style="float: left; padding-left: '.$pxIntervalMargin.'px;">';
				}
				echo '<li class="cck_list">';
					if ( $columns ) {
						for ( $k = $start_col; $k < $columns; $k++ ) {
							$item	=	$cckitems[$k];
							echo ( $k != $start_col ) ? '<br />' : '';
							echo CCK_CONTENT_DefaultContent( @$jSeblod->list[$i]->$item->value, @$jSeblod->list[$i]->$item, false );
						} 
					}
				echo '</li>';    
			}
			
			echo '</div>';
			echo '</'.$typeListLayout.'>';
			echo '</td></tr>';
			// *** LIST *** //
			break;
	}
}
?>
</table>