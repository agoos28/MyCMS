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
} else {
	return true;
}
?>

<?php
// Init Style Parameters
include( dirname(__FILE__) . '/params.php' );
?>

<table class="blog" cellpadding="0" cellspacing="0">
<tr>
	<td valign="top">
<?php
// BOP
$num	=	count( $jSeblod->list );
if ( $num) {
	for ( $k = 0; $k < $num; $k++ ) {
?>
	<div>
        <table class="contentpaneopen">
            <tr>
                <td class="contentheading" width="100%">
                    <?php if ( $jSeblod->list[$k]->href ) { ?>
                        <a href="<?php echo $jSeblod->list[$k]->href; ?>" class="contentpagetitle">
                        <?php echo $jSeblod->list[$k]->title; ?></a>
                    <?php } else { ?>
                        <?php echo $jSeblod->list[$k]->title; ?>
                    <?php } ?>
                </td>
            </tr>
        </table>

		<table class="contentpaneopen">
        	<?php if ( @$jSeblod->list[$k]->LOCATION_SUBTITLE1->value != '' ) { ?>
            <tr>
                <td width="70%"  valign="top">
                    <span class="small">
                        <?php echo CCK_CONTENT_DefaultContent( $jSeblod->list[$k]->LOCATION_SUBTITLE1->value, $jSeblod->list[$k]->LOCATION_SUBTITLE1 ); ?>
                    </span>
                </td>
            </tr>
            <?php } ?>
			<?php if ( @$jSeblod->list[$k]->LOCATION_SUBTITLE2->value != '' ) { ?>
            <tr>
                <td width="70%"  valign="top">
                    <span class="small">
                        <?php echo CCK_CONTENT_DefaultContent( $jSeblod->list[$k]->LOCATION_SUBTITLE2->value, $jSeblod->list[$k]->LOCATION_SUBTITLE2 ); ?>
                    </span>
                </td>
            </tr>
            <?php } ?>
			<?php if ( @$jSeblod->list[$k]->LOCATION_IMAGE->value != '' || @$jSeblod->list[$k]->LOCATION_DESCRIPTION->value != '' ) { ?>
            <tr>
            	<td>
	                <div style="float: left; margin-right: 10px; margin-top: 8px;">
						<?php echo CCK_CONTENT_DefaultContent( $jSeblod->list[$k]->LOCATION_IMAGE->value, $jSeblod->list[$k]->LOCATION_IMAGE ); ?>
                    </div>
                	<div style="margin-top: 8px;">
                    	<?php echo CCK_CONTENT_DefaultContent( $jSeblod->list[$k]->LOCATION_DESCRIPTION->value, $jSeblod->list[$k]->LOCATION_DESCRIPTION ); ?>
                	</div>
                </td>
            </tr>
            <?php } ?>
	        <tr>
                <td>
                <?php 
                // !! Content::Begin !! (@Advanced Content)
                if ( sizeof( $cckitems ) ):
                ?>
                
                <table class="admintable" width="100%" cellpadding="0" cellspacing="0" border="0">
                <?php for ( $i = 0, $n = count( $cckitems ); $i < $n; $i++ ) {
                    $item	=	$cckitems[$i];
                    
                    if ( $jSeblod->list[$k]->$item ) { ?>
                        <!-- Fields Types (Array) -->
                        <?php if ( is_array ( $jSeblod->list[$k]->$item ) ) { ?>
                        <tr>
                            <?php if ( $jSeblod->list[$k]->{$item}[0] ) { ?>
                                
                                <?php $colspan = 0; ?>
                                <?php if ( $jSeblod->list[$k]->{$item}[0]->display != -1 ) { ?>
                                <?php if ( $jSeblod->list[$k]->{$item}[0]->displayfield == 0 || ( $jSeblod->list[$k]->{$item}[0]->displayfield == 1 && $client->id ) || ( $jSeblod->list[$k]->{$item}[0]->displayfield == 2 && !$client->id ) ) { ?>
                                    
                                        <?php if ( $displayTooltip ) { ?>
                                        <td width="25" <?php echo ( ! ( $jSeblod->list[$k]->{$item}[0]->light || $jSeblod->list[$k]->{$item}[0]->display == 3 ) ) ? '' : 'class="key_balloon"'; ?>>
                                        <?php if ( $jSeblod->list[$k]->{$item}[0]->light ) { ?>
                                            <?php if ( $jSeblod->list[$k]->{$item}[0]->description ) { ?>
                                            <span class="DescriptionTip" title="<?php echo $jSeblod->list[$k]->{$item}[0]->label; ?>::<?php echo $jSeblod->list[$k]->{$item}[0]->tooltip; ?>">
                                                <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                                            </span>
                                            <?php } ?>
                                        <?php } ?>
                                        </td>
                                        <?php } ?>
                                         <?php if ( $displayLabel ) { ?>
                                        <td width="140" <?php echo ( ! ( $jSeblod->list[$k]->{$item}[0]->light || $jSeblod->list[$k]->{$item}[0]->display == 3 ) ) ? 'cck_label' : 'class="key cck_label"'; ?>>
                                        <?php if ( $jSeblod->list[$k]->{$item}[0]->display == 3 || $jSeblod->list[$k]->{$item}[0]->display == 2 ) { ?>
                                            <label for="<?php echo $jSeblod->list[$k]->{$item}[0]->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.'"'; } ?>><?php echo ( $jSeblod->list[$k]->{$item}[0]->label ) ? $jSeblod->list[$k]->{$item}[0]->label . $labelSeparator : ''; ?></label>
                                        <?php } ?>
                                        </td>
                                        <?php } ?>
                                        <td class="cck_field">
                                        <?php for ( $i2 = 0, $n2 = count( $jSeblod->list[$k]->$item ); $i2 < $n2; $i2++ ) { ?>
                                            <?php echo @$jSeblod->list[$k]->{$item}[$i2]->codebefore; ?>
                                            <span class="<?php echo $jSeblod->list[$k]->{$item}[$i2]->name.'_'.$i2; ?>">
                                            <?php echo CCK_CONTENT_DefaultContent( @$jSeblod->list[$k]->{$item}[$i2]->value, @$jSeblod->list[$k]->{$item}[$i2], true ); ?>
                                            </span>
                                            <?php
                                            if ( @$jSeblod->list[$k]->{$item}[0]->content != '' && @$jSeblod->list[$k]->{$item}[0]->cols && ( ($i2+1) % $jSeblod->list[$k]->{$item}[0]->cols ) == 0 ) {
                                                echo @$jSeblod->list[$k]->{$item}[0]->content;
                                            }
                                            ?>
                                            <?php echo @$jSeblod->list[$k]->{$item}[$i2]->codebefore; ?>
                                        <?php } ?>
                                        </td>
                                    
                                <?php } else { echo $jSeblod->list[$k]->{$item}[$i2]->value; }?>
                                <?php } ?>
                
                            <?php } ?>
                    </tr>
                        <?php } else { ?>
                
                        <!-- Field Types (Var)-->
                        <?php if ( $jSeblod->list[$k]->$item->display == -3 ) {
								echo '<tr><td colspan="3"><h3>'.$jSeblod->list[$k]->$item->label.'</h3></td></tr>';
                            } else if ( $jSeblod->list[$k]->$item->display == -2 ) {
								echo '<tr><td colspan="3"><h3>'.$jSeblod->list[$k]->$item->label.'</h3></td></tr>';
                            } else { ?>
                                <?php $colspan = 0; ?>
                                <?php if ( $jSeblod->list[$k]->$item->display != -1 ) { ?>
                                <?php if ( $jSeblod->list[$k]->$item->displayfield == 0 || ( $jSeblod->list[$k]->$item->displayfield == 1 && $client->id ) || ( $jSeblod->list[$k]->$item->displayfield == 2 && !$client->id ) ) { ?>
                                    <tr> 
                                        <?php if ( $displayTooltip ) { ?>
                                        <td width="25" <?php echo ( ! ( $jSeblod->list[$k]->$item->light || $jSeblod->list[$k]->$item->display == 3 ) ) ? '' : 'class="key_balloon"'; ?>>
                                        <?php if ( $jSeblod->list[$k]->$item->light ) { ?>
                                            <?php if ( $jSeblod->list[$k]->$item->description ) { ?>
                                            <span class="DescriptionTip" title="<?php echo $jSeblod->list[$k]->$item->label; ?>::<?php echo $jSeblod->list[$k]->$item->tooltip; ?>">
                                                <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                                            </span>
                                            <?php } ?>
                                        <?php } ?>
                                        </td>
                                        <?php } ?>
                                        <?php if ( $displayLabel ) { ?>
                                        <td width="140" <?php echo ( ! ( $jSeblod->list[$k]->$item->light || $jSeblod->list[$k]->$item->display == 3 ) ) ? 'class="cck_label"' : 'class="key cck_label"'; ?>>
                                        <?php if ( $jSeblod->list[$k]->$item->display == 3 ||  $jSeblod->list[$k]->$item->display == 2 ) { ?>
                                            <label for="<?php echo $jSeblod->list[$k]->$item->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.'"'; } ?>><?php echo ( $jSeblod->list[$k]->$item->label ) ? $jSeblod->list[$k]->$item->label . $labelSeparator : ''; ?></label>
                                        <?php } ?>
                                        </td>
                                        <?php } ?>
                                        <td class="cck_field">
                                            <?php echo @$jSeblod->list[$k]->$item->codebefore; ?>
                                            <?php echo CCK_CONTENT_DefaultContent( @$jSeblod->list[$k]->$item->value, @$jSeblod->list[$k]->$item, false ); ?>
                                            <?php echo @$jSeblod->list[$k]->$item->codeafter; ?>
                                        </td>
                                    </tr>
                                <?php } else { echo $jSeblod->list[$k]->$item->value; }?>
                                <?php } ?>
                        <?php } } ?>
                    
                <?php } } ?>
                </table>
                    
                <?php endif;
                // !! Content::End !! (@Advanced Content)
                ?>
                </td>
			</tr>
            <?php if ( @$jSeblod->list[$k]->LOCATION_FOOTER->value != '' ) { ?>
            <tr>
                <td colspan="2"  class="modifydate">
					<?php echo CCK_CONTENT_DefaultContent( $jSeblod->list[$k]->LOCATION_FOOTER->value, $jSeblod->list[$k]->LOCATION_FOOTER ); ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        
        <span class="article_separator">&nbsp;</span>
	</div>
<?php
	} }
// EOP
?>
	</td>
</tr>
</table>