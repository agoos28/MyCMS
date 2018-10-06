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

if ( array_key_exists( 'cckitems', get_object_vars( $jSeblod ) ) ) {
	$cckitems	=	$jSeblod->cckitems;
} else {
	return true;
}

$panelId	=	0;
$subPanelId =	0;
jimport( 'joomla.html.pane' );
?>

<?php 
/**
 * Init Style Parameters
 **/
include( dirname(__FILE__) . '/params.php' );
?>

<?php 
/**
 * Push Any jSeblod Content Fields
 **/
if ( sizeof( $cckitems ) ):
?>

<table class="admintable" width="100%" cellpadding="0" cellspacing="0" border="0">
<?php for ( $i = 0, $n = count( $cckitems ); $i < $n; $i++ ) {
	$item	=	$cckitems[$i];
	
	if ( $jSeblod->$item ) { ?>
		<!-- Fields Types (Array) -->
		<?php if ( is_array ( $jSeblod->$item ) ) { ?>
		<?php if ( @$jSeblod->{$item}[0] ) { ?>		
			<?php if ( is_array ( $jSeblod->{$item}[0] ) ) { ?>
				
				<tr>
	                 <?php if ( $displayTooltip ) { ?>
                    <td width="25" <?php echo ( ! ( $jSeblod->{$item}['group']->light || $jSeblod->{$item}['group']->display == 3 ) ) ? '' : 'class="key_balloon"'; ?>>
                    <?php if ( $jSeblod->{$item}['group']->light ) { ?>
                        <?php if ( $jSeblod->{$item}['group']->description ) { ?>
                        <span class="DescriptionTip" title="<?php echo $jSeblod->{$item}['group']->label; ?>::<?php echo $jSeblod->{$item}['group']->tooltip; ?>">
                            <img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
                        </span>
                        <?php } ?>
                    <?php } ?>
                       </td>
                    <?php } ?>
					<?php if ( $displayLabel ) { ?>
						<td width="140" <?php echo ( ! ( $jSeblod->{$item}['group']->light || $jSeblod->{$item}['group']->display == 3 ) ) ? 'cck_label' : 'class="key cck_label"'; ?>>
						<?php if ( $jSeblod->{$item}['group']->display == 3 || $jSeblod->{$item}['group']->display == 2 ) { ?>
							<label for="<?php echo $jSeblod->{$item}['group']->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.'"'; } ?>><?php echo ( $jSeblod->{$item}['group']->label ) ? $jSeblod->{$item}['group']->label . $labelSeparator : ''; ?></label>
						<?php } ?>
                        </td>
					<?php } ?>
                	<td class="cck_field">
						<?php
                        $n2	=	count ( $jSeblod->{$item} );
                        for ( $i2 = 0; $i2 < $n2 - 1; $i2++ ) { ?>
                            <table class="cck_group" cellpadding="0" cellspacing="0" border="0">
                            <?php
                            $n3	=	count ( $jSeblod->{$item}[$i2] );
                            foreach ( $jSeblod->{$item}[$i2] as $field ) { ?>
                                <tr>
                                    <td width="140" style="color: #666666; font-weight: bold;">
                                        <?php echo $field->label; ?>:
                                    </td>
                                    <td class="cck_field">
                                        <?php echo CCK_CONTENT_DefaultContent( @$field->value, @$field, false ); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </table>
                        <?php } ?>
                    </td>
                </tr>
            
            <?php } else { ?>
				<tr>
				<?php $colspan = 0; ?>
				<?php if ( $jSeblod->{$item}[0]->display != -1 ) { ?>
				<?php if ( $jSeblod->{$item}[0]->displayfield == 0 || ( $jSeblod->{$item}[0]->displayfield == 1 && $client->id ) || ( $jSeblod->{$item}[0]->displayfield == 2 && !$client->id ) ) { ?>
					
	                    <?php if ( $displayTooltip ) { ?>
						<td width="25" <?php echo ( ! ( $jSeblod->{$item}[0]->light || $jSeblod->{$item}[0]->display == 3 ) ) ? '' : 'class="key_balloon"'; ?>>
						<?php if ( $jSeblod->{$item}[0]->light ) { ?>
							<?php if ( $jSeblod->{$item}[0]->description ) { ?>
							<span class="DescriptionTip" title="<?php echo $jSeblod->{$item}[0]->label; ?>::<?php echo $jSeblod->{$item}[0]->tooltip; ?>">
								<img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
							</span>
							<?php } ?>
						<?php } ?>
						</td>
                        <?php } ?>
                         <?php if ( $displayLabel ) { ?>
						<td width="140" <?php echo ( ! ( $jSeblod->{$item}[0]->light || $jSeblod->{$item}[0]->display == 3 ) ) ? 'cck_label' : 'class="key cck_label"'; ?>>
						<?php if ( $jSeblod->{$item}[0]->display == 3 || $jSeblod->{$item}[0]->display == 2 ) { ?>
							<label for="<?php echo $jSeblod->{$item}[0]->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.'"'; } ?>><?php echo ( $jSeblod->{$item}[0]->label ) ? $jSeblod->{$item}[0]->label . $labelSeparator : ''; ?></label>
						<?php } ?>
						</td>
                        <?php } ?>
						<td class="cck_field">
                        <?php for ( $i2 = 0, $n2 = count( $jSeblod->$item ); $i2 < $n2; $i2++ ) { ?>
							<?php echo @$jSeblod->{$item}[$i2]->codebefore; ?>
                            <span class="<?php echo $jSeblod->{$item}[$i2]->name.'_'.$i2; ?>">
							<?php echo CCK_CONTENT_DefaultContent( @$jSeblod->{$item}[$i2]->value, @$jSeblod->{$item}[$i2], true ); ?>
                            </span>
							<?php
                            if ( @$jSeblod->{$item}[0]->content != '' && @$jSeblod->{$item}[0]->cols && ( ($i2+1) % $jSeblod->{$item}[0]->cols ) == 0 ) {
                                echo @$jSeblod->{$item}[0]->content;
                            }
                            ?>
							<?php echo @$jSeblod->{$item}[$i2]->codebefore; ?>
						<?php } ?>
						</td>
					
				<?php } else { echo $jSeblod->{$item}[$i2]->value; }?>
				<?php } ?>
				</tr>
			<?php } ?>
   
   		<?php } ?>
		<?php } else { ?>

		<!-- Field Types (Var)-->
		<?php if ( $jSeblod->$item->display == -3 ) {
				if ( $animPanels ) {
					echo '</table>';
					if ( $panelId == 0 ) {
						echo '<br />';
						$objPanel =& JPane::getInstance( 'sliders', array( 'startOffset' => 0, 'startTransition' => 0 ) ); 
						echo $objPanel->startPane( 'panel_'.$jSeblod->$item->name );
						echo $objPanel->startPanel( $jSeblod->$item->label, 'panel'.$panelId );
						echo '<table class="admintable">';
					} else {
						if ( $subPanelId > 0 ) {
							echo $objSubPanel->endPanel();
							echo $objSubPanel->endPane();	//
							echo '</table>';
							$subPanelId = -1;
						}
						echo $objPanel->endPanel().'<br />';
						echo $objPanel->startPanel( $jSeblod->$item->label, 'panel'.$panelId );
						echo '<table class="admintable">';
					}
					$panelId++;
				} else {
					echo '<tr><td colspan="3"><h3>'.$jSeblod->$item->label.'</h3></td></tr>';
				}
			} else if ( $jSeblod->$item->display == -2 ) {
				if ( $animPanels ) {
					if ( $subPanelId == 0 ) {
						echo '</table>';
						$objSubPanel =& JPane::getInstance( 'tabs', array( 'startOffset' => 0 ) );	//!! $objSubPanel =& JPane::getInstance( 'tabs', array( 'startOffset' => 1 ) ); 
						echo $objSubPanel->startPane( 'panel_'.$jSeblod->$item->name );
						echo $objSubPanel->startPanel( $jSeblod->$item->label, 'subpanel'.$subPanelId );
						echo '<table class="admintable">';
					} else {
						echo '</table>';
						echo $objSubPanel->endPanel();					
						if ( $jSeblod->$item->bool2 ) {
							$subClosed	=	1;
							echo $objSubPanel->endPane();
							echo '<br />';
						} else {
                           	echo $objSubPanel->startPanel( $jSeblod->$item->label, 'subpanel'.$subPanelId );
						}
						echo '<table class="admintable">';
					}
					$subPanelId++;
				} else {
					echo '<br />';
				}
			} else { ?>
				<?php $colspan = 0; ?>
				<?php if ( $jSeblod->$item->display != -1 ) { ?>
				<?php if ( $jSeblod->$item->displayfield == 0 || ( $jSeblod->$item->displayfield == 1 && $client->id ) || ( $jSeblod->$item->displayfield == 2 && !$client->id ) ) { ?>
					<tr> 
                    	<?php if ( $displayTooltip ) { ?>
						<td width="25" <?php echo ( ! ( $jSeblod->$item->light || $jSeblod->$item->display == 3 ) ) ? '' : 'class="key_balloon"'; ?>>
						<?php if ( $jSeblod->$item->light ) { ?>
							<?php if ( $jSeblod->$item->description ) { ?>
							<span class="DescriptionTip" title="<?php echo $jSeblod->$item->label; ?>::<?php echo $jSeblod->$item->tooltip; ?>">
								<img src="<?php echo $path.'/images/'.$tooltipIcon; ?>" alt=" " />
							</span>
							<?php } ?>
						<?php } ?>
						</td>
                        <?php } ?>
                        <?php if ( $displayLabel ) { ?>
						<td width="140" <?php echo ( ! ( $jSeblod->$item->light || $jSeblod->$item->display == 3 ) ) ? 'class="cck_label"' : 'class="key cck_label"'; ?>>
						<?php if ( $jSeblod->$item->display == 3 ||  $jSeblod->$item->display == 2 ) { ?>
							<label for="<?php echo $jSeblod->$item->name; ?>" <?php if ( $labelColor ) { echo 'style="color: '.$labelColor.'"'; } ?>><?php echo ( $jSeblod->$item->label ) ? $jSeblod->$item->label . $labelSeparator : ''; ?></label>
						<?php } ?>
						</td>
                        <?php } ?>
						<td class="cck_field">
							<?php echo @$jSeblod->$item->codebefore; ?>
							<?php echo CCK_CONTENT_DefaultContent( @$jSeblod->$item->value, @$jSeblod->$item, false ); ?>
							<?php echo @$jSeblod->$item->codeafter; ?>
						</td>
					</tr>
				<?php } else { echo $jSeblod->$item->value; }?>
				<?php } ?>
		<?php } } ?>
	
<?php } } ?>
</table>
<?php
if ( $subPanelId && $animPanels && ! $panelId && ! @$subClosed ) {
	echo $objSubPanel->endPanel();
	echo $objSubPanel->endPane();
}
if ( $panelId && $animPanels ) {
	echo $objPanel->endPanel();
	echo $objPanel->endPane();
}
?>
	
<?php endif;
/**
 * End
 **/
?>