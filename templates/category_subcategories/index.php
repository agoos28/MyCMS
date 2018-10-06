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
/**
 * Init jSeblod Process Object { !Important; !Required; }
 **/
$jSeblod	=	clone $this;

// TODO: get it from plugin (only categories with articles displayed as link!)
for ( $i = 97; $i < 123; $i++ ) {
	$jSeblod->subcategories_alpha[$i - 97] = chr($i);
}
?>

<?php
/**
 * Init Style Parameters
 **/
include( dirname(__FILE__) . '/params.php' );
?>

<?php
/**
 * Category
 **/
?>
<table class="admintable" width="100%" cellpadding="0" cellspacing="0" border="0">
<?php if ( $jSeblod->image_plugin->value || $jSeblod->wysiwyg_description_box->value ) { ?>
<tr>
	<?php if ( $categoryContent == 'image' ) { ?>
		<?php if ( $jSeblod->image_plugin->value ) { ?>
        <td>
            <?php echo $jSeblod->image_plugin->value; ?>
        </td>
        <?php } ?>
    <?php } else { ?>
		<?php if ( $jSeblod->wysiwyg_description_box->value ) { ?>
        <td>
            <?php echo $jSeblod->wysiwyg_description_box->value; ?>
        </td>
        <?php } ?>
    <?php } ?>
</tr>
<?php } ?>

<?php
/**
 * Alpha
 **/
if ( $alphaList && ( is_array( $jSeblod->subcategories ) || is_object( $jSeblod->subcategories ) ) ) {
?>
<tr>
	<td><br />
    	<?php 
		$link	=	$_SERVER['REQUEST_URI'];
		for ( $i = 0; $i < 26; $i++ ) {
			if ( strpos( $link, '&alpha=' ) !== false ) {
				echo '<a href="'.substr( $link, 0, -1 ).$jSeblod->subcategories_alpha[$i].'">';
			} else {
				echo '<a href="'.$link.'&alpha='.$jSeblod->subcategories_alpha[$i].'">';
			}
			echo strtoupper( $jSeblod->subcategories_alpha[$i] );
			echo '</a>&nbsp;&nbsp;';
		}
		?>
    </td>
</tr>
<?php } ?>

<?php
/**
 * Subcategories
 **/
if ( is_array( $jSeblod->subcategories ) && $n = count( $jSeblod->subcategories ) ) {
	echo '<tr><td width="100%">';
	switch ( $subcatsLayout ) {
		case 'catalog':
			$column	=	( $columnNum > $n ) ? $n : $columnNum;
			$cut	=	( $n % $column ) ? floor($n / $column) + 1 : $n / $column;
			echo '<'.$typeListLayout.' style="list-style: none; padding-left: '.$pxLeftMargin.'px;">';
			echo '<div style="float: left;">';
			for ( $i = 0; $i < $n; $i++ ) {
				if ( $i == $cut ) {
					echo '</div><div style="float: left; padding-left: '.$pxIntervalMargin.'px;">';
				}
				echo '<li class="cck_field_subcategories">';
				if ( $titleCatalogLayout == 'top' ) {
					echo '<a href="'.$jSeblod->subcategories[$i]['catlink']->value.'" class="category">'.$jSeblod->subcategories[$i]['title']->value.'</a>';					
					echo '<br />';
				}
				echo '<a href="'.$jSeblod->subcategories[$i]['catlink']->value.'" class="category">'.$jSeblod->subcategories[$i]['image_plugin']->value.'</a>';
				if ( $titleCatalogLayout == 'bottom' ) {
					echo '<br />';
					echo '<a href="'.$jSeblod->subcategories[$i]['catlink']->value.'" class="category">'.$jSeblod->subcategories[$i]['title']->value.'</a>';					
				}
				echo '</li>';
			}
			echo '</div>';
			echo '</'.$typeListLayout.'>';
			break;
		case 'list':
		default:
			$column	=	( $columnNum > $n ) ? $n : $columnNum;
			$cut	=	( $n % $column ) ? floor($n / $column) + 1 : $n / $column;
			echo '<'.$typeListLayout.' style="list-style: '.$styleListLayout.'; padding-left: '.$pxLeftMargin.'px;">';
			echo '<div style="float: left;">';
			for ( $i = 0; $i < $n; $i++ ) {
				if ( $i == $cut ) {
					echo '</div><div style="float: left; padding-left: '.$pxIntervalMargin.'px;">';
				}
				echo '<li class="cck_field_subcategories">';
				echo '<a href="'.$jSeblod->subcategories[$i]['catlink']->value.'" class="category">'.$jSeblod->subcategories[$i]['title']->value.'</a>';
				echo '<br />';
				echo '<span class="small">'.$jSeblod->subcategories[$i]['subtitle']->value.'</span>';
				echo '</li>';
			}
			echo '</div>';
			echo '</'.$typeListLayout.'>';
			break;
	}
	echo '</td></tr>';
}
?>
</table>