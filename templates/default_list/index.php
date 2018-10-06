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

<table class="category" width="<?php echo $table_width; ?>" cellpadding="0" cellspacing="0" border="0" style="margin-top:5px;">
	<tr>
    	<?php if ( $columns ) {
			for ( $k = $start_col; $k < $columns; $k++ ) {
				$item	=	$cckitems[$k]; ?>
				<td <?php echo ( @$col_width  ) ? 'width="'.$col_width.'"' : ( ( @$cckwidth[$k] ) ? 'width="'.$cckwidth[$k].'"' : '' ); ?> class="sectiontableheader">
					<?php echo @$jSeblod->list[0]->$item->label; ?>
				</td>
		<?php } } ?>
	</tr>
	<?php
    $num	=	count( $jSeblod->list );
	if ( $num) {
		for ( $i = 0; $i < $num; $i++ ) {
	?>
	<tr class="sectiontableentry<?php echo ( $i % 2 == 0 ) ? 2 : 1;?>">
    	<?php if ( $columns ) {
			for ( $k = $start_col; $k < $columns; $k++ ) {
				$item	=	$cckitems[$k]; ?>
				<td <?php echo ( @$col_width  ) ? 'width="'.$col_width.'"' : ( ( @$cckwidth[$k] ) ? 'width="'.$cckwidth[$k].'"' : '' ); ?> >
					<?php echo CCK_CONTENT_DefaultContent( @$jSeblod->list[$i]->$item->value, @$jSeblod->list[$i]->$item, false ); ?>
				</td>
		<?php } } ?>
	</tr>
    <?php } } ?>
</table>